<?php
session_start();
include 'config/connect.php';

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
    <title>My Transactions - Benta.ph</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            padding-top: 56px;
            background-color: #f4f7f6;
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
            width: 260px;
            background-color: #212529;
            color: white;
            transition: all 0.3s;
        }

        .sidebar-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            padding: 15px 25px;
            display: block;
            border-left: 4px solid transparent;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background-color: #2c3136;
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
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand fw-bold" href="index.php text-primary">Benta.ph</a>
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
            <a href="my-account.php" class="sidebar-link"><i class="fas fa-user-circle me-2"></i> Update Account</a>
            <a href="transaction-client.php" class="sidebar-link active"><i class="fas fa-receipt me-2"></i> Transactions</a>
            <a href="logout.php" class="sidebar-link">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>

        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12">
                        <h2 class="fw-bold text-dark">
                            <?php echo isset($_GET['view']) ? "Transaction Details" : "Your Transactions"; ?>
                        </h2>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-4">
                        <?php include 'transaction.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-4 bg-dark mt-auto text-white text-center">
        <div class="container small">Copyright &copy; Benta.ph 2024</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>