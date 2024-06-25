<?php
    include('../../config.php');  
    
    $journal_id = mysqli_real_escape_string($conn, $_POST['journal_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);

    if (empty($title) || empty($journal_id)) {
        header ("Location:../upload-article?error=empty");
		exit();
    }
    
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if there was an error uploading the file
        if ($_FILES["pdfFile"]["error"] > 0) {
            echo "Error: " . $_FILES["pdfFile"]["error"];
        } else {
            $uploadDir = $http_root."/Archive/";
            $uploadedFileName = $_FILES["pdfFile"]["name"];
            $curr_timeStamp = date('dmYhis', time());
            $fileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
            $uniqueFileName = $curr_timeStamp . '.' . strtolower($fileExtension);
            
            $uploadedFile = $uploadDir . $uniqueFileName;

            // Check if the file already exists
            if (file_exists($uploadedFile)) {
                echo "File already exists.";
            } else {
                // Move the uploaded file to the specified directory
                if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $uploadedFile)) {
                    $sql = "INSERT INTO articles (journal_id, title, author, filename) VALUES (?,?,?,?);";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        http_response_code(400);
                        die('{"response": "SQL Error"}');
                    } else {
                        mysqli_stmt_bind_param($stmt, "ssss", $journal_id, $title, $author, $uniqueFileName);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if($conn->affected_rows > 0){
                            header ("Location:../upload-article?success=uploaded");
		                    exit();
                        }else {
                            header ("Location:../upload-article?error=500");
                            exit();
                        }  
                    } 
                } else {
                    echo "Error uploading file.";
                }
            }
        }
    } else {
        echo "Invalid request.";
    }
?>