<?php
    include 'includes/head.php';
    include 'config.php';

?>
<title>Archives</title>
</head>

<body>
    <?php
     include 'includes/navbar.php';
    ?>

    <section class='p-3 height-wrapper' style='background-color: #FAFAFA'>
        <div class="container">
            <div class="row mt-5">
                <h3 class='color-brown'><b>Archives</b></h3>
            </div>
            <hr>
            <div class="row mt-5">
                <?php
                    //get the current journal info
                    $sql = "SELECT * FROM journals WHERE status = 'Published' ORDER BY journal_id DESC ";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){   
                        echo "Error";
                    } else {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if($result->num_rows > 0 ){
                            $currentIssue = true;
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<div class='archive-list'>
                                        <a href='articles?journal_id=$row[journal_id]'>
                                            $row[title] - $row[published_date]";
                                            if($currentIssue){
                                                echo " (Current Issue)";
                                            }
                                        echo"
                                        </a>
                                    </div>";
                                $currentIssue =  false;
                            }                            
                        }
                    }
                ?>

            </div>
            <br> <br> <br>
    </section>

    <?php
    include 'includes/footer.php';
?>
</body>

</html>