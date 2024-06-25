<?php
    include("includes/admin-head.php");
?>
<script type="text/javascript" src="../js/plupload.full.min.js"></script>
<title>Upload Article</title>
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
                        if (isset($_GET['success']) && $_GET['success'] == 'uploaded') {
                            echo '<div class="message success">File uploaded successfully!</div>';
                        } elseif (isset($_GET['error'])) {
                            echo '<div class="message error">There was an error uploading the file. Please try again.</div>';
                        }
                    ?>
                    <div class="card shadow" style="margin:auto; width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Upload Article</h5>
                            <form action="includes/upload-article2.inc.php" method='post' enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>Title Of The Article</label>
                                    <input type="text" name='title' id='title' onkeyup="validateInput()"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Author(s)</label>
                                    <small class="form-text text-muted mb-1">In case of multiple authors, seperate them
                                        using
                                        comma. (Eg. Author 1, Author 2)</small>
                                    <input type="text" name='author' id='author' class="form-control"
                                        onkeyup="validateInput()">
                                </div>
                                <div class="form-group">
                                    <label>Select Journal</label>
                                    <select id='journal_id' name='journal_id' class="form-control" required>
                                        <?php
                                                $sql = "SELECT * FROM journals WHERE status='Not Published' ORDER BY journal_id DESC";
                                                $stmt = mysqli_stmt_init($conn);
                                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                                    echo "Error";
                                                } else {
                                                    mysqli_stmt_execute($stmt);
                                                    $result = mysqli_stmt_get_result($stmt);
                                                    if($result->num_rows > 0 ){                              
                                                        while($row = mysqli_fetch_assoc($result)) {  
                                                            echo "
                                                            <option value='$row[journal_id]'>$row[title]</option>";                                                            
                                                        } 
                                                    }
                                                }
                                            ?>
                                    </select>
                                </div>
                                <!-- <span id="filelist" style='list-style: none;'></span>
                                <br /> -->
                                <input type="file" name="pdfFile" id="pdfFile" accept=".pdf"> <br>
                                <button class='btn btn-primary shadow mt-4' type="submit">Submit</button>

                                <!-- <div id="container">
                                    <a id="browse" href="javascript:;"><i class="fas fa-file-upload"></i> Select File</a>
                                    <a id="start-upload" href="javascript:;"><i class="fas fa-upload"></i> Upload</a>
                                </div> -->

                                <br />
                            </form>
                            <pre id="console"></pre>
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