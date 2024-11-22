<?php
include 'checkLogin.php';
require_once 'config/database.php';
require_once 'objects/event.php';

$database = new Database();
$db = $database->getConnection();
$event = new Event($db);

// Get search parameters
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
$searchCampus = isset($_GET['campus']) ? $_GET['campus'] : '';

// Query events with search parameters
if ($searchKeyword || $searchCampus) {
    $stmt = $event->search($searchKeyword, $searchCampus);
} else {
    $stmt = $event->read();
}
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTI Event Management</title>
</head>
<body>
  <?php include 'session_script.php'; ?>
  <div id="navbar-placeholder"></div>
  <div class="main-wrapper">
    <div class="wrapper-padding">
      <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
      <form method="GET" action="eventListing.php">
        <div class="d-flex flex-column flex-md-row">
          <input class="me-md-2 mb-2 mb-md-0 form-control" type="search" name="search" placeholder="Search events you are interested here..." aria-label="Search" value="<?php echo htmlspecialchars($searchKeyword); ?>">
          <select name="campus" class="form-select me-md-2 mb-2 mb-md-0">
            <option value="0">All Campuses</option>
            <option value="1" <?php if ($searchCampus == '1') echo 'selected'; ?>>INTI International University</option>
            <option value="2" <?php if ($searchCampus == '2') echo 'selected'; ?>>INTI International College Subang</option>
            <option value="3" <?php if ($searchCampus == '3') echo 'selected'; ?>>INTI International College Penang</option>
            <option value="4" <?php if ($searchCampus == '4') echo 'selected'; ?>>INTI International College Sabah</option>
          </select>
          <button class="btn btn-secondary btn-radius" type="submit">Search</button>
        </div>
      </form>
      <div class="container-fluid pt-4">
        <h3>Events</h3>
        <?php if (empty($events)): ?>
          <div class="py-4">No events found.</div>
        <?php else: ?>
          <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php foreach ($events as $event): ?>
            <div class="event col">
              <div type="button" data-bs-toggle="modal" data-bs-target="#registerModal-<?php echo $event['id']; ?>">
                <div class="card">
                    <img src="img/<?php echo htmlspecialchars($event['image']); ?>" alt="eventImage" class="card-img-top">
                    <section>
                      <div class="card-body">
                          <h5 class="card-title"><?php echo htmlspecialchars($event['name']); ?></h5>
                          <p class="card-text">
                            <small><?php echo date('D, d M Y • h.i A', strtotime($event['startdatetime'])); ?><br>
                              <span class="text-muted"><?php echo htmlspecialchars($event['campus_name']); ?></span></small>
                          </p>
                      </div>
                    </section>
                </div>
              </div>
              <div class="modal" id="registerModal-<?php echo $event['id']; ?>">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                  <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Summary</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                      <img src="img/<?php echo htmlspecialchars($event['image']); ?>" alt="eventImage" class="img-fluid rounded">
                      <h2><?php echo htmlspecialchars($event['name']); ?></h2>
                      <form class="event-info pt-2">
                        <div class="pb-4">
                          <h3>Date and Time</h3>
                          <span><?php echo date('D, d M Y • h.i A', strtotime($event['startdatetime'])); ?></span>
                        </div>
                        <div class="pb-4">
                          <h3>Location</h3>
                          <span><?php echo htmlspecialchars($event['campus_name']); ?></span>
                        </div>
                        <div class="pb-4">
                          <h3>About this event</h3>
                          <span><?php echo htmlspecialchars($event['description']); ?></span>
                        </div>
                      </form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <form method="POST" action="registerEvent.php">
                        <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-secondary">Register</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="javascript.js"></script>
<script>
  loadNavbar('browse');
</script>