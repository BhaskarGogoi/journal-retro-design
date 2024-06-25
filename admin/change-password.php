<?php
    include("includes/admin-head.php");
?>
<script type="text/javascript" src="../js/plupload.full.min.js"></script>
<title>Change Password</title>
</head>

<body>
    <?php
         //if logged in redirect to dashboard
        if(!isset($_SESSION['admin_id'])){
            header ("Location: login?error=unauthorized");
        }
        include('includes/sidebar.inc.php');
        include('../config.php');

         //csrf token 
         $csrf_token = md5(uniqid(rand(), true));
         $_SESSION['csrf_token'] = $csrf_token;
    ?>
    <div class="main">
        <?php
            include('includes/header.php');
        ?>
        <div class='main-content'>
            <div class="container mt-5">
                <div class="row">
                    <?php
                        if (isset($_GET['success']) && $_GET['success'] == 'changed') {
                            echo '<div class="message success">Password Successfully Changed!</div>';
                        } elseif (isset($_GET['error']) && $_GET['error'] == 'empty') {
                            echo '<div class="message error">Fill out all the fields!</div>';
                        } elseif (isset($_GET['error']) && $_GET['error'] == 'password') {
                            echo '<div class="message error">Password Policy did not matched!</div>';
                        } elseif (isset($_GET['error']) && $_GET['error'] == 'password-mismatched') {
                            echo '<div class="message error">New Password & Confirm Password did not matched!</div>';
                        } elseif (isset($_GET['error']) && $_GET['error'] == '500') {
                            echo '<div class="message error">Something Went Wrong. Please Try Again</div>';
                        } elseif (isset($_GET['error']) && $_GET['error'] == 'not-found') {
                            echo '<div class="message error">Wrong Old Password!</div>';
                        } elseif (isset($_GET['error']) && $_GET['error'] == 'incorrect') {
                            echo '<div class="message error">Wrong Old Password</div>';
                        } 
                    ?>
                    <div class="card shadow mb-5" style="margin:auto; width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Change Password</h5>
                            <form action="includes/change-password.inc.php" method='post'>
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <input type="text" name='old_password' class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" name='new_password' class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="text" name='confirm_password' class="form-control" required>
                                </div>
                                <button class='btn btn-primary shadow mt-4' type="submit" name='submit'>Change</button>

                                <br />
                            </form>
                            <div class='password-policy'>
                                <h6>Password Policy</h6>
                                <p>
                                <ul>
                                    <li>Require at least one uppercase letter.</li>
                                    <li>Require at least one lowercase letter.</li>
                                    <li>Require at least one number.</li>
                                    <li>Require at least one special character.</li>
                                    <li>Minimum Password length should be greater than 8 characters. </li>
                                </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
        var title = "";
        var author = "";
        var journal_id = "";
        var progressBarId = "";

        document.getElementById("browse").style.display = "none";
        document.getElementById("start-upload").style.display = "none";

        function validateInput() {
            title = document.getElementById("title").value;
            // author = document.getElementById("author").value;
            journal_id = document.getElementById("journal_id").value;
            // if (title.length === 0 || author.length === 0) {
            if (title.length === 0) {
                document.getElementById("browse").style.display = "none";
                document.getElementById("start-upload").style.display = "none";
            } else {
                document.getElementById("browse").style.display = "inline-block";
                document.getElementById("start-upload").style.display = "inline-block";
            }
        }

        var uploader = new plupload.Uploader({
            browse_button: 'browse', // this can be an id of a DOM element or the DOM element itself
            url: 'includes/uploads-article.inc.php',
            chunk_size: '1000kb',
            filters: {
                mime_types: [{
                    title: "PDF Files",
                    extensions: "pdf"
                }],
                max_file_size: "100mb",
                prevent_duplicates: true,
            }
        });

        uploader.init();

        uploader.bind('FilesAdded', function(up, files) {
            var html = '';
            plupload.each(files, function(file) {
                html += '<li id="' + file.id + '">' + file.name + ' (' + plupload
                    .formatSize(file
                        .size) + ') <b></b></li>';
            });
            document.getElementById('filelist').innerHTML += html;
        });

        uploader.bind('UploadProgress', function(up, file) {
            progressBarId = file.id;
            document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' +
                file.percent +
                "% Please Wait!</span>";
        });

        uploader.bind('Error', function(up, err) {
            document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err
                .message;
            document.getElementById(progressBarId).getElementsByTagName('b')[0].innerHTML =
                "File Uploading Failed!";
            alert("File Uploading Failed!");
            location.reload();
        });

        uploader.bind("FileUploaded", function(up, file, object) {
            document.getElementById("title").value = "";
            document.getElementById("author").value = "";
            document.getElementById("browse").style.display = "none";
            document.getElementById("start-upload").style.display = "none";
            setTimeout(function() {
                alert("File Uploaded!");
                location.reload();
            }, 500);
        });

        uploader.bind('ChunkUploaded', function(up, file, info) {
            // do some chunk related stuff
        });

        document.getElementById('start-upload').onclick = function() {
            title = document.getElementById("title").value;
            author = document.getElementById("author").value;
            journal_id = document.getElementById("journal_id").value;
            uploader.bind('BeforeUpload', function(up, file) {
                uploader.settings.multipart_params.title = title;
                uploader.settings.multipart_params.author = author;
                uploader.settings.multipart_params.journal_id = journal_id;
            });
            uploader.start();

        };
        </script>
</body>

</html>