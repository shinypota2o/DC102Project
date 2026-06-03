<?php
include 'config/connect.php';
session_start();
$cartCount = 0;

$cartCount = 0;
if (isset($_SESSION['user_id'])) {
    $clientid = $_SESSION['user_id'];
    
    $query = "SELECT COUNT(*) AS total_items FROM cart WHERE clientid = '$clientid' AND quantity > 0";
    
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $cartCount = $row['total_items'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>BENTA.PH - Online Ordering System</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/css/shop-homepage-style.css" rel="stylesheet" />
</head>

<body>
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

                            <?php if (isset($_SESSION['email'])): ?>
                                <li><a class="dropdown-item" href="my-account.php">My Account</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="login.php">Login</a></li>
                                <?php endif; ?>l
                        </ul>
                    </li>
                </ul>

                <a href="cart.php" class="btn btn-outline-dark">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill">
                        <?php echo $cartCount; ?>
                    </span>
                </a

                    </div>
            </div>
    </nav>
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Browse and Purchase</h1>
                <p class="lead fw-normal text-white-50 mb-0">Affordable Items yet Quality Guaranteed</p>
            </div>
        </div>
    </header>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                $q = mysqli_query($con, "select * from items order by itemname");
                while ($r = mysqli_fetch_array($q)) {
                ?>
                    <div class="col-3">
                        <div class="card mb-3">
                            <img src="admin/<?php echo $r["image"]; ?>" class="card-img-top" alt="..." style="max-height:300px !important; object-fit:cover;">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5 class="fw-bolder"><?php echo $r["itemname"]; ?></h5>
                                    <p class="card-text">
                                        Qty:
                                        <?php
                                        if ($r["quantity"] == 0) {
                                            echo "Sold Out";
                                        } else {
                                            echo $r["quantity"];
                                        }
                                        ?>
                                    </p>
                                    <p><?php echo $r["price"] ?></p>
                                </div>
                            </div>

                            <div class="card-footer p-2 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="item-details.php?id=<?php echo $r["id"]; ?>">View Item</a></div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Group 4 2026</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/homepage-scripts.js"></script>
</body>

</html>
<?php
