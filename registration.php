<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();

// Fetch pending registrations
$query = "SELECT p.id, p.user_id, p.ticket_id, e.name as event_name, u.username as user_name
          FROM purchase p
          JOIN ticket t ON p.ticket_id = t.id
          JOIN event e ON t.event_id = e.id
          JOIN user u ON p.user_id = u.id
          WHERE p.status = 'pending' AND e.organizer_id = ?";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $_SESSION['user_id']);
$stmt->execute();
$registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $registration_id = $_POST['registration_id'];
    $action = $_POST['action'];

    if ($action == 'approve') {
        $status = 'registered';
    } elseif ($action == 'reject') {
        $status = 'rejected';
    }

    $query = "UPDATE purchase SET status = ? WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $status);
    $stmt->bindParam(2, $registration_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Registration status updated successfully';
    } else {
        $_SESSION['message'] = 'Failed to update registration status';
    }

    header('Location: approveRegistrations.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Registrations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2>Pending Registrations</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Event</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registrations as $registration): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($registration['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($registration['event_name']); ?></td>
                        <td>
                            <form method="POST" action="approveRegistrations.php">
                                <input type="hidden" name="registration_id" value="<?php echo $registration['id']; ?>">
                                <button type="submit" name="action" value="approve" class="btn btn-success">Approve</button>
                                <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>