<?php
$con = mysqli_connect("localhost", "root", "", "bentaph");
$id = $_GET["id"];

$q = mysqli_query($con, "select * from categories where id = $id");
$cat = mysqli_fetch_array($q);
?>
<html>
<body>
    <h1>Category Details</h1>
    <form method="POST">
        <label>Category Name:</label><br/>
        <input type="text" name="categoryname" value="<?php echo $cat["categoryname"]; ?>" required><br/>
        
        <label>Description:</label><br/>
        <input type="text" name="description" value="<?php echo $cat["description"]; ?>" required><br/>

        <input type="submit" name="btnupdate" value="Update Category">
        <input type="submit" name="btndelete" value="Delete Category">
    </form>
    <?php
    if(isset($_POST["btnupdate"])){
        $name = $_POST["categoryname"];
        $desc = $_POST["description"];
        mysqli_query($con, "UPDATE categories SET categoryname='$name', description='$desc' WHERE id=$id");
        echo "<script>window.location = 'categories.php'; </script>";
    }

    if(isset($_POST["btndelete"])){
        mysqli_query($con, "DELETE FROM categories WHERE id=$id");
        echo "<script>window.location = 'categories.php'; </script>";
    }
    ?>
    <br/>
    <a href="categories.php">Back to Category List</a>
</body>
</html>