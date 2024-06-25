<?php
    include("includes/admin-head.php");
?>
<title>Journals</title>
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
                    <!-- Modal -->
                    <div class="modal fade" id="addJournalsModal" tabindex="-1" aria-labelledby="addJournalsModal"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Journal</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action='includes/add-journal.inc' method='POST'>
                                        <input type="hidden" name='csrf_token' value='<?php echo $csrf_token; ?>'>
                                        <div class="form-group">
                                            <label>Title Of The Journal</label>
                                            <input type="text" name='title' class="form-control">
                                        </div>
                                        <button type="submit" name='submit' class="btn btn-primary">Add</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        elseif (strpos($url, 'success=submitted')!== false) {
                            echo "
                            <div class='alert alert-success alert-dismissible fade show' role='alert'>    
                                Successfully Added!
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>";
                        } elseif (strpos($url, 'success=unpublished')!== false) {
                            echo "
                            <div class='alert alert-success alert-dismissible fade show' role='alert'>    
                                Journal Un-Published!
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>";
                        } elseif (strpos($url, 'success=published')!== false) {
                            echo "
                            <div class='alert alert-success alert-dismissible fade show' role='alert'>    
                                Journal Published!
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>";
                        } elseif (strpos($url, 'success=deleted')!== false) {
                            echo "
                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>    
                                Journal Deleted!
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
                    <div class="card" style="margin:auto; width: 100%; border:none;">
                        <div class="card-body">
                            <button class="float-right btn btn-primary shadow" data-toggle="modal"
                                data-target="#addJournalsModal">Add Journal</button>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <?php
                        $pagination = TRUE;
                        $sql = "SELECT * FROM journals ORDER BY journal_id DESC LIMIT $page,$per_page";
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
                                    <h5 style='display: inline-block;' class='card-title'>Journals</h5>
                                    </div>
                                    <table class='table table-striped'>
                                        <thead>
                                            <tr>
                                                <th scope='col'>Journal ID</th>
                                                <th scope='col'>Title</th>
                                                <th scope='col'>Created Date</th>
                                                <th scope='col'>Published Date</th>
                                                <th scope='col'>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                
                                        
                                        while($row = mysqli_fetch_assoc($result)) {  
                                            $date = date("d-m-Y", strtotime($row["date"]));
                                            echo "
                                                <tr>
                                                    <th>$row[journal_id]</th>
                                                    <td><a href='articles?journal_id=$row[journal_id]'>$row[title]</a></td>
                                                    <td>$date</td>
                                                    <td>$row[published_date]</td>
                                                    <td>";
                                                    
                                                    if($row['status'] == "Not Published"){
                                                        echo "
                                                            <div style='display:flex; flex-direction: row'>
                                                                <form action='includes/journal-actions.inc' method='POST'>
                                                                    <input type='hidden' name='journal_id' value='$row[journal_id]' required>
                                                                    <input type='hidden' name='action' value='Publish' required>
                                                                    <button class='btn-sm btn-success' title='Publish' type='submit' name='submit'><i class='fas fa-check-circle'></i></button>                                                            
                                                                </form>
                                                                <form action='includes/journal-actions.inc' method='POST' style='flex: 1; margin-left: 5px;'>
                                                                    <input type='hidden' name='journal_id' value='$row[journal_id]' required>
                                                                    <input type='hidden' name='action' value='Delete' required>
                                                                    <button  type='submit' name='submit' class='btn-sm btn-danger' title='Delete'><i class='fas fa-trash-alt'></i></button>                                                          
                                                                </form>
                                                            </div>";
                                                    } else if($row['status'] == "Published"){
                                                        echo "
                                                            <div style='display:flex; flex-direction: row'>
                                                                <form action='includes/journal-actions.inc' method='POST'>
                                                                    <input type='hidden' name='journal_id' value='$row[journal_id]' required>
                                                                    <input type='hidden' name='action' value='UnPublish' required>
                                                                    <button class='btn-sm btn-warning' title='Un Publish' type='submit' name='submit'><i class='fas fa-ban'></i></button> 
                                                                </form>
                                                                <form action='includes/journal-actions.inc' method='POST' style='flex: 1; margin-left: 5px;'>
                                                                    <input type='hidden' name='journal_id' value='$row[journal_id]' required>
                                                                    <input type='hidden' name='action' value='Delete' required>
                                                                    <button type='submit' name='submit' class='btn-sm btn-danger' title='Delete'><i class='fas fa-trash-alt'></i></button>                                                          
                                                                </form>
                                                            </div>
                                                            ";
                                                    } else {
                                                        echo "Error";
                                                    }
                                                    echo "
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
                                                echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
                                            }
                                        }
                                    }
                                }                                
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    </div>
</body>

</html>