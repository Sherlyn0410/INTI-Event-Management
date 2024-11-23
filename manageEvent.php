<?php
include 'checkLogin.php';
require_once 'config/database.php';
require_once 'objects/event.php';
require_once 'objects/ticket.php';

$database = new Database();
$db = $database->getConnection();
$event = new Event($db);
$ticket = new Ticket($db);

// Update the status of completed events
$event->updateCompletedEvents();

// Handle delete event request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_event'])) {
    $event_id = $_POST['event_id'];
    $event->id = $event_id;
    if ($event->delete()) {
        header('Location: manageEvent.php');
        exit;
    } else {
        echo "Error deleting event.";
    }
}

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
        <h3>Manage Event</h3>
        <div class="manage-event">
            <?php if (empty($events)): ?>
                <div class="py-4">No events found.</div>
            <?php else: ?>
                <!-- Table for medium and larger screens -->
                <table class="table d-none d-md-table">
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
                                <h5><?php echo htmlspecialchars($event['name']); ?></h5>
                                <div class="text-muted"><?php echo htmlspecialchars($event['campus_name']); ?></div>
                                <div class="text-muted">
                                    <?php echo date('l, F j, Y \a\t g:i A', strtotime($event['startdatetime'])); ?> - 
                                    <?php echo date('g:i A', strtotime($event['endtime'])); ?>
                                </div>
                            </td>           
                            <td><?php echo htmlspecialchars($ticket->countSoldTickets($event['id'])); ?>/<?php echo htmlspecialchars($event['capacity']); ?></td>
                            <td class="<?php echo $event['status'] == 'published' ? 'text-success' : 'text-warning'; ?>"><?php echo htmlspecialchars(ucfirst($event['status'])); ?></td>
                            <td>
                                <span role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-symbols-outlined">more_vert</i></span>
                                <ul class="dropdown-menu">
                                    <?php if ($event['status'] === 'completed'): ?>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#manageRegistrantsModal" data-event-id="<?php echo $event['id']; ?>">Manage registrants</a></li>
                                    <?php else: ?>
                                        <li><a class="dropdown-item" href="createEvent.php?id=<?php echo $event['id']; ?>">Edit event details</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#manageRegistrantsModal" data-event-id="<?php echo $event['id']; ?>">Manage registrants</a></li>
                                        <li>
                                            <form method="POST" action="manageEvent.php" onsubmit="return confirm('Are you sure you want to delete this event?');" style="display:inline;">
                                                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                                <button type="submit" name="delete_event" class="dropdown-item">Delete event</button>
                                            </form>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Table for smaller screens -->
                <table class="table d-table d-md-none">
                    <thead class="table-dark">
                        <tr class="text-start">
                            <th scope="col">Event</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event): ?>
                        <tr>
                            <td>
                                <div class="d-flex flex-column">
                                    <strong class="text-uppercase"><?php echo date('M', strtotime($event['startdatetime'])); ?> <?php echo date('d', strtotime($event['startdatetime'])); ?></strong>
                                    <img src="/INTIEventManagement/img/<?php echo htmlspecialchars($event['image']); ?>" class="img-fluid rounded my-2" alt="EventImage">
                                    <h5><?php echo htmlspecialchars($event['name']); ?></h5>
                                    <div class="text-muted"><?php echo htmlspecialchars($event['campus_name']); ?></div>
                                    <div class="text-muted">
                                        <?php echo date('l, F j, Y \a\t g:i A', strtotime($event['startdatetime'])); ?> - 
                                        <?php echo date('g:i A', strtotime($event['endtime'])); ?>
                                    </div>
                                    <div class="d-flex"><small class="material-symbols-outlined me-1">person</small><?php echo htmlspecialchars($ticket->countSoldTickets($event['id'])); ?>/<?php echo htmlspecialchars($event['capacity']); ?></div>
                                    <div class="<?php echo $event['status'] == 'published' ? 'text-success' : 'text-warning'; ?>"><?php echo htmlspecialchars(ucfirst($event['status'])); ?></div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-symbols-outlined">more_vert</i></span>
                                    <ul class="dropdown-menu">
                                        <?php if ($event['status'] === 'completed'): ?>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#manageRegistrantsModal" data-event-id="<?php echo $event['id']; ?>">Manage registrants</a></li>
                                        <?php else: ?>
                                            <li><a class="dropdown-item" href="createEvent.php?id=<?php echo $event['id']; ?>">Edit event details</a></li>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#manageRegistrantsModal" data-event-id="<?php echo $event['id']; ?>">Manage registrants</a></li>
                                            <li>
                                                <form method="POST" action="manageEvent.php" onsubmit="return confirm('Are you sure you want to delete this event?');" style="display:inline;">
                                                    <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                                    <button type="submit" name="delete_event" class="dropdown-item">Delete event</button>
                                                </form>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="manageRegistrantsModal" tabindex="-1" aria-labelledby="manageRegistrantsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="manageRegistrantsModalLabel">Manage Registrants</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Content will be loaded here via AJAX -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <a id="download-registrant-list" class="btn btn-secondary" href="#">Download Registrant List</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="javascript.js"></script>
  <script>
    loadNavbar('manage');

    // Load registrants into the modal
    var manageRegistrantsModal = document.getElementById('manageRegistrantsModal');
    manageRegistrantsModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var eventId = button.getAttribute('data-event-id');

      var modalBody = manageRegistrantsModal.querySelector('.modal-body');
      modalBody.innerHTML = 'Loading...';

      // Fetch registrants via AJAX
      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'fetchRegistrant.php?event_id=' + eventId, true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          modalBody.innerHTML = xhr.responseText;
        }
      };
      xhr.send();

      // Set the download link for the registrant list
      var downloadButton = document.getElementById('download-registrant-list');
      downloadButton.href = 'exportRegistrant.php?event_id=' + eventId;
    });
  </script>
</body>
</html>