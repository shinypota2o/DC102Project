<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "dbusers");
if (!isset($_SESSION["id"])) {
?>
  <h3>Authentication</h3>
  <form method="POST">
    <table>
      <tr>
        <td><label>Username:</label> </td>
        <td><input type="text" name="username" required></td>
      </tr>
      <tr>
        <td><label>Password:</label></td>
        <td><input type="password" name="password" required></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="btnlogin" value="Login"></td>
      </tr>
    </table>
    <?php
    if (isset($_POST["btnlogin"])) {
      $username = $_POST["username"];
      $password = $_POST["password"];
      $count = mysqli_num_rows(mysqli_query($con, "select * from accounts where

username='$username' and password='$password'"));

      if ($count > 0) {
        $_SESSION["id"] = $username;
        echo "<script>window.location = 'login.php';</script>";
      } else {
        echo "<span style='color:red'>Invalid username or password.</span>";
      }
    }
    ?>
  </form>
<?php
} else {
  echo "Hello, $_SESSION[id]!";
  echo "<br/><a href='logout.php'>Logout</a>";
}
?>