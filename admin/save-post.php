<?php
include "config/dbc.php";
if(isset($_FILES['fileToUpload'])){
    $errors = array();
    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    // $file_ext= end(explode('.',$file_name));
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $extensions = array("jpeg", "jpg", "png");
    // in_array(needle, haystack) search value in an array
    if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        // for 2 mb 
        // 1 kb = 1024 bytes
        // 1 mb = 1024 kb   
        // 1024 * 1024 = ans 
        // ans * 2 will be equal to 2 mb    
        if($file_size > 2097152){
            $errors[]='File size must be 2 MB or lower';
            }
            if(empty($errors)==true){               
                move_uploaded_file($file_tmp,"upload/".$file_name);
                echo "Success";
                }
                else{
                    print_r($errors);
                    die();
                    }
}
    session_start();
    $title = mysqli_real_escape_string($conn, $_POST['post_title']);
    $postdesc = mysqli_real_escape_string($conn, $_POST['postdesc']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $date = date("d M. Y");
    $author = $_SESSION['user_id'];
    $sql = "INSERT INTO post(title, description, category, post_date, author, post_img) 
    VALUES ('{$title}', '{$postdesc}', {$category}, '{$date}', '{$author}', '{$file_name}');";
    // When writing two commands have to add ; inside the " " 
    $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$category}";
    // As we have two queries we are not going to use mysqli_query but instead we are going to use
    // mysqli_multi_query
    if(mysqli_multi_query($conn, $sql)){
        header("Location: {$hostname}/admin/post.php");
    }
    else{
        echo "Error: " . mysqli_error($conn);
    }


?>