<?php
    include 'includes/admin-head.php';
?>
<title>Login</title>
</head>

<body class='auth-body'>

    <div class="auth-box my-4">
        <?php
            //if logged in redirect to dashboard
            if(isset($_SESSION['admin_id'])){
                header ("Location: dashboard");
            }
            //csrf token 
            $csrf_token = md5(uniqid(rand(), true));
            $_SESSION['csrf_token'] = $csrf_token;
            
            $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            if (strpos($url, 'error=empty')!== false) {
                echo "
                <div class='alert alert-success alert-dismissible fade show'>    
                    Fill out all the fields!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            } elseif (strpos($url, 'error=email-invalid')!== false) {
                echo "
                <div class='alert alert-success alert-dismissible fade show'>    
                    Please enter valid email address!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            } elseif (strpos($url, 'error=submit')!== false) {
                echo "
                <div class='alert alert-success alert-dismissible fade show'>    
                    Something Went Wrong!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            } elseif (strpos($url, 'error=not-found')!== false) {
                echo "
                <div class='alert alert-success alert-dismissible fade show'>    
                    User not found!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            } elseif (strpos($url, 'error=incorrect')!== false) {
                echo "
                <div class='alert alert-success alert-dismissible fade show'>    
                    Email or password is worng!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            } elseif (strpos($url, 'error=unauthorized')!== false) {
                echo "
                <div class='alert alert-success alert-dismissible fade show'>    
                    Unauthorized! Please Login
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            }
            elseif (strpos($url, 'error=500')!== false) {
                echo "
                <div class='alert alert-success alert-dismissible fade show'>    
                    Something Went Wrong!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            }
        ?>

        <div class="card shadow" style="width: 100%;">
            <div class="card-body">
                <h2>Login</h2>
                <form action='includes/login.inc' method='POST'>
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>" required>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name='email' required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name='password' required>
                    </div>
                    <button type="submit" name='submit' class="btn-orange">Login</button>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>