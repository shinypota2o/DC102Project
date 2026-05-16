<?php
$con = mysqli_connect("localhost", "root", "", "bentaph");
?>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB client</title>
        <link href="assets/css/admin-style.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Register</h3></div>
                                    <div class="card-body">
                                        <form method="POST">

                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="fullname" type="text" name="fullname" />
                                                <label for="inputEmail">Fullname:</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="age" type="number" name="age" />
                                                <label for="inputEmail">Age:</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="contact_number" type="number" name="contact_number" />
                                                <label for="inputEmail">Contact Number:</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="address" type="text" name="address" />
                                                <label for="inputEmail">Address:</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" />
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Password" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type="submit" name="submit">Register</button>
                                            </div>
                                            <?php
                                            if(isset($_POST['submit'])){
                                              $fullname = $_POST['fullname'];
                                              $age = $_POST['age'];
                                              $contact_number = $_POST['contact_number'];
                                              $address = $_POST['address'];
                                              $email = $_POST['email'];
                                              $password = $_POST['password'];
                                              $personal = "INSERT INTO profile(fullname,age,contact_number,address) VALUES ('$fullname','$age','$contact_number','$address')";
                                              $sql = "INSERT INTO clientUsers(email,password) VALUES ('$email','$password')";
                                              mysqli_query($con,$sql);
                                              mysqli_query($con,$personal);
                                            }

                                            ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="/assets/js/admin-scripts.js"></script>
    </body>
</html>
