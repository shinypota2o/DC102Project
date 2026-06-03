<?php
session_start();
include '../config/connect.php';

if (!isset($_SESSION["username"])) {
    echo "<script>window.location='login.php';</script>";
    exit;
}

$q = mysqli_query($con, "
    SELECT 
        t.*,
        c.email,
        p.address,
        p.contact_number
    FROM transactions t
    LEFT JOIN clientusers c ON t.clientid = c.id
    LEFT JOIN profile p ON p.client_id = c.id
    ORDER BY t.orderdate DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Transactions - Benta.ph Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>

    <style>
        body { background: #f4f6f9; }
        .sb-topnav { height: 56px; }
        #layoutSidenav_nav { width: 240px; min-height: 100vh; }
        .card-table { border: 0; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
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

        <a class="nav-link-custom" href="account.php">
            <i class="fas fa-user-cog me-2"></i> My Account
        </a>

        <hr class="text-secondary">
        <small class="text-secondary d-block mb-2">TRANSACTIONS</small>
        <a class="nav-link-custom fw-bold text-info" href="transactions.php">
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

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">Transaction Lists</h2>
                    <p class="text-muted">Manage and view all customer orders</p>
                </div>
            </div>

            <div class="card card-table">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">ID</th>
                                    <th>Client Email</th>
                                    <th>Contact & Address</th>
                                    <th>Total Amount</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = mysqli_fetch_assoc($q)) { ?>
                                <tr>
                                    <td class="ps-3 fw-bold">#<?php echo $row['id']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td>
                                        <small class="d-block text-dark fw-bold"><?php echo $row['contact_number'] ?? 'No Contact'; ?></small>
                                        <small class="text-muted"><?php echo $row['address'] ?? 'No Address'; ?></small>
                                    </td>
                                    <td class="text-success fw-bold">₱<?php echo number_format($row['total'], 2); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['orderdate'])); ?></td>
                                    <td>
                                        <?php 
                                            $status = $row['status'];
                                            $badgeClass = "bg-secondary"; // Default
                                            if($status == "Pending") $badgeClass = "bg-warning text-dark";
                                            if($status == "Approved") $badgeClass = "bg-success";
                                            if($status == "Cancelled") $badgeClass = "bg-danger";
                                        ?>
                                        <span class="badge <?php echo $badgeClass; ?>">
                                            <?php echo $status; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="view_transaction.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary px-3">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
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