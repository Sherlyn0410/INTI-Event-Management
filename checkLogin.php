<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<script type="text/javascript">
        alert("You must log in to access this page.");
        window.location.href = "login.php";
    </script>';
    exit();
}
?>