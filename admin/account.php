<?php
session_start();
include '../config/connect.php';

if (!isset($_SESSION["username"])) {
    echo "<script>window.location='login.php';</script>";
    exit;
}

$username = $_SESSION["username"];
$msg = "";

if (isset($_POST["update_password"])) {
    $old_pass = $_POST["old_password"];
    $new_pass = $_POST["new_password"];
    $confirm_pass = $_POST["confirm_password"];

    $q = mysqli_query($con, "SELECT * FROM adminusers WHERE username='$username'");
    $user = mysqli_fetch_assoc($q);

    if ($user && $user["password"] == $old_pass) {
        if ($new_pass == $confirm_pass) {
            mysqli_query($con, "UPDATE adminusers SET password='$new_pass' WHERE username='$username'");
            $msg = "<div class='alert alert-success'>Password updated successfully.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>New passwords do not match.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Old password is incorrect.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Account - Benta.ph Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>

    <style>
        body { background: #f4f6f9; }
        .sb-topnav { height: 56px; }
        #layoutSidenav_nav { width: 240px; min-height: 100vh; }
        .card-box { border: 0; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .nav-link-custom { color: white; text-decoration: none; display: block; margin-bottom: 10px; }
        .nav-link-custom:hover { opacity: 0.8; }
    </style>
</head>

<body class="sb-nav-fixed">

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

    <div class="bg-dark text-white p-3" id="layoutSidenav_nav">
        
        <a class="nav-link-custom" href="dashboard.php">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>

        <a class="nav-link-custom fw-bold text-info" href="account.php">
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

    <div class="flex-grow-1">
        <div class="container-fluid p-4">

            <div class="mb-4">
                <h2 class="mb-1">My Account</h2>
                <p class="text-muted">Update your administrative password</p>
            </div>

            <?php echo $msg; ?>

            <div class="card card-box">
                <div class="card-body p-4" style="max-width: 500px;">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Old Password</label>
                            <input type="password" name="old_password" class="form-control" placeholder="Enter current password" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">New Password</label>
                            <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Confirm New Password</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Repeat new password" required>
                        </div>

                        <div class="pt-2">
                            <button type="submit" name="update_password" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
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