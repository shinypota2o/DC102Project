<?php
session_start();
include '../config/connect.php';

// Simple login check
if (!isset($_SESSION["username"])) {
    echo "<script>window.location='login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Categories - Benta.ph Admin</title>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>

    <style>
        body { background: #f4f6f9; }
        .sb-topnav { height: 56px; }
        #layoutSidenav_nav { width: 240px; min-height: 100vh; }
        .card-custom { border: 0; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
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
            <i class="fas fa-user"></i> Admin
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div id="layoutSidenav" class="d-flex">

    <!-- SIDEBAR -->
    <div class="bg-dark text-white p-3" id="layoutSidenav_nav">
        <a class="nav-link-custom" href="dashboard.php">
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
        <a class="nav-link-custom fw-bold text-info" href="categories.php">
            <i class="fas fa-tags me-2"></i> Categories
        </a>
        <a class="nav-link-custom" href="itemsmanagement.php">
            <i class="fas fa-box me-2"></i> Items
        </a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-grow-1">
        <div class="container-fluid p-4">
            
            <h2 class="mb-1">Manage Categories</h2>
            <p class="text-muted">Create and organize item categories</p>

            <div class="row">
                <!-- FORM COLUMN -->
                <div class="col-md-4">
                    <div class="card card-custom p-3 mb-4">
                        <h5 class="card-title mb-3">Add New Category</h5>
                        <form method="POST" action="save_category.php">
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" name="categoryname" class="form-control" placeholder="e.g. Gadgets" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Enter details..." required></textarea>
                            </div>
                            <button type="submit" name="btnsubmit" class="btn btn-primary w-100">
                                <i class="fas fa-plus"></i> Add Category
                            </button>
                        </form>
                    </div>
                </div>

                <!-- TABLE COLUMN -->
                <div class="col-md-8">
                    <div class="card card-custom p-0 overflow-hidden">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">ID</th>
                                    <th>Category Name</th>
                                    <th>Description</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $q = mysqli_query($con, "SELECT * FROM categories ORDER BY id DESC");
                                while ($r = mysqli_fetch_assoc($q)) {
                                ?>
                                <tr>
                                    <td class="ps-3 text-muted">#<?php echo $r["id"]; ?></td>
                                    <td class="fw-bold"><?php echo $r["categoryname"]; ?></td>
                                    <td><?php echo $r["description"]; ?></td>
                                    <td class="text-center">
                                        <a href="details.php?id=<?php echo $r["id"]; ?>" class="btn btn-sm btn-outline-primary px-3">
                                            <i class="fas fa-edit"></i> Manage
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end row -->

        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById("sidebarToggle").onclick = function () {
        let sidebar = document.getElementById("layoutSidenav_nav");
        sidebar.style.display = (sidebar.style.display === "none") ? "block" : "none";
    };
</script>

</body>
</html>