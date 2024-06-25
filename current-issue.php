<?php
    include 'includes/head.php';
    include 'config.php';
?>
<title>Current Issue</title>
</head>

<body>
    <?php
     include 'includes/navbar.php';
    ?>

    <section class='py-3 height-wrapper' style='background-color: #FAFAFA'>
        <div class="container">
            <div class="row my-5">
                <div class='page-title-btn'>
                    <?php

                    //get the current journal info
                    $sql = "SELECT * FROM journals WHERE status = 'Published' ORDER BY journal_id DESC LIMIT 1";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){   
                        echo "Error";
                    } else {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if($result->num_rows > 0 ){
                            $row = mysqli_fetch_assoc($result);
                            echo "
                            <h3 class='color-brown'><b>$row[title]</b></h3>";

                            $is_full_journal_available = 0;
                            $sql = "SELECT filename FROM journals WHERE journal_id = $row[journal_id]";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                                echo "Error";
                            } else {
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                if($result->num_rows > 0 ){                
                                    while ($row2 = mysqli_fetch_assoc($result)) {
                                        // Check if the filename is NULL
                                        if (!is_null($row2['filename'])) {
                                            $is_full_journal_available = 1;
                                            $filename = $row2['filename'];
                                            echo "
                                                <a href='Archive/complete-journals/$filename' download class='button' target='_blank'>Download Journal</a>
                                            ";
                                        }
                                    }
                                }
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <hr>
            <div class="row mt-5">
                <?php
                    //get the articles from current journal
                    $sql = "SELECT articles.title,articles.author, articles.article_id FROM articles JOIN journals ON articles.journal_id = journals.journal_id 
                    WHERE journals.journal_id = '$row[journal_id]' ORDER BY article_id ASC";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){   
                        echo "Error";
                    } else {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if($result->num_rows > 0 ){
                            while($row = mysqli_fetch_assoc($result)){
                            echo "                              
                                <div class='col-sm-4 mt-3'>
                                    <div class='card py-3 article-card'>
                                        <div class='card-body'>
                                            <div class='title'>
                                                <center>
                                                    <h6><b>$row[title]</b></h6>
                                                </center>
                                            </div><br>
                                            
                                            <center><i class='fa-solid fa-pen-nib'></i> $row[author]</center> <br>
                                            <center>
                                                <a href='article?id=$row[article_id]'><button
                                                        class='issue-card-btn'>Read</button></a>
                                            </center>
                                        </div>
                                    </div>
                                </div>";
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