<?php
session_start();
include '../config/connect.php';

// Simple login check
if (!isset($_SESSION["username"])) {
    echo "<script>window.location='login.php';</script>";
    exit;
}

$id = $_GET["id"];

// Fetch the specific item details
$q = mysqli_query($con, "SELECT * FROM items WHERE id = $id");
$item = mysqli_fetch_array($q);

// HANDLE UPDATE
if(isset($_POST["btnupdate"])){
    $name = $_POST["itemname"];
    $categoryid = $_POST["categoryid"];
    $description = $_POST["description"];
    
    mysqli_query($con, "UPDATE items SET itemname='$name', categoryid='$categoryid', description='$description' WHERE id=$id");
    echo "<script>alert('Item updated successfully!'); window.location = 'itemsmanagement.php'; </script>";
}

// HANDLE DELETE
if(isset($_POST["btndelete"])){
    mysqli_query($con, "DELETE FROM items WHERE id=$id");
    echo "<script>alert('Item deleted!'); window.location = 'itemsmanagement.php'; </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Item - Benta.ph Admin</title>

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
        .preview-img { width: 100%; max-height: 250px; object-fit: contain; border-radius: 8px; background: #eee; }
    </style>
</head>

<body class="sb-nav-fixed">

<!-- TOP NAVBAR -->
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

    <!-- SIDEBAR -->
    <div class="bg-dark text-white p-3" id="layoutSidenav_nav">
        <a class="nav-link-custom" href="dashboard.php"><i class="fas fa-home me-2"></i> Dashboard</a>
        <a class="nav-link-custom" href="account.php"><i class="fas fa-user-cog me-2"></i> My Account</a>
        <hr class="text-secondary">
        <small class="text-secondary d-block mb-2">TRANSACTIONS</small>
        <a class="nav-link-custom" href="transactions.php"><i class="fas fa-list me-2"></i> Transaction Lists</a>
        <hr class="text-secondary">
        <small class="text-secondary d-block mb-2">MANAGEMENT</small>
        <a class="nav-link-custom" href="categories.php"><i class="fas fa-tags me-2"></i> Categories</a>
        <a class="nav-link-custom fw-bold text-info" href="itemsmanagement.php"><i class="fas fa-box me-2"></i> Items</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-grow-1">
        <div class="container-fluid p-4">

            <div class="mb-4">
                <a href="itemsmanagement.php" class="btn btn-sm btn-secondary mb-2"><i class="fas fa-arrow-left"></i> Back to Item List</a>
                <h2>Edit Item: <?php echo $item["itemname"]; ?></h2>
            </div>

            <div class="row">
                <!-- FORM COLUMN -->
                <div class="col-md-7">
                    <div class="card card-custom p-4 mb-4">
                        <h5 class="mb-4 text-primary">Item Details</h5>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Item Name</label>
                                <input type="text" name="itemname" class="form-control" value="<?php echo $item["itemname"]; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Category ID</label>
                                <input type="number" name="categoryid" class="form-control" value="<?php echo $item["categoryid"]; ?>" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" class="form-control" rows="5" required><?php echo $item["description"]; ?></textarea>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" name="btnupdate" class="btn btn-primary px-4">
                                    <i class="fas fa-sync-alt me-1"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- IMAGE & DELETE COLUMN -->
                <div class="col-md-5">
                    <!-- IMAGE PREVIEW -->
                    <div class="card card-custom p-3 mb-4 text-center">
                        <h6 class="text-muted mb-3">Item Image</h6>
                        <img src="<?php echo $item["image"]; ?>" class="preview-img border shadow-sm mb-2">
                        <small class="text-muted d-block mt-2">File: <?php echo $item["image"]; ?></small>
                    </div>

                    <!-- DELETE ACTION -->
                    <div class="card card-custom border-danger p-4">
                        <h5 class="text-danger mb-3">Danger Zone</h5>
                        <p class="small text-muted">Removing this item will delete it permanently from the shop inventory.</p>
                        <form method="POST" onsubmit="return confirm('Delete this item permanently?');">
                            <button type="submit" name="btndelete" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-1"></i> Delete This Item
                            </button>
                        </form>
                    </div>
                </div>
            </div> <!-- end row -->

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