<?php
$con = mysqli_connect("localhost", "root", "", "bentaph");

$category_name = $_POST["category_name"];
$description = $_POST["description"];

mysqli_query($con, "insert into categories(category_name, description) values('$category_name','$description')");

echo "<script>window.location = 'categories.php'; </script>";
?>