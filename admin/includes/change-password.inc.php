<?php
	session_start();
	if (isset($_POST['submit'])) {

		include('../../config.php');

		$old_password = mysqli_real_escape_string($conn, $_POST['old_password']);
		$new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
		$confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

		//-----Check if form datas are not filled-----
        if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
			header ("Location:../change-password?error=empty");
			exit();
        }

		// Validate password strength
		$uppercase = preg_match('@[A-Z]@', $new_password);
		$lowercase = preg_match('@[a-z]@', $new_password);
		$number    = preg_match('@[0-9]@', $new_password);
		$specialchars = preg_match('@[^\w]@', $new_password);
		
		if(!$uppercase || !$lowercase || !$number || !$specialchars || strlen($new_password) < 8) {
			header ("Location:../change-password?error=password");
			exit();
        }

		//-----End Check if form datas are not filled-----

		else {
			
            if($new_password != $confirm_password){
                header ("Location:../change-password?error=password-mismatched");
                exit();
            } else {

                // $_SESSION['admin_id']
                $sql = "SELECT * FROM admin WHERE id = ?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header ("Location:../change-password?error=500");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $_SESSION['admin_id']);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);
                    if(!$row){
                        header ("Location:../change-password?error=not-found");
                        exit();
                    } else {
                        $hash_password = $row['password'];
                        $dehash = password_verify($old_password, $hash_password);
                        if ($dehash == 0) {
                            header ("Location:../change-password?error=incorrect");
                            exit();
                        } else {
                            $encrypted_password = password_hash($new_password, PASSWORD_DEFAULT);
                            $sql = "UPDATE admin SET password = ? WHERE id = ?";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                                http_response_code(400);
                                die('{"response": "SQL Error"}');
                            } else {
                                mysqli_stmt_bind_param($stmt, "ss", $encrypted_password, $_SESSION['admin_id']);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                if($conn->affected_rows > 0){
                                    header ("Location:../change-password?success=changed");
                                    exit();
                                }else {
                                    header ("Location:../change-password?error=500");
                                    exit();
                                }  
                            }
                        }
                    }
                } 	
            }
		}
	} else {
		header ("Location:../change-password?error=submit");
		exit();
	}
?>