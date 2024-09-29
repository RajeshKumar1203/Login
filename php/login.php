<?php
include("config.php");

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            echo "Invalid CSRF token.";
            exit;
        }

        // $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $query = "SELECT * FROM login_details WHERE email='$email' or name='$email'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $passwordVerified = password_verify($pass, $row['password']);
            
            if ($passwordVerified) {
                $_SESSION["id"] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];

                $q = "UPDATE login_details SET last_login=NOW() WHERE id='$_SESSION[id]'";
                mysqli_query($con, $q);

                // Check if Remember Me is checked
                if (isset($_POST['rememberMe'])) {
                    setcookie('email', $email, time() + (86400 * 30), "/"); 
                    setcookie('password', password_hash($pass, PASSWORD_BCRYPT), time() + (86400 * 30), "/");
                } else {
                    setcookie('email', '', time() - 3600, "/");
                    setcookie('password', '', time() - 3600, "/");
                }

                echo "1";
            } else {
                echo "2";
            }
        } else {
            echo "No user found.";
        }
    }
} catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}

mysqli_close($con);
?>
