<!DOCTYPE html>
<?php
include("config/connect.php");
$id = $_GET["id"];
echo $id;
?>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>BENTA.PH - Online Ordering System</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/shop-homepage-style.css" rel="stylesheet" />
    </head>

    <body>

        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">Benta.ph</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" href="#!">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Header-->
        <header class="bg-grey py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Shop in style</h1>
                    <p class="lead fw-normal text-white-50 mb-0">With this shop</p>
                    <a href="item-details.php" class="btn btn-primary">View Product</a>
                    <a href="admin/login.php" class="btn btn-danger">Go to Admin</a>
                </div>
            </div>

            <div class="container">

                <table class="table table-striped table-hover">
                    <tr>
                        <th>Client Name</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>

                    <?php

$q = mysqli_query($con, "
    SELECT 
        cart.*,
        items.itemname,
        clients.fullname
    FROM cart
    LEFT JOIN items ON cart.itemid = items.id
    LEFT JOIN clients ON cart.clientid = clients.id
    WHERE cart.clientid = 2
    ORDER BY items.itemname
");

while($r = mysqli_fetch_array($q)){
?>
                    <tr>
                        <td>Guest</td>
                        <td><?php echo $r["itemname"]; ?></td>
                        <td><?php echo $r["quantity"]; ?></td>
                        <td><?php echo $r["price"]; ?></td>
                        <td><?php echo $subtotal; ?></td>
                        <td>
                            <a href="remove.php?id=<?php echo $r['id']; ?>">Remove</a>
                        </td>
                    </tr>

                    <?php } ?>

                </table>
            </div>

            <?php 
                echo "<h4>SUBTOTAL: $total</h4>";
                echo "<h5>SHIPPING FEE: 100</h5>";
                echo "<h2>TOTAL AMOUNT: ".($total+100)."</h2>";
            ?>

        </header>
<form method="POST">

<input type="submit" value="Checkout" name="btncheckout" class="btn btn-success"></input>

<?php
if(isset($_POST["btncheckout"])){
    mysqli_query($con, "insert into transactions(clientid,subtotal,fee,total,status,orderdate) values(2,$subtotal,100,$total,'Pending',NOW())");
    $q = mysqli_query($con, "select * from cart where clientid=2");
    while($r = mysqli_fetch_array($q)){
        mysqli_query($con, "update items set quantity=quantity-$r[quantity] where id=$r[itemid]");
    }
    mysqli_query($con, "delete from cart where clientid=2");
    echo "<script>alert('Thank you for ordering');window.location='index.php';</script>";
}
?>
</form>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; Group 4 2026</p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script src="js/homepage-scripts.js"></script>

    </body>
</html>


