<?php
include "header.php";
include "config/dbc.php";

// Only admins should be able to delete categories
if($_SESSION["role"] == '0'){
    header("location: {$hostname}/admin/post.php");
    exit();
}

// Check if the category ID is set in the GET parameters
if(isset($_GET['id'])){
    $cat_id = $_GET['id'];

    // Validate that the category ID is a number
    if(is_numeric($cat_id)){
        // Delete category from the database
        $sql = "DELETE FROM category WHERE category_id = {$cat_id}";
        if(mysqli_query($conn, $sql)){
            // Redirect to the category list page after successful deletion
            header("Location: {$hostname}/admin/category.php");
        } else {
            echo "<p>Failed to delete category.</p>";
        }
    } else {
        echo "<p>Invalid category ID.</p>";
    }
} else {
    echo "<p>Category ID not specified.</p>";
}

include "footer.php";
?>
