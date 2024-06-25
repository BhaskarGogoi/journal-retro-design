<?php
    include '../../config.php';

    session_start();
	$journal_id = mysqli_real_escape_string($conn, $_POST['journal_id']);
	if (isset($_POST['submit'])) {
        //check if logged in
        if(!(isset($_SESSION['admin_id']))){
            header ("Location: ../login?error=unauthorized");
        }

		//-----Check if form datas are not filled-----
         if ( empty($journal_id)) {
			header ("Location:../articles?journal_id=$journal_id&error=empty");
			exit();
         }
		//-----End Check if form datas are not filled-----

		else {
            $sql = "UPDATE journals SET filename = ? WHERE journal_id = ?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo "Error!";
            } else {
                $filename= null;
                mysqli_stmt_bind_param($stmt, "ss", $filename, $journal_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($stmt->affected_rows > 0){
                    header ("Location:../articles?journal_id=$journal_id&success=deleted");
                    exit();
                }else {
                    echo "Error!";                
                }
            }            
		}
	} else {
		header ("Location:../articles?journal_id=$journal_id&error=submit");
		exit();
	}
?>