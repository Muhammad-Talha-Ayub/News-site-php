<?php 
include "header.php"; 
include "config/dbc.php";

if($_SESSION["role"] == '0'){
    header("location: {$hostname}/admin/post.php");    
    exit();
}

if(isset($_GET['id'])){
    $cat_id = $_GET['id'];

    // Fetch category data from the database
    $sql = "SELECT * FROM category WHERE category_id = {$cat_id}";
    $result = mysqli_query($conn, $sql) or die("Query Failed.");

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<p>Category not found.</p>";
        exit();
    }
} else {
    echo "<p>Invalid request.</p>";
    exit();
}

if(isset($_POST['submit'])){
    $cat_id = $_POST['cat_id'];
    $cat_name = mysqli_real_escape_string($conn, $_POST['cat_name']); // Sanitizing input

    // Update category data in the database
    $sql = "UPDATE category SET category_name = '{$cat_name}' WHERE category_id = {$cat_id}";
    if(mysqli_query($conn, $sql)){
        header("Location: {$hostname}/admin/category.php");
    } else {
        echo "<p>Failed to update category.</p>";
    }
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Update Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $cat_id; ?>" method="POST">
                    <div class="form-group">
                        <input type="hidden" name="cat_id" class="form-control" value="<?php echo $row['category_id']; ?>" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="cat_name" class="form-control" value="<?php echo htmlspecialchars($row['category_name']); ?>" placeholder="" required>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
