<?php
session_start();
include '../config/connect.php';

if (!isset($_SESSION["username"])) {
    echo "<script>window.location='login.php';</script>";
    exit;
}

$message = "";
if(isset($_POST["btnsave"])){
    $itemname= $_POST["itemname"];
    $categoryid= $_POST["categoryid"];
    $description= $_POST["description"];
    $price= $_POST["price"];
    $quantity= $_POST["quantity"];
    
    $image_folder = "item_images/";
    if (!is_dir($image_folder)) {
        mkdir($image_folder);
    }
    
    $image_path = $image_folder . basename($_FILES["image"]["name"]);
    
    if(move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)){
        $sql = "INSERT INTO items(itemname,categoryid,description,price,quantity,image) 
                VALUES ('$itemname','$categoryid','$description','$price','$quantity','$image_path')";
        
        if(mysqli_query($con, $sql)){
            $message = "<div class='alert alert-success'>Item added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . mysqli_error($con) . "</div>";
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Items Management - Benta.ph Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>

    <style>
        body { background: #f4f6f9; }
        .sb-topnav { height: 56px; }
        #layoutSidenav_nav { width: 240px; min-height: 100vh; }
        .card-custom { border: 0; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .nav-link-custom { color: white; text-decoration: none; display: block; margin-bottom: 10px; }
        .nav-link-custom:hover { opacity: 0.8; }
        .item-img { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; }
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
            <i class="fas fa-user"></i> Admin
        </a>
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
        <a class="nav-link-custom" href="transactions.php"><i class="fas fa-list me-2"></i> Transaction Lists</a>
        <hr class="text-secondary">
        <small class="text-secondary d-block mb-2">MANAGEMENT</small>
        <a class="nav-link-custom" href="categories.php"><i class="fas fa-tags me-2"></i> Categories</a>
        <a class="nav-link-custom fw-bold text-info" href="itemsmanagement.php"><i class="fas fa-box me-2"></i> Items</a>
    </div>

    <div class="flex-grow-1">
        <div class="container-fluid p-4">
            
            <h2 class="mb-1">Items Management</h2>
            <p class="text-muted">Add and manage your product inventory</p>

            <?php echo $message; ?>

            <div class="row">
                <div class="col-md-4">
                    <div class="card card-custom p-3 mb-4">
                        <h5 class="mb-3">Add New Item</h5>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-2">
                                <label class="form-label small mb-1">Item Name</label>
                                <input type="text" name="itemname" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small mb-1">Category ID</label>
                                <input type="number" name="categoryid" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small mb-1">Description</label>
                                <textarea name="description" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <label class="form-label small mb-1">Price (₱)</label>
                                    <input type="number" name="price" class="form-control" required>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label small mb-1">Quantity</label>
                                    <input type="number" name="quantity" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small mb-1">Product Image</label>
                                <input type="file" name="image" class="form-control" accept=".jpg,.png" required>
                            </div>
                            <button type="submit" name="btnsave" class="btn btn-primary w-100">
                                <i class="fas fa-save me-1"></i> Add Item
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-custom overflow-hidden">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Item</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Image</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q = mysqli_query($con, "SELECT * FROM items ORDER BY id DESC");
                                    while($row = mysqli_fetch_array($q)){
                                    ?>
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-bold"><?php echo $row["itemname"]; ?></div>
                                            <small class="text-muted"><?php echo substr($row["description"], 0, 30); ?>...</small>
                                        </td>
                                        <td><span class="badge bg-light text-dark border">ID: <?php echo $row["categoryid"]; ?></span></td>
                                        <td class="text-primary fw-bold">₱<?php echo number_format($row["price"], 2); ?></td>
                                        <td><?php echo $row["quantity"]; ?></td>
                                        <td>
                                            <img src="<?php echo $row["image"]; ?>" class="item-img border shadow-sm" alt="item">
                                        </td>
                                        <td class="text-center">
                                            <a href="items_config.php?id=<?php echo $row["id"]; ?>" class="btn btn-sm btn-outline-primary">
                                                Manage
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