<?php
$con = mysqli_connect("localhost", "root", "", "bentaph");
$id = $_GET["id"];

$q = mysqli_query($con, "select * from items where id = $id");
$cat = mysqli_fetch_array($q);
?>
<html>
<body>
    <h1>Item Details</h1>
    <form method="POST">
        <label>Item Name:</label><br/>
        <input type="text" name="itemname" value="<?php echo $cat["itemname"]; ?>" required><br/>

        <label>Category ID:</label><br/>
        <input type="text" name="categoryid" value="<?php echo $cat["categoryid"]; ?>" required><br/>

        <label>Description:</label><br/>
        <input type="text" name="description" value="<?php echo $cat["description"]; ?>" required><br/>

        <input type="submit" name="btnupdate" value="Update Item">
        <input type="submit" name="btndelete" value="Delete Item">
    </form>
    <?php
    if(isset($_POST["btnupdate"])){
        $name = $_POST["itemname"];
        $categoryid = $_POST["categoryid"];
        $description = $_POST["description"];
        mysqli_query($con, "UPDATE items SET itemname='$name', categoryid='$categoryid', description='$description' WHERE id=$id");
        echo "<script>window.location = 'itemsmanagement.php'; </script>";
    }

    if(isset($_POST["btndelete"])){
        mysqli_query($con, "DELETE FROM items WHERE id=$id");
        echo "<script>window.location = 'itemsmanagement.php'; </script>";
    }
    ?>
    <br/>
    <a href="itemsmanagement.php">Back to Item List</a>
</body>
</html>