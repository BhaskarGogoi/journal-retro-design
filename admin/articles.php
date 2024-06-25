<?php
    include("includes/admin-head.php");
?>
<title>Articles</title>
</head>


<body>
    <?php
         //check if logg    edin
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
                        $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        if (strpos($url, 'error=empty')!== false) {
                            echo "
                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>    
                                Fill out all the fields!
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>";
                        } elseif (strpos($url, 'error=submit')!== false) {
                            echo "
                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>  
                                Something Went Wrong!
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
                        elseif (strpos($url, 'success=deleted')!== false) {
                            echo "
                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>    
                                Article Deleted!
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>";
                        }

                        //for pagination    
                      
                        $sql = "SELECT * FROM journals";         
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            echo "Error";
                        } else {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            if($result->num_rows > 0 ){
                                $record = $result->num_rows;
                                $per_page = 20;
                                $page = 0;
                                $current_page = 1;
                                $pagi = ceil($record/$per_page);
                                if(isset($_GET['page'])){
                                    $page = $_GET['page'];
                                    if($page <= 0){
                                        $page = 0;
                                        $current_page = 1;
                                    } else {
                                        $current_page = $page;
                                        $page--;
                                        $page = $page * $per_page;
                                    }
                                }                            
                            } else {
                                $page = 0;
                                $per_page = 0;
                            }
                        }
                    ?>
                </div>
                <div class="row mb-5">
                    <?php
                        $pagination = TRUE;
                        $sql = "SELECT * FROM articles WHERE journal_id = $_GET[journal_id] ORDER BY article_id DESC LIMIT $page,$per_page";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            $pagination = FALSE;   
                            echo "Error";
                        } else {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            if($result->num_rows > 0 ){
                                echo "
                                    <div style='width: 100%; margin-bottom: 20px;'>
                                    <h5 style='display: inline-block;' class='card-title'>Articles</h5>
                                    </div>
                                    <table class='table table-striped'>
                                        <thead>
                                            <tr>
                                                <th scope='col'>Article ID</th>
                                                <th scope='col'>Title</th>
                                                <th scope='col'>Author</th>
                                                <th scope='col'>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                
                                        
                                        while($row = mysqli_fetch_assoc($result)) {  
                                            echo "
                                                <tr>
                                                    <th>$row[article_id]</th>
                                                    <td>$row[title]</td>
                                                    <td>$row[author]</td>
                                                    <td>
                                                        <div style='display:flex; justify-content: center; align-items:center;'>
                                                        <a href='../Archive/$row[filename]' download >
                                                            <button class='btn-sm btn-primary' title='Download' ><i class='fas fa-arrow-alt-circle-down'></i></button>
                                                        </a>
                                                        <form action='includes/delete-article.inc' method='POST'  style='margin-left: 5px;'>
                                                        <input type='hidden' name='article_id' value='$row[article_id]' required>
                                                        <input type='hidden' name='journal_id' value='$_GET[journal_id]' required>
                                                        <button  type='submit' name='submit' class='btn-sm btn-danger' title='Delete'><i class='fas fa-trash-alt'></i></button>                                                          
                                                        </form>
                                                        <a href='move-article?article_id=$row[article_id]' style='flex: 1; margin-left: 5px;'><button class='btn-sm btn-primary' title='Move'><i class='fas fa-arrow-circle-right'></i></button></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            ";           
                                        }  
                                    echo "</tbody>
                                    </table>";                            
                            } else {
                                $pagination = FALSE; 
                                echo "<br>Not Found!<br>";
                            }
                        }
                    ?>

                    <nav class='mt-3' style="margin: auto;">
                        <ul class="pagination">
                            <?php  
                                if($pagination == TRUE){
                                    if($pagi != 1){
                                        for($i = 1; $i<=$pagi; $i++){
                                            if($current_page == $i){
                                                echo "<li class='page-item active'><span class='page-link'>$i</span></li>";
                                            } else {
                                                echo "<li class='page-item'><a class='page-link' href='?journal_id=$_GET[journal_id]&page=$i'>$i</a></li>";
                                            }
                                        }
                                    }
                                }                                
                            ?>
                        </ul>
                    </nav>
                </div>

                <div class="row mb-5">
                    <?php
                        $sql = "SELECT filename FROM journals WHERE journal_id = $_GET[journal_id]";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            echo "Error";
                        } else {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            if($result->num_rows > 0 ){
                                echo "
                                    <div style='width: 100%; margin-bottom: 10px;'>
                                        <h5 style='display: inline-block;' class='card-title'>Complete Journal</h5>
                                    </div>
                                ";

                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Check if the filename is NULL
                                    if (is_null($row['filename'])) {
                                        echo "Complete Journal Not Uploaded Yet.";
                                    } else {
                                        echo "
                                    
                                            <table class='table table-striped'>
                                                <thead>
                                                    <tr>
                                                        <th scope='col'>Filename</th> 
                                                        <th scope='col'>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        <tr>
                                                            <th>$row[filename]</th>
                                                            <td>
                                                                <div style='display:flex; justify-content: center; align-items:center;'>
                                                                <a href='../Archive/complete-journals/$row[filename]' download >
                                                                    <button class='btn-sm btn-primary' title='Download' ><i class='fas fa-arrow-alt-circle-down'></i></button>
                                                                </a>
                                                                <form action='includes/delete-complete-journal.inc' method='POST'  style='margin-left: 5px;'>
                                                                
                                                                    <input type='hidden' name='journal_id' value='$_GET[journal_id]' required>
                                                                    <button  type='submit' name='submit' class='btn-sm btn-danger' title='Delete'><i class='fas fa-trash-alt'></i></button>                                                          
                                                                </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                            </table>";
                                    }
                                }                            
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