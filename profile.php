<?php
$client_id = $_SESSION['user_id'];

$status_msg = "";
$status_type = "";

$query = mysqli_query($con, "SELECT * FROM profile WHERE client_id='$client_id'");
$user = mysqli_fetch_array($query);

if (isset($_POST['update'])) {
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    $update_info = mysqli_query($con, "UPDATE profile SET contact_number='$contact', address='$address' WHERE client_id='$client_id'");

    if ($update_info) {
        $status_msg = "Profile details updated successfully!";
        $status_type = "success";

        if (!empty($password)) {
            if ($password != $confirm) {
                $status_msg = "Passwords do not match. Profile updated, but password remains unchanged.";
                $status_type = "warning";
            } else {
                mysqli_query($con, "UPDATE profile SET password='$password' WHERE client_id='$client_id'");
                $status_msg = "Profile and password updated successfully!";
                $status_type = "success";
            }
        }
    } else {
        $status_msg = "Error updating profile. Please try again.";
        $status_type = "danger";
    }

    $query = mysqli_query($con, "SELECT * FROM profile WHERE client_id='$client_id'");
    $user = mysqli_fetch_array($query);
}
?>

<?php if ($status_msg != ""): ?>
    <div class="alert alert-<?php echo $status_type; ?> alert-dismissible fade show" role="alert">
        <i class="fas <?php echo ($status_type == 'success') ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?> me-2"></i>
        <?php echo $status_msg; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<form method="POST">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label fw-bold small text-muted text-uppercase">Contact Number</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-phone text-muted"></i></span>
                <input type="text" name="contact" class="form-control" value="<?php echo $user['contact_number']; ?>" required placeholder="e.g. 09123456789">
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold small text-muted text-uppercase">Email Address (Login)</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                <input type="email" class="form-control" value="<?php echo $_SESSION['email']; ?>" disabled>
            </div>
        </div>

        <div class="col-12">
            <label class="form-label fw-bold small text-muted text-uppercase">Delivery Address</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-map-marker-alt text-muted"></i></span>
                <input type="text" name="address" class="form-control" value="<?php echo $user['address']; ?>" required placeholder="House No., Street, Brgy, City">
            </div>
        </div>

        <div class="col-12 mt-4">
            <hr>
            <p class="text-primary fw-bold mb-2 small"><i class="fas fa-lock me-2"></i>CHANGE PASSWORD (LEAVE BLANK TO KEEP CURRENT)</p>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold small text-muted text-uppercase">New Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••">
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold small text-muted text-uppercase">Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="••••••••">
        </div>

        <div class="col-12 text-end mt-4">
            <button type="submit" name="update" class="btn btn-primary px-4 py-2 shadow-sm">
                <i class="fas fa-save me-2"></i>Update Account
            </button>
        </div>
    </div>
</form>