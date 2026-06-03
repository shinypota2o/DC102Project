<?php
session_start();
include '../config/connect.php';

// Check if logged in
if (!isset($_SESSION["username"])) {
    echo "<script>window.location = 'login.php';</script>";
    exit;
}

// Fetch counts for the dashboard cards
$q1 = mysqli_query($con, "SELECT * FROM transactions WHERE status='Pending'");
$pending = mysqli_num_rows($q1);

$q2 = mysqli_query($con, "SELECT * FROM transactions WHERE status='Approved'");
$approved = mysqli_num_rows($q2);

$q3 = mysqli_query($con, "SELECT * FROM items");
$total_items = mysqli_num_rows($q3);

$q4 = mysqli_query($con, "SELECT * FROM categories");
$total_cats = mysqli_num_rows($q4);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Benta.ph Admin</title>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>

    <style>
        body { background: #f4f6f9; }
        .sb-topnav { height: 56px; }
        #layoutSidenav_nav { width: 240px; min-height: 100vh; }
        .card-dashboard { border: 0; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: 0.2s; }
        .card-dashboard:hover { transform: translateY(-3px); }
        .icon-box { font-size: 2.5rem; opacity: 0.3; }
        .nav-link-custom { color: white; text-decoration: none; display: block; margin-bottom: 10px; }
        .nav-link-custom:hover { opacity: 0.8; }
    </style>
</head>

<body class="sb-nav-fixed">

<!-- TOP NAVBAR -->
<nav class="sb-topnav navbar navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="dashboard.php">Benta.ph</a>
    <button class="btn btn-link text-white" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    <div class="ms-auto dropdown">
        <a class="text-white dropdown-toggle" data-bs-toggle="dropdown" style="cursor:pointer;">
            <i class="fas fa-user"></i> <?php echo $_SESSION["username"]; ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div id="layoutSidenav" class="d-flex">

    <!-- SIDEBAR -->
    <div class="bg-dark text-white p-3" id="layoutSidenav_nav">
        
        <!-- ACTIVE PAGE: Dashboard -->
        <a class="nav-link-custom fw-bold text-info" href="dashboard.php">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>

        <a class="nav-link-custom" href="account.php">
            <i class="fas fa-user-cog me-2"></i> My Account
        </a>

        <hr class="text-secondary">
        <small class="text-secondary d-block mb-2">TRANSACTIONS</small>
        <a class="nav-link-custom" href="transactions.php">
            <i class="fas fa-list me-2"></i> Transaction Lists
        </a>

        <hr class="text-secondary">
        <small class="text-secondary d-block mb-2">MANAGEMENT</small>
        <a class="nav-link-custom" href="categories.php">
            <i class="fas fa-tags me-2"></i> Categories
        </a>

        <a class="nav-link-custom" href="itemsmanagement.php">
            <i class="fas fa-box me-2"></i> Items
        </a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-grow-1">
        <div class="container-fluid p-4">

            <div class="mb-4">
                <h2 class="mb-1">Dashboard</h2>
                <p class="text-muted">Welcome back! Here is what's happening today.</p>
            </div>

            <div class="row g-4">
                <!-- Pending Card -->
                <div class="col-xl-3 col-md-6">
                    <div class="card card-dashboard bg-warning text-dark h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase fw-bold mb-1">Pending</h6>
                                <h2 class="mb-0"><?php echo $pending; ?></h2>
                            </div>
                            <div class="icon-box"><i class="fas fa-clock"></i></div>
                        </div>
                        <div class="card-footer bg-transparent border-top border-dark border-opacity-10">
                            <a href="transactions.php" class="text-dark text-decoration-none small">View Details <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Approved Card -->
                <div class="col-xl-3 col-md-6">
                    <div class="card card-dashboard bg-success text-white h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase fw-bold mb-1">Approved</h6>
                                <h2 class="mb-0"><?php echo $approved; ?></h2>
                            </div>
                            <div class="icon-box"><i class="fas fa-check-circle text-white"></i></div>
                        </div>
                        <div class="card-footer bg-transparent border-top border-white border-opacity-10">
                            <a href="transactions.php" class="text-white text-decoration-none small">View Details <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Total Items Card -->
                <div class="col-xl-3 col-md-6">
                    <div class="card card-dashboard bg-primary text-white h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase fw-bold mb-1">Total Items</h6>
                                <h2 class="mb-0"><?php echo $total_items; ?></h2>
                            </div>
                            <div class="icon-box"><i class="fas fa-box text-white"></i></div>
                        </div>
                        <div class="card-footer bg-transparent border-top border-white border-opacity-10">
                            <a href="itemsmanagement.php" class="text-white text-decoration-none small">Manage Items <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Categories Card -->
                <div class="col-xl-3 col-md-6">
                    <div class="card card-dashboard bg-info text-white h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase fw-bold mb-1">Categories</h6>
                                <h2 class="mb-0"><?php echo $total_cats; ?></h2>
                            </div>
                            <div class="icon-box"><i class="fas fa-tags text-white"></i></div>
                        </div>
                        <div class="card-footer bg-transparent border-top border-white border-opacity-10">
                            <a href="categories.php" class="text-white text-decoration-none small">Manage Categories <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-dashboard p-4">
                        <h5>Admin Panel Instructions</h5>
                        <p class="text-muted mb-0">Use the sidebar to manage your store. You can approve customer orders, add new products to your inventory, or create new categories for your items.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Sidebar toggle functionality matches the My Account page
    document.getElementById("sidebarToggle").onclick = function () {
        let sidebar = document.getElementById("layoutSidenav_nav");
        if (sidebar.style.display === "none") {
            sidebar.style.setProperty("display", "block", "important");
        } else {
            sidebar.style.setProperty("display", "none", "important");
        }
    };
</script>

</body>
</html>