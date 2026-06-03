<?php
include 'config/connect.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

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
    <title>My Account - Benta.ph</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            padding-top: 56px;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #wrapper {
            display: flex;
            flex: 1;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            width: 250px;
            background-color: #212529;
            color: white;
            transition: 0.3s;
        }

        .sidebar-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            padding: 15px 20px;
            display: block;
            border-bottom: 1px solid #343a40;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background-color: #343a40;
            color: white;
            border-left: 4px solid #0d6efd;
        }

        #page-content-wrapper {
            width: 100%;
            padding: 30px;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 12px;
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: -0.5px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand text-primary" href="index.php">Benta.ph</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About us</a></li>
                </ul>
                <a href="cart.php" class="btn btn-outline-dark">
                    <i class="bi-cart-fill me-1"></i> Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo $cartCount; ?></span>
                </a>
            </div>
        </div>
    </nav>

    <div id="wrapper">
        <div id="sidebar-wrapper" class="d-none d-md-block shadow">
            <div class="p-3">
                <p class="small text-uppercase text-muted fw-bold">User Dashboard</p>
            </div>
            <a href="my-account.php" class="sidebar-link active"><i class="fas fa-user-circle me-2"></i> Update Account</a>
            <a href="transaction-client.php" class="sidebar-link"><i class="fas fa-receipt me-2"></i> Transactions</a>
            <a href="logout.php" class="sidebar-link">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>

        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="mb-4 mt-2">
                    <h2 class="fw-bold text-dark">Settings</h2>
                    <p class="text-muted small">Update your personal information and security credentials.</p>
                </div>

                <div class="card">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold text-primary"><i class="fas fa-user-edit me-2"></i>Profile Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <?php include 'profile.php' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-4 bg-dark text-white text-center mt-auto">
        <div class="container small">Copyright &copy; Benta.ph 2024</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>