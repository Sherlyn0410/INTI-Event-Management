<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access";
    exit;
}

$event_id = $_GET['event_id'];

$database = new Database();
$db = $database->getConnection();

// Fetch registrants for the given event, ordered by purchaseDateTime
$query = "SELECT p.id, u.name as user_name, u.email, c.name as campus_name, p.purchaseDateTime, p.status
          FROM purchase p
          JOIN user u ON p.user_id = u.id
          JOIN ticket t ON p.ticket_id = t.id
          JOIN event e ON t.event_id = e.id
          JOIN campus c ON u.campus_id = c.id
          WHERE t.event_id = ?
          ORDER BY p.purchaseDateTime";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $event_id);
$stmt->execute();
$registrants = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($registrants)) {
    echo "<p>No registrations found.</p>";
} else {
    echo "<table class='table'>
            <thead>
                <tr>
                    <th class='bg-light'>User</th>
                    <th class='bg-light'>Email</th>
                    <th class='bg-light'>Campus</th>
                    <th class='bg-light'>Action</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($registrants as $registrant) {
        echo "<tr>
                <td>" . htmlspecialchars(ucwords($registrant['user_name'])) . "</td>
                <td>" . htmlspecialchars(ucfirst($registrant['email'])) . "</td>
                <td>" . htmlspecialchars($registrant['campus_name']) . "</td>
                <td>";
        if ($registrant['status'] == 'pending') {
            echo "<form method='POST' action='approveRegistration.php'>
                    <input type='hidden' name='purchase_id' value='" . $registrant['id'] . "'>
                    <button type='submit' name='action' value='approve' class='btn btn-success me-2'>Approve</button>
                    <button type='submit' name='action' value='reject' class='btn btn-danger'>Reject</button>
                  </form>";
        } elseif ($registrant['status'] == 'approved') {
            echo "<form method='POST' action='approveRegistration.php'>
                    <input type='hidden' name='purchase_id' value='" . $registrant['id'] . "'>
                    <button type='submit' name='action' value='remove' class='btn btn-warning'>Remove</button>
                  </form>";
        }
        echo "</td>
              </tr>";
    }
    echo "</tbody></table>";
}
?>
