<?php
include "config/connect.php";
session_start();

if (!isset($_POST['cart_ids'])) {
    echo "<script>
            alert('Please select at least one item.');
            window.history.back();
          </script>";
    exit;
}

$ids = $_POST['cart_ids'];
$subtotal = 0;
$shipping = 100;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Benta.ph</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="mb-3">
                <a href="cart.php" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Cart
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 fw-bold text-black">Order Summary</h4>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Item Name</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $contact = "";
                                $address = "";

                                foreach ($ids as $id) {
                                    $query = mysqli_query($con, "
                                        SELECT c.quantity AS cart_qty,
                                               c.price,
                                               i.itemname,
                                               p.contact_number,
                                               p.address
                                        FROM cart c
                                        JOIN items i ON c.itemid = i.id
                                        JOIN profile p ON c.profile_id = p.id
                                        WHERE c.id = '$id'
                                    ");

                                    $row = mysqli_fetch_array($query);
                                    $total = $row['price'];
                                    $subtotal += $total;

                                    $contact = $row['contact_number'];
                                    $address = $row['address'];
                                ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?php echo $row['itemname']; ?></div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary rounded-pill"><?php echo $row['cart_qty']; ?></span>
                                    </td>
                                    <td class="text-end text-nowrap">₱<?php echo number_format($row['price'], 2); ?></td>
                                    <td class="text-end text-nowrap">₱<?php echo number_format($total, 2); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-4">
                            <div class="p-3 bg-light rounded shadow-sm border">
                                <h6 class="fw-bold text-uppercase small text-muted mb-3">Delivery Information</h6>
                                <p class="mb-1"><i class="bi bi-telephone"></i> <strong>Contact:</strong> <?php echo $contact; ?></p>
                                <p class="mb-0"><i class="bi bi-geo-alt"></i> <strong>Address:</strong><br><?php echo $address; ?></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span>₱<?php echo number_format($subtotal, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Shipping Fee</span>
                                <span>₱<?php echo number_format($shipping, 2); ?></span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="h5 fw-bold">Total Amount</span>
                                <span class="h5 fw-bold text-danger">₱<?php echo number_format($subtotal + $shipping, 2); ?></span>
                            </div>

                            <form method="POST" action="place_order.php">
                                <?php
                                foreach ($ids as $id) {
                                    echo "<input type='hidden' name='cart_ids[]' value='$id'>";
                                }
                                ?>
                                <input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>">
                                <input type="hidden" name="shipping" value="<?php echo $shipping; ?>">
                                <input type="hidden" name="contact" value="<?php echo $contact; ?>">
                                <input type="hidden" name="address" value="<?php echo $address; ?>">

                                <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm fw-bold">
                                    Place Order Now
                                </button>
                            </form>
                        </div>
                    </div>

                </div> 
            </div> 
            
            <p class="text-center text-muted mt-4 small">
                Benta.ph &copy; 2026 - Secure Checkout
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>