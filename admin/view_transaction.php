<?php
session_start();
include '../config/connect.php';

if (!isset($_SESSION["username"])) {
    echo "<script>window.location='login.php';</script>";
    exit;
}

$id = $_GET['id'];

$q = mysqli_query($con, "
    SELECT 
        t.*,
        c.email,
        p.address,
        p.contact_number
    FROM transactions t
    LEFT JOIN clientusers c ON t.clientid = c.id
    LEFT JOIN profile p ON p.client_id = c.id
    WHERE t.id = '$id'
");

$data = mysqli_fetch_assoc($q);

if (isset($_POST['approve'])) {
    mysqli_query($con, "UPDATE transactions SET status='Approved' WHERE id='$id'");
    header("Location: view_transaction.php?id=$id");
}

if (isset($_POST['cancel'])) {
    mysqli_query($con, "UPDATE transactions SET status='Cancelled' WHERE id='$id'");
    header("Location: view_transaction.php?id=$id");
}

if (isset($_POST['complete'])) {
    mysqli_query($con, "UPDATE transactions SET status='Completed' WHERE id='$id'");
    header("Location: view_transaction.php?id=$id");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Transaction Details - Benta.ph Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>

    <style>
        body { background: #f4f6f9; }
        .sb-topnav { height: 56px; }
        #layoutSidenav_nav { width: 240px; min-height: 100vh; }
        .card-custom { border: 0; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .nav-link-custom { color: white; text-decoration: none; display: block; margin-bottom: 10px; }
        .detail-label { font-weight: bold; color: #6c757d; font-size: 0.85rem; text-transform: uppercase; }
        .detail-value { font-size: 1.1rem; margin-bottom: 15px; }
    </style>
</head>

<body class="sb-nav-fixed">

<nav class="sb-topnav navbar navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="dashboard.php">Benta.ph</a>
    <button class="btn btn-link text-white" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    <div class="ms-auto dropdown">
        <a class="text-white dropdown-toggle" data-bs-toggle="dropdown" style="cursor:pointer;"><i class="fas fa-user"></i> Admin</a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div id="layoutSidenav" class="d-flex">

    <div class="bg-dark text-white p-3" id="layoutSidenav_nav">
        <a class="nav-link-custom" href="dashboard.php"><i class="fas fa-home me-2"></i> Dashboard</a>
        <a class="nav-link-custom" href="account.php"><i class="fas fa-user-cog me-2"></i> My Account</a>
        <hr class="text-secondary">
        <small class="text-secondary d-block mb-2">TRANSACTIONS</small>
        <a class="nav-link-custom fw-bold text-info" href="transactions.php"><i class="fas fa-list me-2"></i> Transaction Lists</a>
        <hr class="text-secondary">
        <small class="text-secondary d-block mb-2">MANAGEMENT</small>
        <a class="nav-link-custom" href="categories.php"><i class="fas fa-tags me-2"></i> Categories</a>
        <a class="nav-link-custom" href="itemsmanagement.php"><i class="fas fa-box me-2"></i> Items</a>
    </div>

    <div class="flex-grow-1">
        <div class="container-fluid p-4">

            <div class="mb-4">
                <a href="transactions.php" class="btn btn-sm btn-secondary mb-2"><i class="fas fa-arrow-left"></i> Back to List</a>
                <h2>Transaction #<?php echo $data['id']; ?></h2>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card card-custom p-4 mb-4">
                        <h5 class="border-bottom pb-2 mb-3">Order Summary</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">
                                    <span class="badge bg-info text-dark"><?php echo $data['status']; ?></span>
                                </div>

                                <div class="detail-label">Order Date</div>
                                <div class="detail-value"><?php echo $data['orderdate']; ?></div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="detail-label">Total Amount</div>
                                <div class="detail-value h3 text-success">₱<?php echo number_format($data['total'], 2); ?></div>
                                <small class="text-muted">Subtotal: ₱<?php echo $data['subtotal']; ?> | Fee: ₱<?php echo $data['fee']; ?></small>
                            </div>
                        </div>

                        <hr>

                        <div class="mt-2">
                            <form method="POST">
                                <?php if ($data['status'] == 'Pending') { ?>
                                    <button name="approve" class="btn btn-success px-4 me-2">Approve Order</button>
                                    <button name="cancel" class="btn btn-outline-danger">Cancel Order</button>
                                <?php } ?>

                                <?php if ($data['status'] == 'Approved') { ?>
                                    <button name="complete" class="btn btn-primary px-4 me-2">Mark as Completed</button>
                                    <button name="cancel" class="btn btn-outline-danger">Cancel Order</button>
                                <?php } ?>

                                <?php if ($data['status'] == 'Completed' || $data['status'] == 'Cancelled') { ?>
                                    <div class="alert alert-light border">This transaction is <b><?php echo $data['status']; ?></b>. No further actions needed.</div>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-custom p-4">
                        <h5 class="border-bottom pb-2 mb-3">Customer Details</h5>
                        
                        <div class="detail-label">Email Address</div>
                        <div class="detail-value"><?php echo $data['email']; ?></div>

                        <div class="detail-label">Contact Number</div>
                        <div class="detail-value"><?php echo $data['contact_number'] ?? 'Not provided'; ?></div>

                        <div class="detail-label">Delivery Address</div>
                        <div class="detail-value text-muted" style="font-size: 0.95rem;">
                            <?php echo $data['address'] ?? 'No address on file'; ?>
                        </div>
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
        sidebar.style.display = (sidebar.style.display === "none") ? "block" : "none";
    };
</script>

</body>
</html>