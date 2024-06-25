<?php
	session_start();
	if (isset($_POST['submit'])) {

		include('../../config.php');

		$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
		$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$c_password = mysqli_real_escape_string($conn, $_POST['c_password']);
		$phone = mysqli_real_escape_string($conn, $_POST['phone']);

		//-----Check if form datas are not filled-----
        if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($password) || empty($c_password)) {
			header ("Location:../register?error=empty");
			exit();
        }

		// Validate password strength
		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);
		$specialchars = preg_match('@[^\w]@', $password);
		
		if(!$uppercase || !$lowercase || !$number || !$specialchars || strlen($password) < 8) {
			header ("Location:../register?error=password");
			exit();
		}

		if(!preg_match('/^[0-9]{10}+$/', $phone)) {
			header ("Location:../register?error=phone");
			exit();
		} 

		//-----End Check if form datas are not filled-----

		else {
			 //validate CSRF TOKEN
			 if($_POST['csrf_token'] != $_SESSION['csrf_token']){
			    header ("Location:../register?error=500");
                exit();
            } else {
				if($password != $c_password){
					header ("Location:../register?error=password-mismatched");
					exit();
				} else {
					//check if email is valid
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						header ("Location:../register?error=email-invalid");
						exit();
					}
					else {
						//-----Check if email is already exists----- 
	
						$sql = "SELECT * FROM admin WHERE email = '$email'";
						$result = $conn->query($sql);
						$emailCheck = mysqli_num_rows($result);
	
						if ($emailCheck > 0) {
							header ("Location:../register?error=already-exists");
							exit();
						}
						//-----End Check if username or email is already exists-----
						else {
							$encrypted_password = password_hash($password, PASSWORD_DEFAULT); //hashing password
	
							$sql = "INSERT INTO admin ( firstname, lastname, email, phone, password)
							VALUES (?, ?, ?, ?, ?);";
							$stmt = mysqli_stmt_init($conn);
							if(!mysqli_stmt_prepare($stmt, $sql)){
								header ("Location:../register?error=500");
								exit();
							} else {
								mysqli_stmt_bind_param($stmt, "sssss", ucfirst($firstname), ucfirst($lastname), strtolower($email), $phone, $encrypted_password);
								mysqli_stmt_execute($stmt);
								$result = mysqli_stmt_get_result($stmt);
								if($conn->affected_rows > 0){
									header ("Location:../register?success=registered");
									exit();
								}else {
									header ("Location:../register?error=500");
									exit();
								}  
							}	
						}
					}
				}
			}
		}
	} else {
		header ("Location:../register?error=submit");
		exit();
	}
?>