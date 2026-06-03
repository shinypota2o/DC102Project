<?php
session_start();
include 'config/connect.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$profile_id = $_SESSION['user_id'];

if (isset($_POST['id']) && isset($_POST['itemqty'])) {
    $itemid = $_POST['id'];
    $qty = $_POST['itemqty'];
    $result = mysqli_fetch_array(
        mysqli_query($con, "SELECT price FROM items WHERE id='$itemid'")
    );

    $price = $result['price'] * $qty;

    mysqli_query($con, "
        INSERT INTO cart (clientid, itemid, quantity, price, profile_id)
        VALUES ('$user_id','$itemid','$qty','$price','$profile_id')
    ");
}

$cartCount = 0;
if (isset($_SESSION['user_id'])) {
    $clientid = $_SESSION['user_id'];
    
    $query = "SELECT COUNT(*) AS total_items FROM cart WHERE clientid = '$clientid' AND quantity > 0";
    
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $cartCount = $row['total_items'] ?? 0;
}


$result = mysqli_query($con, "
    SELECT c.*, i.itemname, i.price, p.fullname
    FROM cart c
    JOIN items i ON c.itemid = i.id
    JOIN clientUsers u ON c.clientid = u.id
    JOIN profile p ON p.id = u.id
    WHERE c.clientid = '$user_id'
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>BENTA.PH - Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top border-bottom">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand fw-bold" href="index.php">Benta.ph</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                </ul>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill"></i> Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <?php if (isset($_SESSION['email'])): ?>
                                <li><a class="dropdown-item" href="my-account.php">My Account</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="login.php">Login</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>

                <a href="cart.php" class="btn btn-outline-dark ms-lg-3">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill">
                        <?php echo $cartCount; ?>
                    </span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container pt-5 mt-5 mb-5">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bolder">Shopping Cart</h2>
                <p class="text-muted">Review your selected items before checking out.</p>
            </div>
        </div>

        <form action="checkout.php" method="POST">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="ps-4">Select</th>
                                    <th>Item Details</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        $total = $row['price'] * $row['quantity'];
                                ?>
                                <tr>
                                    <td class="ps-4">
                                        <input type="checkbox" class="form-check-input" name="cart_ids[]" value="<?php echo $row['id']; ?>">
                                    </td>
                                    <td>
                                        <div class="fw-bold"><?php echo $row['itemname']; ?></div>
                                        <small class="text-muted small">Buyer: <?php echo $row['fullname']; ?></small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill bg-secondary px-3">
                                            <?php echo $row['quantity']; ?>
                                        </span>
                                    </td>
                                    <td class="text-end text-nowrap">₱<?php echo number_format($row['price'], 2); ?></td>
                                    <td class="text-end text-nowrap fw-bold text-primary">
                                        ₱<?php echo number_format($total, 2); ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="removecart.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php 
                                    } 
                                } else {
                                    echo "<tr><td colspan='6' class='text-center py-5 text-muted'>Your cart is empty. <a href='index.php'>Go shopping!</a></td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="index.php" class="btn btn-link text-decoration-none text-dark">
                            <i class="bi bi-arrow-left"></i> Continue Shopping
                        </a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                            Proceed to Checkout <i class="bi bi-arrow-right-short"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Group 4 2026</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>