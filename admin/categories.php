<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "bentaph");
?>
<html>
<body>
    <h1>Manage Categories</h1>
    <form method="POST" action="save_category.php">
        <label>Category Name:</label><br/>
        <input type="text" name="category_name" required><br/>
        <label>Description:</label><br/>
        <input type="text" name="description" required><br/>
        <input type="submit" name="btnsubmit" value="Add Category">
    </form>

    <table border="1" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php
        $q = mysqli_query($con, "SELECT * FROM categories");
       
        while ($r = mysqli_fetch_assoc($q)) {
        ?>
        <tr>
            <td><?php echo $r["id"]; ?></td>
            <td><?php echo $r["category_name"]; ?></td>
            <td><?php echo $r["description"]; ?></td>
            <td>
                <a href="details.php?id=<?php echo $r["id"]; ?>">Manage</a>
            </td>
        </tr>
        <?php 
        } 
        ?>
    </table>
</body>
</html>