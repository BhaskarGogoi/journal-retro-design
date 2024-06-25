<?php
    session_start();
    ob_start();
	if (isset($_POST['submit'])) {

        include('../../config.php');

		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);

		//-----Check if form datas are not filled-----
         if (empty($email) ||empty($password)) {
			header ("Location:../login?error=empty");
			exit();
        }
		//-----End Check if form datas are not filled-----

		else {
            //validate CSRF TOKEN
			if($_POST['csrf_token'] != $_SESSION['csrf_token']){
			    header ("Location:../login?error=500");
                exit();
            } else {
                //check if email is valid
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    header ("Location:../login?error=email-invalid");
                    exit();
                }
                else {                       
                    $sql = "SELECT * FROM admin WHERE email = ?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header ("Location:../login?error=500");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $email);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);
                        if(!$row){
                            header ("Location:../login?error=not-found");
                            exit();
                        } else {
                            $hash_password = $row['password'];
                            $dehash = password_verify($password, $hash_password);
                            if ($dehash == 0) {
                                header ("Location:../login?error=incorrect");
                                exit();
                            }
                            //-----End Check For Hash Password and Dehash----- 
                            else {
                                $sql = "SELECT * FROM admin WHERE email = ?  AND password = ? ";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                    header ("Location:../login?error=500");
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "ss", $email, $hash_password);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                    $row = mysqli_fetch_assoc($result);
                                    if (!$row) {
                                        header ("Location:../login?error=incorrect");
                                        exit();
                                    } else {
                                       
                                        $_SESSION['admin_id'] = $row['id'];
                                        $_SESSION['firstname'] = $row['firstname'];
                                        header ("Location: ../dashboard");
                                    }
                                }
                            }
                        }
                    }			
                }
            }
        }
	} else {
		header ("Location:../login?error=submit");
		exit();
	}
?>