<?php
$con = mysqli_connect("localhost", "root", "", "bentaph");

$categoryname = $_POST["categoryname"];
$description = $_POST["description"];

mysqli_query($con, "insert into categories(categoryname, description) values('$categoryname','$description')");

echo "<script>window.location = 'categories.php'; </script>";
?>