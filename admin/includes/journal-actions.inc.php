<?php
    session_start();
	if (isset($_POST['submit'])) {
        //check if logged in
        if(!(isset($_SESSION['admin_id']))){
            header ("Location: ../login?error=unauthorized");
        }

        include '../../config.php';

		$journal_id = mysqli_real_escape_string($conn, $_POST['journal_id']);
		$action = mysqli_real_escape_string($conn, $_POST['action']);

		//-----Check if form datas are not filled-----
         if (empty($journal_id) || empty($action)) {
			header ("Location:../journals?error=empty");
			exit();
         }
		//-----End Check if form datas are not filled-----

		else {
            $date = date("d-m-Y");
            if($action == 'Publish'){
                $sql = "UPDATE journals SET published_date = ?, status = 'Published' WHERE journal_id = ?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "Error!";
                } else {
                    mysqli_stmt_bind_param($stmt, "ss", $date, $journal_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if($stmt->affected_rows > 0){
                        header ("Location:../journals?success=published");
                        exit();
                    }else {
                        echo "Error!";                }
                } 
            } else if($action == 'UnPublish'){
                $sql = "UPDATE journals SET status = 'Not Published' WHERE journal_id = ?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "Error!";
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $journal_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if($stmt->affected_rows > 0){
                        header ("Location:../journals?success=unpublished");
                        exit();
                    }else {
                        echo "Error!";                
                    }
                } 
            } else if($action == 'Delete') {
                $sql = "DELETE FROM journals WHERE journal_id = ?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "Error!";
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $journal_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if($stmt->affected_rows > 0){
                        header ("Location:../journals?success=deleted");
                        exit();
                    }else {
                        echo "Error!";                
                    }
                }
            }
            
		}
	} else {
		header ("Location:../journals?error=submit");
		exit();
	}
?>