<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate CSRF token
}
$csrf_token = $_SESSION['csrf_token'];
$email = isset($_COOKIE['email']) ? htmlspecialchars($_COOKIE['email']) : '';
$rememberMeChecked = isset($_COOKIE['email']) ? 'checked' : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

</head>
<style>

</style>

<body>
    <section class="vh-130 bg-image">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-140">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Login</h2>
                                <form class="login-form" id="login-form" method="post">

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" required placeholder="Enter username or email" id="email" name="email"
                                            autocomplete="off" class="form-control form-control-lg" />
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="password" data-strength required placeholder="Password" id="pass"
                                            name="pass" autocomplete="off" class="form-control form-control-lg" />

                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="lsRememberMe"
                                                id="rememberMe" checked />
                                            <label class="form-check-label" for="rememberMe"> Remember me </label>
                                        </div>
                                    </div>

                                    <input type="hidden" name="csrf_token"
                                        value="<?php echo htmlspecialchars($csrf_token); ?>" />


                                    <div class="d-flex justify-content-center">
                                        <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                            class="btn btn-success btn-block btn-lg gradient-custom-4 text-body btn-width">Login</button>
                                    </div>

                                    <p class="text-center text-muted mt-5 mb-0">Don't have an account? <a
                                            href="register.php" class="fw-bold text-body"><u>Register</u></a></p>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>

    <script>
        $(document).ready(function () {


        });
        // Login form submission
        $('#login-form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: 'php/login.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response == 1) {
                        window.location.href = "dashboard.php";
                    }
                    else{
                        Toastify({
                            text: "Please check email or password not match",
                            duration: 3000,
                            gravity: "top",
                            position: "center",
                            style: {
                                background: "linear-gradient(to right, #FF6B6B, #F7A5A5)",
                            },
                        }).showToast();
                    }
                },
                error: function () {
                    $('#loginResponseMessage').html('An error occurred.');
                }
            });
        });

        //   Password show hide image
        function show() {

            var x = document.getElementById("pass");
            var showImg = document.getElementById("showimg");

            if (x.type === "password") {
                x.type = "text";
                showImg.src = "assets/images/show.png";
            } else {
                x.type = "password";
                showImg.src = "assets/images/hide.webp";
            }
        }

    </script>
</body>

</html>