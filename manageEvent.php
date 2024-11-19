<?php
session_start();
require_once 'config/database.php';
require_once 'objects/event.php';

$database = new Database();
$db = $database->getConnection();
$event = new Event($db);

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Query the events created by the logged-in user
$stmt = $event->readByUser($user_id);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
<body>
  <?php include 'session_script.php'; ?>
  <div id="navbar-placeholder"></div>
  <div class="main-wrapper">
    <div class="wrapper-padding">
        <h3>Events</h3>
        <div class="row justify-content-between mb-3">
          <div class="col-6 d-flex">
            <input class="form-control me-md-2" type="search" placeholder="Search events here..." aria-label="Search">
          </div>
            <div class="col-2 text-end">
                <a class="btn btn-secondary btn-create" href="createEvent.php">Create Event</a>
            </div>
        </div>
        <div class="manage-event">
            <?php if (empty($events)): ?>
                <div class="py-4">No events found.</div>
            <?php else: ?>
            <table class="table">
                <thead class="table-dark">
                    <tr class="text-start">
                        <th scope="col" colspan="3">Event</th>
                        <th scope="col">Registered</th>
                        <th scope="col">Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach ($events as $event): ?>
                  <tr>
                    <th scope="row" class="text-uppercase"><?php echo date('M', strtotime($event['startdatetime'])); ?><br><?php echo date('d', strtotime($event['startdatetime'])); ?></th>
                    <td class="col-3"><img src="/INTIEventManagement/img/<?php echo htmlspecialchars($event['image']); ?>" class="img-fluid rounded" alt="EventImage"></td>
                    <td>
                        <strong><?php echo htmlspecialchars($event['name']); ?></strong><br>
                        <div><small class="text-muted"><?php echo htmlspecialchars($event['campus_name']); ?></small></div>
                        <div><small class="text-muted"><?php echo date('l, F j, Y \a\t g:i A', strtotime($event['startdatetime'])); ?></small></div>
                    </td>           
                    <td>/<?php echo htmlspecialchars($event['capacity']); ?></td>
                    <td class="<?php echo $event['status'] == 'Published' ? 'text-success' : 'text-danger'; ?>"><?php echo htmlspecialchars($event['status']); ?></td>
                    <td>
                        <span role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-symbols-outlined">more_vert</i></span>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="createEvent.php?id=<?php echo $event['id']; ?>">Edit event</a></li>
                        <li><a class="dropdown-item" href="#">Export CSV</a></li>
                        <li><a class="dropdown-item" href="#">Delete</a></li>
                        </ul>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
  </div>

</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="javascript.js"></script>
<script>
  loadNavbar('manage');
</script>