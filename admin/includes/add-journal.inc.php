<?php
	session_start();
    ob_start();
	if (isset($_POST['submit'])) {
		//check if logged in
		if(!(isset($_SESSION['admin_id']))){
            header ("Location: ../login?error=unauthorized");
        }

		//validate CSRF TOKEN
		if($_POST['csrf_token'] != $_SESSION['csrf_token']){
            header ("Location:../journals?error=500");
            exit();
        }

		include '../../config.php';

		$title = mysqli_real_escape_string($conn, $_POST['title']);

		//-----Check if form datas are not filled-----
         if (empty($title) ) {
			header ("Location:../journals?error=empty");
			exit();
        }
		//-----End Check if form datas are not filled-----

		else {
                
            $sql = "INSERT INTO journals (title)
            VALUES (?);";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header ("Location:../journals?error=500");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $title);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($conn->affected_rows > 0){
                    header ("Location:../journals?success=submitted");
                    exit();
                }else {
                    header ("Location:../journals?error=500");
                    exit();
                }  
            }	
                
            
		}
	} else {
		header ("Location:../journals?error=submit");
		exit();
	}
?>