<?php
include "config/dbc.php";

$post_id = $_GET['id'];
$category_id = $_GET['catid'];

// First, get the image file name to delete the image file from the server
$sql1 = "SELECT post_img FROM post WHERE post_id = {$post_id}";
$result = mysqli_query($conn, $sql1) or die("Query Failed: Select");

$row = mysqli_fetch_assoc($result);
unlink("upload/" . $row['post_img']);

// Delete the post from the database
$sql = "DELETE FROM post WHERE post_id = {$post_id};";
$sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$category_id}";

if (mysqli_multi_query($conn, $sql)) {
    header("Location: {$hostname}/admin/post.php");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>