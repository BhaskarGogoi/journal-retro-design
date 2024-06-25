<?php
    include 'includes/head.php';
    include 'config.php';
?>
<title>Article</title>
</head>

<body>
    <?php
     include 'includes/navbar.php';
    ?>

    <section class='py-3 height-wrapper' style='background-color: #FAFAFA'>
        <div class="container">
            <?php
                $sql = "SELECT * FROM articles WHERE article_id = '$_GET[id]'";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){   
                    echo "Error";
                } else {
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if($result->num_rows > 0 ){
                        $row = mysqli_fetch_assoc($result);
                        echo "
                            <div class='row mt-5 mb-2'>
                                <div class='page-title-btn'>
                                    <h2>$row[title]</h2>
                                    <a href='Archive/$row[filename]' class='button' download>Download</a>
                                </div>
                            </div>";
                            
                            if($row['author'] != NULL){
                                echo "<p><i class='fa-solid fa-user-pen'></i> $row[author]</p>";
                            }
                            
                            echo"                                  
                            <div id='loader' style='text-align: center;'>
                                <img src='assets/img/loader.gif' alt='Loading...'>
                            </div>
        
                            <iframe class='article-iframe' id='iframe' src='https://docs.google.com/viewer?url=$http_host/Archive/$row[filename]&embedded=true' 
                                width='100%' style='dsplay: none;'>
                            </iframe>";
                    }
                }
            ?>
        </div>
        <br> <br> <br>
    </section>

    <?php
    include 'includes/footer.php';
?>
    <script>
    document.getElementById('iframe').onload = function() {
        document.getElementById('loader').style.display = 'none';
        document.getElementById('iframe').style.display = 'block';
    };
    </script>
</body>

</html>