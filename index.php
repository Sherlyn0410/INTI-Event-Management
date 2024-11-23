<?php
include 'checkLogin.php';

require_once 'config/database.php';
require_once 'objects/event.php';
require_once 'objects/ticket.php';

$database = new Database();
$db = $database->getConnection();
$event = new Event($db);
$ticket = new Ticket($db);

// Query the latest 3 events for the carousel
$stmt = $event->readLatest(3);
$latestEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query 4 random events for the upcoming events section
$stmt = $event->readRandom(4);
$randomEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <?php foreach ($latestEvents as $index => $event): ?>
            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
              <img src="img/<?php echo htmlspecialchars($event['image']); ?>" class="img-fluid img-md-height" alt="<?php echo htmlspecialchars($event['name']); ?>">
            </div>
          <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      <div class="container-fluid pt-4">
        <h3>Upcoming Events</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
          <?php if (empty($randomEvents)): ?>
            <div>
              <div class="py-4">No events found.</div>
            </div>
          <?php else: ?>
            <?php foreach ($randomEvents as $event): ?>
              <div class="event col">
                <a href="eventListing.php?search=<?php echo urlencode($event['name']); ?>&campus=<?php echo urlencode($event['campus_id']); ?>" class="text-decoration-none">
                  <div class="card">
                    <img src="img/<?php echo htmlspecialchars($event['image']); ?>" alt="eventImage" class="card-img-top">
                    <section>
                      <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($event['name']); ?></h5>
                        <p class="card-text">
                          <small><?php echo date('D, d M Y • h.i A', strtotime($event['startdatetime'])); ?><br>
                            <span class="text-muted"><?php echo htmlspecialchars($event['campus_name']); ?></span></small>
                        </p>
                        <?php
                        // Get the count of sold tickets for the event
                        $soldTickets = $ticket->countSoldTickets($event['id']);
                        ?>
                        <span class="d-flex"><small class="material-symbols-outlined me-1">person</small><?php echo htmlspecialchars($soldTickets); ?> registered</span>
                      </div>
                    </section>
                  </div>
                </a>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="javascript.js"></script>
<script>
  loadNavbar('home');
</script>