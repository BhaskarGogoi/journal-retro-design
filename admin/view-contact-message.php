<?php
    include("includes/admin-head.php");
?>
<title>View Contact Messages</title>
</head>

<body>
    <?php
         //check if loggedin
         if(!(isset($_SESSION['admin_id']))){
            header ("Location: login?error=unauthorized");
        }
        include('includes/sidebar.inc.php');
    ?>
    <div class="main">
        <?php
            include('includes/header.php');
        ?>
        <div class='main-content'>
            <div class="container mt-5">
                <div class="row mb-5">
                    <?php
                        $sql = "SELECT * FROM contact_msg WHERE id = '$_GET[id]'";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            $pagination = FALSE;   
                            echo "Error";
                        } else {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            if($result->num_rows > 0 ){
                                $row = mysqli_fetch_assoc($result);
                                echo "
                                    <div class='card shadow' style='width: 100%;'>
                                        <div class='card-body'>
                                            <h5 class='card-title'>Message</h5>
                                            <p class='card-text'>
                                                <b>Name:</b> $row[name]<br>
                                                <b>Email:</b> $row[email]<br>
                                                <b>Date:</b> $row[date]<br>
                                            </p>
                                            <p><b>Message:</b> $row[message]</p>
                                        </div>
                                    </div>";                           
                            } else {
                                echo "<br>Not Found!<br>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    </div>
</body>

</html>