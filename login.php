<?php
session_start();
require_once 'config/database.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptcha_secret = '6LfY-oYqAAAAAJzNN7CfRKO5zCCzxi5q_9ungE84';
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $response_keys = json_decode($response, true);

    if (intval($response_keys["success"]) !== 1) {
        $error = "Please complete the reCAPTCHA.";
    } else {
        $database = new Database();
        $db = $database->getConnection();

        $user_id = $_POST['user_id'];
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);

        if ($database->authenticate($user_id, $password)) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password.";
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
        <h3 class="my-4">Log in</h3>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="login-form-container">
                <label for="user_id"><b>Student ID</b></label>
                <input type="text" class="form-control" placeholder="Enter Student ID" name="user_id" required>
        
                <label for="password"><b>Password</b></label>
                <input type="password" class="form-control mb-0" placeholder="Enter Password" name="password" required>
                <!-- <div class="text-end mb-2"><a href="forgotPass.html">Forgot password?</a></div> -->
        
                <div class="pt-4 g-recaptcha" data-sitekey="6LfY-oYqAAAAAPPzEraWObmaAAcDZfZjqi85rFLR"></div>
                <button class="mt-4 btn btn-secondary" type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
