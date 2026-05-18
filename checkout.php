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
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.php">Benta.ph</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                    </ul>
                 
                <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="my-account.php">My Account</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
                </ul>   

                <form class="d-flex">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>
                    </form>

                </div>
            </div>
        </nav>

        <!-- Header-->
        <header class="bg-white py-5">
            

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
                    $total = 0;

                    $q = mysqli_query($con, "
                        SELECT cart.*, items.itemname 
                        FROM cart 
                        LEFT JOIN items ON cart.itemid = items.id 
                        WHERE cart.clientid=2 
                        ORDER BY items.itemname
                    ");

                    while($r = mysqli_fetch_array($q)){

                        $subtotal = $r["price"] * $r["quantity"];
                        $total += $subtotal;
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


