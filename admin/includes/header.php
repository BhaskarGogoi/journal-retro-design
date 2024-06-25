<?php 
    include "../config.php";
?>

<div class="dashboard-header">
    Hi! <?php echo $_SESSION['firstname'] ?>
    <a href="<?php echo $http_host; ?>/admin/includes/logout.inc">
        <button class="logout">Logout</button>
    </a>
</div>