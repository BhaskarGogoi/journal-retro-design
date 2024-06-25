<?php
    $filename = basename($_SERVER["SCRIPT_FILENAME"], '.php');
    include '../config.php';
?>

<div class="admin-sidebar">
    <div class="logo">
        <a href="//<?php echo $http_host; ?>"> <img src="../assets/img/du.png"> Home</a>
    </div>
    <hr>
    <div class="nav">
        <ul>
            <a href="//<?php echo $http_host; ?>/admin/dashboard">
                <li <?php echo ($filename == 'dashboard') ? 'class="side-nav-active"' : ''; ?>><i
                        class="fas fa-tachometer-alt"></i> Dashboard</li>
            </a>
            <a href="//<?php echo $http_host; ?>/admin/journals">
                <li <?php echo ($filename == 'journals') ? 'class="side-nav-active"' : ''; ?>>
                    <i class="fas fa-book"></i> Journals
                </li>
            </a>
            <a href="//<?php echo $http_host; ?>/admin/upload-article.php">
                <li <?php echo ($filename == 'upload-article.php') ? 'class="side-nav-active"' : ''; ?>>
                    <i class="fas fa-upload"></i> Upload Article
                </li>
            </a>
            <a href="//<?php echo $http_host; ?>/admin/upload-complete-journal.php">
                <li <?php echo ($filename == 'upload-complete-journal.php') ? 'class="side-nav-active"' : ''; ?>>
                    <i class="fas fa-upload"></i> Upload Complete Journal
                </li>
            </a>
            <!-- <a href="//<?php echo $http_host; ?>/admin/contact-messages">
                <li
                    <?php echo ($filename == 'contact-messages' || $filename == 'view-contact-message') ? 'class="side-nav-active"' : ''; ?>>
                    <i class="fas fa-envelope"></i> Contact Messages
                </li>
            </a> -->
            <a href="//<?php echo $http_host; ?>/admin/change-password">
                <li <?php echo ($filename == 'change-password') ? 'class="side-nav-active"' : ''; ?>>
                    <i class="fas fa-key"></i> Change Password
                </li>
            </a>
        </ul>
    </div>
</div>