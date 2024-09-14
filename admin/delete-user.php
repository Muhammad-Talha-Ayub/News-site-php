<?php   
include "config/dbc.php";
if($_SESSION["role"]== '0'){
    header("location: {$hostname}/admin/post.php");    
} 
$userid = $_GET['id'];
$sql = "DELETE FROM user WHERE user_id = '{$userid}'";
if(mysqli_query($conn,$sql)){
    header("Location: {$hostname}/admin/users.php");
}
else{
    echo '<p style="color:white; margin: 10px 0;background-color:red;">Can\'t delete user record. </p>';
}

mysqli_close($conn);

?>