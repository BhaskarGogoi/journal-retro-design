<section>
    <?php
    session_start();
    if(isset($_SESSION['admin_id'])){
        echo"
            <div class='auth-header'>
                Hi $_SESSION[firstname] | 
                <a href='//$http_host/admin/dashboard'>
                    Dashboard
                </a> | 
                <a href='//$http_host/admin/includes/logout.inc'>
                    Logout
                </a>
            </div>
        ";
    } 
?>
</section>