<?php
include 'checkLogin.php';
require_once 'config/database.php';

$event_id = $_GET['event_id'];

$database = new Database();
$db = $database->getConnection();

// Fetch the event name
$query = "SELECT name FROM event WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $event_id);
$stmt->execute();
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    echo "<p>Event not found.</p>";
    exit;
}

$event_name = $event['name'];

// Fetch registrants for the given event with status 'approved', ordered by user ID
$query = "SELECT u.id as user_id, u.name as user_name, u.email, u.phoneNo, c.name as campus_name, p.status
          FROM purchase p
          JOIN user u ON p.user_id = u.id
          JOIN ticket t ON p.ticket_id = t.id
          JOIN event e ON t.event_id = e.id
          JOIN campus c ON u.campus_id = c.id
          WHERE t.event_id = ? AND p.status = 'approved'
          ORDER BY u.id";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $event_id);
$stmt->execute();
$registrants = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($registrants)) {
    echo "<script>
            alert('No approved registrations found.');
            window.location.href = 'manageEvent.php';
        </script>";
    exit;
}

// Set the headers to indicate a file download
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $event_name) . '.csv"');

// Open the output stream
$output = fopen('php://output', 'w');

// Write the header row
fputcsv($output, ['User ID', 'Name', 'Email', 'Contact Number', 'Campus']);

// Write the data rows
foreach ($registrants as $registrant) {
    fputcsv($output, [
        $registrant['user_id'],
        $registrant['user_name'],
        $registrant['email'],
        '+60' . $registrant['phoneNo'],
        $registrant['campus_name']
    ]);
}

// Close the output stream
fclose($output);
exit;
?>