<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('User not logged in');
            window.location.href = 'eventListing.php';
          </script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$event_id = isset($_POST['event_id']) ? $_POST['event_id'] : '';

if ($event_id == '') {
    echo "<script>
            alert('Event ID is required');
            window.location.href = 'eventListing.php';
          </script>";
    exit;
}

$database = new Database();
$db = $database->getConnection();

// Check if the user has already registered for the event
$query = "SELECT * FROM purchase p
          JOIN ticket t ON p.ticket_id = t.id
          WHERE p.user_id = ? AND t.event_id = ?";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $user_id);
$stmt->bindParam(2, $event_id);
$stmt->execute();
$existingRegistration = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existingRegistration) {
    echo "<script>
            alert('You have already registered for this event.');
            window.location.href = 'eventListing.php';
          </script>";
    exit;
}

// Check for available tickets
$query = "SELECT id FROM ticket WHERE event_id = ? AND status = 'available' LIMIT 1";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $event_id);
$stmt->execute();
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ticket) {
    echo "<script>
            alert('The event is fully registered. No available tickets.');
            window.location.href = 'eventListing.php';
          </script>";
    exit;
}

$ticket_id = $ticket['id'];

// Update ticket status to 'sold'
$query = "UPDATE ticket SET status = 'sold' WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $ticket_id);
if (!$stmt->execute()) {
    echo "<script>
            alert('Failed to update ticket status');
            window.location.href = 'eventListing.php';
          </script>";
    exit;
}

// Insert into purchase table with status 'pending'
$query = "INSERT INTO purchase (user_id, ticket_id, status) VALUES (?, ?, 'pending')";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $user_id);
$stmt->bindParam(2, $ticket_id);

if ($stmt->execute()) {
    echo "<script>
            alert('Registration request sent. Pending for approval.');
            window.location.href = 'eventListing.php';
          </script>";
} else {
    echo "<script>
            alert('Registration request failed');
            window.location.href = 'eventListing.php';
          </script>";
}

exit;
?>