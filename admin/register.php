<?php
    include '../config.php';
    include 'includes/admin-head.php';
?>
<title>Register</title>
</head>

<body class='auth-body'>

    <div class="auth-box my-4">
        <?php
					//csrf token 
					$csrf_token = md5(uniqid(rand(), true));
					$_SESSION['csrf_token'] = $csrf_token;

                    //if logged in redirect to dashboard
                    if(isset($_SESSION['admin_id'])){
                        header ("Location: dashboard");
                    }                   

					$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
					if (strpos($url, 'error=empty')!== false) {
						echo "
						<div class='alert alert-danger'>    
							Fill out all the fields!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
						</div>";
					} elseif (strpos($url, 'error=email-invalid')!== false) {
						echo "
						<div class='alert alert-danger'>    
							Please enter valid email address!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
						</div>";
					} elseif (strpos($url, 'error=already-exists')!== false) {
						echo "
						<div class='alert alert-danger'>    
							User already exists!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
						</div>";
					} elseif (strpos($url, 'error=submit')!== false) {
						echo "
						<div class='alert alert-danger'>    
							Something Went Wrong!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
						</div>";
					}
                    elseif (strpos($url, 'error=password-mismatched')!== false) {
						echo "
						<div class='alert alert-danger'>    
							Passwords mismatched!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
						</div>";
					}
                    elseif (strpos($url, 'error=500')!== false) {
						echo "
						<div class='alert alert-danger'>    
                            Something Went Wrong!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
						</div>";
					}
                    elseif (strpos($url, 'success=registered')!== false) {
						echo "
						<div class='alert alert-success alert-dismissible fade show'>    
							Successfully Registered!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
						</div>";
					} elseif (strpos($url, 'error=password')!== false) {
						echo "
						<div class='alert alert-danger alert-dismissible fade show'>    
							<b>Please Provde A Strong Password!</b> <br>
                            <ul>
                                <li>Must contain at least 8 characters.</li>
                                <li>Must contain at least one uppercase letter.</li>
                                <li>Must contain at least one lowercase letter.</li>
                                <li>Must contain at least one number.</li>
                                <li>Must contain at least one special character.</li>
                            </ul>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
						</div>";
					} elseif (strpos($url, 'error=phone')!== false) {
						echo "
						<div class='alert alert-danger alert-dismissible fade show'>    
							 Please provide a valid phone number.
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
						</div>";
					}
            ?>

        <div class="card shadow" style="width: 100%;">
            <div class="card-body">
                <h2>Register</h2>
                <form action='includes/register.inc' method='POST'>
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>" required>
                    <div class="form-group">
                        <label>Firstname</label>
                        <input type="text" class="form-control" name='firstname' required>
                    </div>
                    <div class="form-group">
                        <label>Lastname</label>
                        <input type="text" class="form-control" name='lastname' required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name='email' required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="digit" class="form-control" name='phone' required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name='password' required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="text" class="form-control" name='c_password' required>
                    </div>
                    <button type="submit" name='submit' class="btn-orange">Register</button>
                </form>
            </div>
        </div>
    </div>
    <?php
        include("../includes/footer.php");
    ?>
</body>

</html>