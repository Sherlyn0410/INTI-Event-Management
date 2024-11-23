<?php
session_start();
require_once 'config/database.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $database = new Database();
        $db = $database->getConnection();

        // Check if the email exists
        $query = "SELECT id, password FROM user WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $current_password = $row['password'];

            // Check if the new password is the same as the current password
            if ($new_password === $current_password || password_verify($new_password, $current_password)) {
                $error = "The new password cannot be the same as the current password.";
            } else {
                // Update the password as plain text
                $query = "UPDATE user SET password = :new_password WHERE email = :email";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':new_password', $new_password);
                $stmt->bindParam(':email', $email);

                if ($stmt->execute()) {
                    $success = "Password updated successfully.";
                } else {
                    $error = "Failed to update the password.";
                }
            }
        } else {
            $error = "Email not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTI Event Management</title>
</head>
<body class="login-body">
    <div class="login-container mx-4 mx-sm-0">
        <img src="/INTIEventManagement/img/INTIlogo.png" width="206" height="44" class="d-inline-block align-text-top" alt="INTILogo">
        <h3 class="mt-4">Forgot Password</h3>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php else: ?>
            <form action="forgotpass.php" method="post">
                <div class="login-form-container">
                    <label for="email"><b>Email</b></label>
                    <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
            
                    <label for="new_password"><b>New Password</b></label>
                    <input type="password" class="form-control" placeholder="Enter New Password" name="new_password" required>
            
                    <label for="confirm_password"><b>Confirm New Password</b></label>
                    <input type="password" class="form-control mb-0" placeholder="Confirm New Password" name="confirm_password" required>
            
                    <button class="mt-4 btn btn-secondary" type="submit">Submit</button>
                </div>
            </form>
        <?php endif; ?>
        <div class="text-end mt-2"><a href="login.php">Back to login</a></div>
    </div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>