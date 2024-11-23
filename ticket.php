<?php
include 'checkLogin.php';
require_once 'config/database.php';
require_once 'objects/purchase.php';

$database = new Database();
$db = $database->getConnection();
$purchase = new Purchase($db);

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch purchases by user ID
$stmt = $purchase->readByUser($user_id);
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
      <h3>Tickets</h3>
      <div>
        <ul class="nav nav-underline" id="eventTicketTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming-tab-pane" type="button" role="tab" aria-controls="upcoming-tab-pane" aria-selected="true">Upcoming events</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past-tab-pane" type="button" role="tab" aria-controls="past-tab-pane" aria-selected="false">Past events</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-tab-pane" type="button" role="tab" aria-controls="pending-tab-pane" aria-selected="false">Pending approval</a>
          </li>
        </ul>
        <div class="tab-content pt-4" id="eventTicketTabContent">
          <div class="tab-pane fade show active" id="upcoming-tab-pane" role="tabpanel" aria-labelledby="upcoming-tab" tabindex="0">
            <?php $upcomingFound = false; ?>
            <?php foreach ($purchases as $purchase): ?>
              <?php if (strtotime($purchase['startdatetime']) > time() && $purchase['status'] == 'approved'): ?>
                <?php $upcomingFound = true; ?>
                <div class="card mb-3">
                  <div class="row card-body">
                    <div class="col-md-1">
                      <strong class="text-uppercase"><?php echo date('M', strtotime($purchase['startdatetime'])); ?><br><?php echo date('d', strtotime($purchase['startdatetime'])); ?></strong>
                    </div>
                    <div class="col-md-3">
                      <img src="/INTIEventManagement/img/<?php echo htmlspecialchars($purchase['event_image']); ?>" class="img-fluid rounded" alt="eventImage">
                    </div>
                    <div class="col-md-8">
                      <div>
                        <h5 class="card-title"><?php echo htmlspecialchars($purchase['event_name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($purchase['campus_name']); ?></p>
                        <p class="card-text"><?php echo date('l, F j, Y \a\t g:i A', strtotime($purchase['startdatetime'])); ?> - 
                        <?php echo date('g:i A', strtotime($purchase['endtime'])); ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
            <?php if (!$upcomingFound): ?>
              <div class="card">
                <div class="row card-body">
                  <div class="col card-text">
                    <div class="text-body-secondary text-center"><i class="material-symbols-outlined d-block mb-2">confirmation_number</i>No upcoming tickets found</div>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </div>
          <div class="tab-pane fade" id="past-tab-pane" role="tabpanel" aria-labelledby="past-tab" tabindex="0">
            <?php $pastFound = false; ?>
            <?php foreach ($purchases as $purchase): ?>
              <?php if (strtotime($purchase['startdatetime']) <= time() && $purchase['status'] == 'approved'): ?>
                <?php $pastFound = true; ?>
                <div class="card mb-3">
                  <div class="row card-body">
                    <div class="col-md-1">
                      <strong class="text-uppercase"><?php echo date('M', strtotime($purchase['startdatetime'])); ?><br><?php echo date('d', strtotime($purchase['startdatetime'])); ?></strong>
                    </div>
                    <div class="col-md-3">
                      <img src="/INTIEventManagement/img/<?php echo htmlspecialchars($purchase['event_image']); ?>" class="img-fluid rounded my-2 my-md-0" alt="eventImage">
                    </div>
                    <div class="col-md-8">
                      <div>
                        <h5 class="card-title"><?php echo htmlspecialchars($purchase['event_name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($purchase['campus_name']); ?></p>
                        <p class="card-text"><?php echo date('l, F j, Y \a\t g:i A', strtotime($purchase['startdatetime'])); ?> - 
                        <?php echo date('g:i A', strtotime($purchase['endtime'])); ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
            <?php if (!$pastFound): ?>
              <div class="card">
                <div class="row card-body">
                  <div class="col card-text">
                    <div class="text-body-secondary text-center"><i class="material-symbols-outlined d-block mb-2">confirmation_number</i>No past tickets found</div>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </div>
          <div class="tab-pane fade" id="pending-tab-pane" role="tabpanel" aria-labelledby="pending-tab" tabindex="0">
            <?php $pendingFound = false; ?>
            <?php foreach ($purchases as $purchase): ?>
              <?php if ($purchase['status'] == 'pending'): ?>
                <?php $pendingFound = true; ?>
                <div class="card mb-3">
                  <div class="row card-body">
                    <div class="col-md-1">
                      <strong class="text-uppercase"><?php echo date('M', strtotime($purchase['startdatetime'])); ?><br><?php echo date('d', strtotime($purchase['startdatetime'])); ?></strong>
                    </div>
                    <div class="col-md-3">
                      <img src="/INTIEventManagement/img/<?php echo htmlspecialchars($purchase['event_image']); ?>" class="img-fluid rounded" alt="eventImage">
                    </div>
                    <div class="col-md-8">
                      <div>
                        <h5 class="card-title"><?php echo htmlspecialchars($purchase['event_name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($purchase['campus_name']); ?></p>
                        <p class="card-text"><?php echo date('l, F j, Y \a\t g:i A', strtotime($purchase['startdatetime'])); ?> - 
                        <?php echo date('g:i A', strtotime($purchase['endtime'])); ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
            <?php if (!$pendingFound): ?>
              <div class="card">
                <div class="card-body">
                  <div class="text-body-secondary text-center"><i class="material-symbols-outlined d-block mb-2">confirmation_number</i>No pending tickets found</div>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="javascript.js"></script>
<script>
  loadNavbar('tickets');
</script>