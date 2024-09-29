<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate CSRF token
}
$csrf_token = $_SESSION['csrf_token'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<style>.strength-message {
    margin-top: 10px;
    font-weight: bold;
}

.weak {
    color: red;
}

.medium {
    color: orange;
}

.strong {
    color: green;
}
</style>


<body>
    <section class="vh-130 bg-image">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-140">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Register Here</h2>

              <form class="register-form" id="register-form" method="post"> 

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" required placeholder="Enter name" id="uname" name="uname" autocomplete="off" class="form-control form-control-lg"/>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="email" required placeholder="Enter Email" id="uemail" name="uemail" autocomplete="off" class="form-control form-control-lg" />
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" data-strength required placeholder="Password" id="upass" name="upass"
                    autocomplete="off" class="form-control form-control-lg" />
             <div id="strengthMessage" class="strength-message"></div>
                  
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" required placeholder="Confirm Password" id="confirm-pass" name="confirm_pass"
                  autocomplete="off" class="form-control form-control-lg" />
                  </div>

                  <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>" />


                <div class="d-flex justify-content-center">
                  <button  type="submit" data-mdb-button-init
                    data-mdb-ripple-init class="btn-width btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
                </div>

                <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="index.php"
                    class="fw-bold text-body"><u>Login here</u></a></p>

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
            $('#register-form').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                var password = $('#upass').val();
                var confirmPassword = $('#confirm-pass').val();

                if (password.length < 6) {
            Toastify({
                text: "Error: Password must be at least 6 characters long.",
                duration: 3000,
                gravity: "top",
                position: 'center',
                backgroundColor: "linear-gradient(to right, #FF5F6D, #FFC371)",
            }).showToast();
            return; 
        }

                if (password !== confirmPassword) {
                    Toastify({
                        text: "Password not match",
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "center",
                        stopOnFocus: true,
                        style: {
                            background: "linear-gradient(to right, #ff0808, #ff0808)",
                        },
                        onClick: function () { }
                    }).showToast();
                    return;
                } else {
                    $('#valid-pass').text("");
                }

                $.ajax({
                    type: 'POST',
                    url: 'php/register.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response == "1") {
                            Toastify({
                                text: "Registered Successfully,please Login",
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top",
                                position: "center",
                                stopOnFocus: true,
                                style: {
                                    background: "linear-gradient(to right, #86f5b9, #F7A5A5)",
                                },
                                onClick: function () { }
                            }).showToast();

                            setTimeout(() => {
                                window.location.href = "index.php";
                            }, 3000);
                        }
                        else if (response == 2) {
                            Toastify({
                                text: "email already exist, try another",
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top",
                                position: "center",
                                stopOnFocus: true,
                                style: {
                                    background: "linear-gradient(to right, #FF6B6B, #F7A5A5)",
                                },
                                onClick: function () { }
                            }).showToast();
                        }else if(response==3){
                            Toastify({
                                text: "name already exist, try another",
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top",
                                position: "center",
                                stopOnFocus: true,
                                style: {
                                    background: "linear-gradient(to right, #FF6B6B, #F7A5A5)",
                                },
                                onClick: function () { }
                            }).showToast();
                        }
                        else {
                            Toastify({
                                text: "email and name already exists. Please try another.",
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top",
                                position: "center",
                                stopOnFocus: true,
                                style: {
                                    background: "linear-gradient(to right, #FF6B6B, #F7A5A5)",
                                },
                                onClick: function () { }
                            }).showToast();
                        }

                    },
                    error: function () {
                        $('#valid-pass').text('An error occurred.');
                    }
                });
            });
        });

        // Password strength checking
        document.getElementById('upass').addEventListener('keyup', function() {
    const password = this.value;
    const strengthMessage = document.getElementById('strengthMessage');
    
    const hasUpperCase = /[A-Z]/.test(password);
    const hasLowerCase = /[a-z]/.test(password);
    const hasNumbers = /\d/.test(password);
    const hasSpecialChars = /[!@#$%^&*(),.?":{}|<>]/.test(password);
    
    let strength = '';
    let missingChars = [];

    // Check for missing character types
    if (!hasUpperCase) missingChars.push('(A-Z)');
    if (!hasLowerCase) missingChars.push('(a-z)');
    if (!hasNumbers) missingChars.push(' (0-9)');
    if (!hasSpecialChars) missingChars.push(' (!@#$%^&*)');
    
    if (password.length < 6) {
        strength = 'Weak';
        strengthMessage.className = 'strength-message weak';
    } else if (hasUpperCase && hasLowerCase && hasNumbers && hasSpecialChars && password.length >= 8) {
        strength = 'Strong';
        strengthMessage.className = 'strength-message strong';
    } else {
        strength = 'Medium';
        strengthMessage.className = 'strength-message medium';
    }
    
    if (missingChars.length > 0) {
        strengthMessage.textContent = `Password strength: ${strength}. Missing: ${missingChars.join(', ')}.`;
    } else {
        strengthMessage.textContent = `Password strength: ${strength}.`;
    }
});

document.getElementById('upass').addEventListener('blur', function() {
    document.getElementById('strengthMessage').textContent = '';
});



    </script>
</body>

</html>