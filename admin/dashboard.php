<?php
    include("includes/admin-head.php");
?>
<title>Dashboard</title>
</head>

<body>
    <?php
         //if logged in redirect to dashboard
        if(!(isset($_SESSION['admin_id']) )){
            header ("Location: login?error=unauthorized");
        }
        include('includes/sidebar.inc.php');
        include ('../config.php');
    ?>
    <div class="main">
        <?php
            include('includes/header.php');
        ?>
        <div class='main-content'>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card shadow-sm" style="width: 100%; background-color: #8EC5FC;
                            background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%); color: #fff;
                            ">
                            <div class="card-body">
                                <?php
                                    $sql = "SELECT COUNT(*) AS journal_count FROM journals WHERE status = 'Published';";
                                    $stmt = mysqli_stmt_init($conn);
                                    if(!mysqli_stmt_prepare($stmt, $sql)){
                                        echo "Error";
                                    } else {
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);
                                        $row = mysqli_fetch_assoc($result);   
                                        echo "
                                            <h2 class='card-title color-white'>$row[journal_count] <span class='float-right'><i
                                            class='fas fa-book'></i></span>";
                                        
                                    }
                                ?>
                                </h2>
                                <hr>
                                <span class='color-white'>Published Journals</span>
                                <span class='float-right'><a href="//<?php echo $http_host; ?>/admin/journals"
                                        class='color-white'>See All <i class="fas fa-arrow-circle-right"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card shadow-sm" style="width: 100%; background-color: #0093E9;
                            background-image: linear-gradient(160deg, #0093E9 0%, #80D0C7 100%); color: #fff;
                            ">
                            <div class="card-body">
                                <?php
                                    $sql = "SELECT COUNT(*) as article_count FROM articles";
                                    $stmt = mysqli_stmt_init($conn);
                                    if(!mysqli_stmt_prepare($stmt, $sql)){
                                        echo "Error";
                                    } else {
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);
                                        $row = mysqli_fetch_assoc($result);         
                                        echo "
                                            <h2 class='card-title color-white'>$row[article_count]<span class='float-right'><i class='fas fa-pen-nib'></i></span>
                                            </h2>
                                        ";                                       
                                    }
                                ?>
                                <hr>
                                <span class='color-white'>Total Articles</span>

                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-sm-4">
                        <div class="card shadow-sm" style="width: 100%; background-color: #4489f5;
                            background-image: linear-gradient(62deg, #4489f5 0%, #eee3fc 100%);
                            ">
                            <div class="card-body">
                                <?php
                                    $sql = "SELECT * FROM student;";
                                    $stmt = mysqli_stmt_init($conn);
                                    if(!mysqli_stmt_prepare($stmt, $sql)){
                                        echo "Error";
                                    } else {
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);
                                        if($result->num_rows > 0 ){
                                        $row = mysqli_fetch_assoc($result);         
                                            echo "
                                            <h2 class='card-title color-white'>$result->num_rows <span class='float-right'><i
                                                class='fas fa-user-graduate'></i></span>
                                            </h2>
                                            ";                                            
                                        } 
                                    }
                                ?>
                                <hr>
                                <span class='color-white'>Total Students</span>
                                <span class='float-right'><a href="<?php echo $http_host; ?>/library/students"
                                        class='color-white'>See All
                                        <i class="fas fa-arrow-circle-right"></i></a>
                                </span>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="row mt-5">
                    <div class="col-sm-4">
                        <div class="card shadow" style="width: 100%;">
                            <div class="card-body">
                                <h5 class="card-title">Top 5 Viewed Articles</h5>
                                <hr>
                                <?php
                                    $sql = "SELECT * FROM articles ORDER BY unique_visitors DESC LIMIT 5";
                                    $stmt = mysqli_stmt_init($conn);
                                    if(!mysqli_stmt_prepare($stmt, $sql)){
                                        return 0;
                                    } else {
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);
                                        if($result->num_rows > 0 ){
                                            while($row = mysqli_fetch_assoc($result)){
                                                echo "<p class='dash-list'>
                                                        <a href='$http_host/article?id=$row[article_id]' target='_blank'>$row[title]</a>
                                                        <span class='counter'>$row[unique_visitors]</span>
                                                    </p>" ;                               
                                            }                                     
                                        } else {
                                            echo "Not Data!";
                                        }
                                    }                        
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-sm-4">
                        <div class="card shadow" style="width: 100%;">
                            <div class="card-body">
                                <h5 class="card-title">Top 5 Borrowed Books</h5>
                                <hr>
                                <?php
                                    $sql = "SELECT * FROM books ORDER BY borrowed_count DESC LIMIT 5";
                                    $stmt = mysqli_stmt_init($conn);
                                    if(!mysqli_stmt_prepare($stmt, $sql)){
                                        return 0;
                                    } else {
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);
                                        if($result->num_rows > 0 ){
                                            while($row = mysqli_fetch_assoc($result)){
                                                echo "<p><i class='far fa-hand-point-right'></i> $row[title]
                                                 <span class='badge badge-violet'>$row[borrowed_count]</span></p>" ;                               
                                            }                                     
                                        } else {
                                            echo "Not Data!";
                                        }
                                    }                        
                                ?>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>