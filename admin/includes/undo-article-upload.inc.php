<?php
    session_start();
    ob_start();
    //check if logged in
    if(!isset($_SESSION['admin_id'])){
        header ("Location: ../login?error=unauthorized");
    }
    include('../../config.php');

    //validate CSRF TOKEN
    if($_POST['csrf_token'] != $_SESSION['csrf_token']){
        header ("Location:../upload-article?error=500");
        exit();
    }

    $article_id = mysqli_real_escape_string($conn, $_POST['article_id']);

    //-----Check if form datas are not filled-----
        if (empty($article_id)) {
        header ("Location:../upload-article?error=empty");
        exit();
    }
    //-----End Check if form datas are not filled-----

    else {
        $sql = "DELETE from articles WHERE article_id = '$article_id'";
        $result = $conn->query($sql);            
        if($conn->affected_rows > 0){
            header("location: ../upload-article?success=removed");
        }else {
            header ("Location:../upload-article?error=500");
            exit();
        }
    }
?>