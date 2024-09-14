<?php 
include "header.php";
include "config/dbc.php";

if($_SESSION["role"] == '0'){
    header("location: {$hostname}/admin/post.php");    
    exit();
}

if(isset($_POST['save'])){
    $cat_name = mysqli_real_escape_string($conn, $_POST['cat']);
    
    // Insert category into the database
    $sql = "INSERT INTO category (category_name) VALUES ('{$cat_name}')";
    if(mysqli_query($conn, $sql)){
        // Redirect to the category list page after successful insertion
        header("Location: {$hostname}/admin/category.php");
    } else {
        echo "<p>Failed to add new category.</p>";
    }
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form Start -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                    </div>
                    <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                </form>
                <!-- /Form End -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
