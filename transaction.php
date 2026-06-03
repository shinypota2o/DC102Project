<?php
include_once "config/connect.php";

if (isset($_GET['cancel'])) {
    $id = mysqli_real_escape_string($con, $_GET['cancel']);
    mysqli_query($con, "UPDATE transactions SET status='Cancelled' WHERE id='$id'");
    echo "<script>alert('Transaction Cancelled'); window.location='transaction-client.php';</script>";
    exit();
}

if (isset($_GET['view'])) {
    $id = mysqli_real_escape_string($con, $_GET['view']);
    $query = mysqli_query($con, "SELECT t.*, p.* FROM transactions t JOIN profile p ON t.clientid = p.client_id WHERE t.id='$id'");
    $t = mysqli_fetch_array($query);

    if ($t):
?>
    <div class="p-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Order Details #<?php echo $t['id']; ?></h4>
            <a href="transaction-client.php" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="row g-4">
            <div class="col-md-7">
                <div class="card border shadow-sm">
                    <div class="card-body">
                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Customer Information</h6>
                        <p class="mb-1"><strong>Name:</strong> <?php echo $t['fullname']; ?></p>
                        <p class="mb-1"><strong>Contact:</strong> <?php echo $t['contact_number']; ?></p>
                        <p class="mb-1"><strong>Address:</strong> <?php echo $t['address']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card border shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Order Summary</h6>
                        <p class="mb-1"><strong>Status:</strong> 
                            <?php 
                                $status = $t['status'];
                                $badge = ($status == 'Pending') ? 'bg-warning text-dark' : (($status == 'Cancelled') ? 'bg-danger' : 'bg-success');
                                echo "<span class='badge $badge'>$status</span>";
                            ?>
                        </p>
                        <p class="mb-1"><strong>Date:</strong> <?php echo date('M d, Y', strtotime($t['orderdate'])); ?></p>
                        <h3 class="mt-3 text-primary fw-bold">₱<?php echo number_format($t['total'], 2); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <?php if ($t['status'] == "Pending" || $t['status'] == "Approved"): ?>
                <a href="transaction-client.php?cancel=<?php echo $t['id']; ?>" 
                   onclick="return confirm('Are you sure you want to cancel this transaction?')" 
                   class="btn btn-danger">
                    <i class="fas fa-times-circle me-1"></i> Cancel Transaction
                </a>
            <?php endif; ?>
        </div>
    </div>

<?php 
    endif; 
} 

else {
?>
    <div class="table-responsive p-2">
        <table class="table table-hover align-middle border-top">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $clientid = $_SESSION['user_id'];
                $query = mysqli_query($con, "SELECT * FROM transactions WHERE clientid='$clientid' ORDER BY orderdate DESC");

                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_array($query)) {
                        $status = $row['status'];
                        $badge = ($status == 'Pending') ? 'bg-warning text-dark' : (($status == 'Cancelled') ? 'bg-danger' : 'bg-success');
                        
                        echo "
                        <tr>
                            <td class='fw-bold'>#{$row['id']}</td>
                            <td class='text-muted'>" . date('M d, Y', strtotime($row['orderdate'])) . "</td>
                            <td class='fw-bold'>₱" . number_format($row['total'], 2) . "</td>
                            <td><span class='badge $badge'>$status</span></td>
                            <td class='text-center'>
                                <div class='btn-group'>
                                    <a href='transaction-client.php?view={$row['id']}' class='btn btn-sm btn-outline-primary'>
                                        <i class='fas fa-eye'></i> View
                                    </a>";
                                    
                        if ($status == "Pending" || $status == "Approved") {
                            echo "  <a href='transaction-client.php?cancel={$row['id']}' 
                                       onclick='return confirm(\"Cancel this transaction?\")' 
                                       class='btn btn-sm btn-outline-danger'>
                                       <i class='fas fa-times'></i>
                                    </a>";
                        }
                        echo "
                                </div>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center py-4 text-muted'>No transactions found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<?php } ?>