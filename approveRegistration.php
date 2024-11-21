<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $purchase_id = $_POST['purchase_id'];
    $action = $_POST['action'];

    // Fetch the purchase and ticket details
    $query = "SELECT p.ticket_id, p.status, t.event_id, e.user_id as event_creator_id 
              FROM purchase p
              JOIN ticket t ON p.ticket_id = t.id
              JOIN event e ON t.event_id = e.id
              WHERE p.id = ?";
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $purchase_id);
    $stmt->execute();
    $purchase = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$purchase) {
        echo "<script>
                alert('Purchase not found');
                window.location.href = 'manageEvent.php';
              </script>";
        exit;
    }

    // Ensure the logged-in user is the event creator
    if ($purchase['event_creator_id'] != $_SESSION['user_id']) {
        echo "<script>
                alert('You are not authorized to manage this registration.');
                window.location.href = 'manageEvent.php';
              </script>";
        exit;
    }

    $ticket_id = $purchase['ticket_id'];

    if ($action == 'approve') {
        // Update purchase status to 'approved' and ticket status to 'sold'
        $query = "UPDATE purchase SET status = 'approved' WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $purchase_id);
        $stmt->execute();

        $query = "UPDATE ticket SET status = 'sold' WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $ticket_id);
        $stmt->execute();

        echo "<script>
                alert('Registration approved');
                window.location.href = 'manageEvent.php';
              </script>";
    } elseif ($action == 'reject' || $action == 'remove') {
        // Delete the purchase record and update ticket status to 'available'
        $query = "DELETE FROM purchase WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $purchase_id);
        $stmt->execute();

        $query = "UPDATE ticket SET status = 'available' WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $ticket_id);
        $stmt->execute();

        $message = $action == 'reject' ? 'Registration rejected' : 'Registration removed';
        echo "<script>
                alert('$message');
                window.location.href = 'manageEvent.php';
              </script>";
    } else {
        echo "<script>
                alert('Invalid action');
                window.location.href = 'manageEvent.php';
              </script>";
    }

    exit;
}
?>