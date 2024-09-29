<?php
include("config.php");

try {
    // CSRF Token Validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        throw new Exception("CSRF token validation failed.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['uname'];
        $email = $_POST['uemail'];
        $pass = $_POST['upass'];

        $stmt = $con->prepare("SELECT * FROM login_details WHERE email = ? OR name = ?");
        $stmt->bind_param('ss', $email, $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $existingEmails = [];
            $existingNames = [];

            while ($row = $result->fetch_assoc()) {
                if ($row['email'] == $email) {
                    $existingEmails[] = $email;
                }
                if ($row['name'] == $name) {
                    $existingNames[] = $name;
                }
            }

            $messages = [];
            if (!empty($existingEmails)) {
                $messages[] = "2";
            }
            if (!empty($existingNames)) {
                $messages[] = "3";
            }

            echo implode(" ", $messages); 
        } else {
            $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);

            $insertStmt = $con->prepare("INSERT INTO login_details (name, email, password, registerd_time) VALUES (?, ?, ?, NOW())");
            $insertStmt->bind_param('sss', $name, $email, $hashed_pass);

            if ($insertStmt->execute()) {
                echo "1"; 
            } else {
                throw new Exception("Error inserting user: " . $insertStmt->error);
            }

            $insertStmt->close();
        }

        $stmt->close();
    }
} catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
} finally {
    $con->close();
}
?>
