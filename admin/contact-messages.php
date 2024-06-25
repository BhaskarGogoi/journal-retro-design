<?php
    include("includes/admin-head.php");
?>
<title>Contact Messages</title>
</head>


<body>
    <?php
         //check if loggedin
         if(!(isset($_SESSION['admin_id']))){
            header ("Location: login?error=unauthorized");
        }
        include('includes/sidebar.inc.php');
    ?>
    <div class="main">
        <?php
            include('includes/header.php');
        ?>
        <div class='main-content'>
            <div class="container mt-5">
                <div class="row mb-5">
                    <?php
                        $sql = "SELECT * FROM contact_msg ORDER BY id DESC";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            $pagination = FALSE;   
                            echo "Error";
                        } else {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            $modalID = 0;
                            if($result->num_rows > 0 ){
                                echo "
                                    <div style='width: 100%; margin-bottom: 20px;'>
                                    <h5 style='display: inline-block;' class='card-title'>Contact Messages</h5>
                                    </div>
                                    <table class='table table-striped'>
                                        <thead>
                                            <tr>
                                                <th scope='col'>Name</th>
                                                <th scope='col'>Email</th>
                                                <th scope='col'>Date</th>
                                                <th scope='col'>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                                        while($row = mysqli_fetch_assoc($result)) {  
                                            $modalID = $modalID + 1;
                                            $timestamp = date("d-m-Y h:i:s a", strtotime($row["date"]));
                                            echo "
                                                <tr>
                                                    <th>$row[name]</th>
                                                    <td>$row[email]</td>
                                                    <td>$timestamp</td>
                                                    <td>
                                                        <a href='view-contact-message?id=$row[id]'><button type='submit' name='submit' class='btn-sm btn-primary' title='View Message'>View Message</button></a> 
                                                    </td>
                                                </tr>
                                            </div>";           
                                        }  
                                    echo "</tbody>
                                    </table>";                            
                            } else {
                                echo "<br>No Messages Available!<br>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    </div>
</body>

</html>