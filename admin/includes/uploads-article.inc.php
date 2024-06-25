<?php
    include('../../config.php');   
 
    if (empty($_FILES) || $_FILES['file']['error']) {
        http_response_code(400);
        die('{"OK": 0, "info": "Failed to move uploaded file."}');
    }
    
    $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
    $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
    
    $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $filePath = $http_root.'/Archive/'.$fileName;
    $curr_timeStamp = date('dmYhis', time());  //generateing new file name as current timestamp to prevent conflict with same file name                  
    
    // Open temp file
    $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
    if ($out) {
        // Read binary input stream and append it to temp file
        $in = @fopen($_FILES['file']['tmp_name'], "rb");
        
        if ($in) {
            while ($buff = fread($in, 4096))
            fwrite($out, $buff);
        } else{
            http_response_code(400);
            die('{"OK": 0, "info": "Failed to open input stream."}');
        }
        
        @fclose($in);
        @fclose($out);
        
        @unlink($_FILES['file']['tmp_name']);
    } else{
        http_response_code(400);
        die('{"OK": 0, "info": "Failed to open output stream."}');
    }
        
    
    
    // Check if file has been uploaded
    if (!$chunks || $chunk == $chunks - 1) {
        // Strip the temp .part suffix off
        $fileNameNew = $curr_timeStamp.'.'.$fileActualExt;
        rename("{$filePath}.part", $http_root.'/Archive/'.$curr_timeStamp.'.'.$fileActualExt);

        $journal_id = mysqli_real_escape_string($conn, $_POST['journal_id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $author = mysqli_real_escape_string($conn, $_POST['author']);

        if (empty($title) || empty($journal_id)) {
            http_response_code(400);
            die('{error: Empty}');
        }

        $sql = "INSERT INTO articles (journal_id, title, author, filename) VALUES (?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            http_response_code(400);
            die('{"response": "SQL Error"}');
        } else {
            mysqli_stmt_bind_param($stmt, "ssss", $journal_id, $title, $author, $fileNameNew);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($conn->affected_rows > 0){
                http_response_code(200);
                die('{"OK": 1}');

            }else {
                http_response_code(400); 
                die('{"response": "Something Went Wrong!"}');
            }  
        } 
    }
    
    die('{"OK": 1, "info": "Upload successful."}');

?>