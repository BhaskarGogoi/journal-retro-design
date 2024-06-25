<?php
    include("includes/admin-head.php");
?>
<title>Move Article</title>
</head>


<body>
    <?php
         //check if loggedin
         if(!(isset($_SESSION['admin_id']))){
            header ("Location: login?error=unauthorized");
        }
        include('includes/sidebar.inc.php');

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
                        if(isset($_POST['submit'])){
                            $article_id = mysqli_real_escape_string($conn, $_POST['article_id']);
                            $journal_id = mysqli_real_escape_string($conn, $_POST['journal_id']);    
                            if (empty($article_id) ||empty($journal_id)) {
                                header ("Location: move-article?error=empty&article_id=$article_id");
                                exit();
                            }  else {
                                $sql = "UPDATE articles SET journal_id = ? WHERE article_id = ?";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                    echo "Error!";
                                } else {
                                    mysqli_stmt_bind_param($stmt, "ss", $journal_id, $article_id);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                    if($stmt->affected_rows > 0){
                                        header ("Location: move-article?success=moved&article_id=$article_id");
                                        exit();
                                    } else {
                                        header ("Location: move-article?error=500&article_id=$article_id");
                                        exit();
                                    }
                                }
                            }                    
                        } 

                        $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        if (strpos($url, 'error=empty')!== false) {
                            echo "
                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>    
                                Fill out all the fields!
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>";
                        } 
                        elseif (strpos($url, 'error=500')!== false) {
                            echo "
                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>    
                                Something Went Wrong!
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>";
                        }
                        elseif (strpos($url, 'success=moved')!== false) {
                            echo "
                            <div class='alert alert-success alert-dismissible fade show' role='alert'>    
                                Article Moved!
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>";
                        }
                    ?>
                </div>
                <div class="row mb-5">
                    <h5 class='my-5'>Move Article</h5>
                    <?php
                        $sql = "SELECT * FROM articles WHERE article_id = $_GET[article_id]";
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
                                        <h5 class='card-title'>$row[article_id] - $row[title]</h5>";
                                        $sql = "SELECT * FROM journals";
                                        $stmt = mysqli_stmt_init($conn);
                                        if(!mysqli_stmt_prepare($stmt, $sql)){
                                            $pagination = FALSE;   
                                            echo "Error";
                                        } else {
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);
                                            if($result->num_rows > 0 ){
                                                echo "
                                                <form action='' method='POST'>
                                                <input type='hidden' name='article_id' value='$_GET[article_id]'>
                                                    <select class='form-select' name='journal_id' style='width: 200px;' required>";
                                                    while($row = mysqli_fetch_assoc($result)){
                                                        echo "
                                                            <option value='$row[journal_id]'>$row[title]</option>
                                                        ";
                                                    }
                                                    echo"    
                                                    </select> <br> <br>                                                    
                                                    <button type='submit' name='submit' class='btn btn-primary'>Move</button>
                                                </form>";
                                            }
                                        }
                                    echo"
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