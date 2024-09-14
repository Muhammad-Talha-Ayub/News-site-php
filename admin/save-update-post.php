<?php
include "config/dbc.php";
// Another way
// $title = $_POST['post_title'];
// $description = $_POST['postdesc'];
// $category = $_POST['category'];
// $post_id = $_POST['post_id'];
if (empty($_FILES['new-image']['name'])) {
	$file_name = $_POST['old-image']; 
}
else{
	$errors = array();
    $file_name = $_FILES['new-image']['name'];
    $file_size = $_FILES['new-image']['size'];
    $file_tmp = $_FILES['new-image']['tmp_name'];
    $file_type = $_FILES['new-image']['type'];
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
$sql = "UPDATE post SET title='{$_POST["post_title"]}',description='{$_POST["postdesc"]}',category={$_POST["category"]},post_img='{$file_name}'
	WHERE post_id ={$_POST["post_id"]}; ";
  if ($_POST['old_category'] != $_POST['category']) {
       $sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$_POST['old_category']};";
       $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$_POST['category']};";
    }  
	
     if(mysqli_multi_query($conn, $sql)){
        header("Location: {$hostname}/admin/post.php");
    }
    else{
        echo "Error: " . mysqli_error($conn);
    }


// Another way 
// $sql = "UPDATE post SET title=?, description=?, category=?, post_img=? WHERE post_id=?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("ssisi", $title, $description, $category, $file_name, $post_id);

// if ($stmt->execute()) {
//     echo "Post updated successfully.";
//     header("Location: {$hostname}/admin/post.php");
// } else {
//     echo "Error updating post: " . $conn->error;
// }

// $stmt->close();
// $conn->close();
?>