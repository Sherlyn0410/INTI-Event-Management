<?php
session_start();
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
            <div class="card">
              <div class="row card-body">
                <div class="col-md-1">
                  <strong class="text-uppercase">oct<br>8</strong>
                </div>
                <div class="col-md-3">
                  <img src="/INTIEventManagement/img/Anti-DrugCampaign.jpg" class="img-fluid rounded" alt="eventImage">
                </div>
                <div class="col-md-8">
                  <div>
                    <h5 class="card-title">Changing The Narrative On Suicide</h5>
                    <p class="card-text">INTI International College Penang</p>
                    <p class="card-text">Tuesday, October 8, 2024 at 12.00 PM</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="past-tab-pane" role="tabpanel" aria-labelledby="past-tab" tabindex="0">
            <div class="card">
              <div class="row card-body">
                <div class="col-md-1">
                  <strong class="text-uppercase">sep<br>8</strong>
                </div>
                <div class="col-md-3">
                  <img src="/INTIEventManagement/img/CounsellingAwarenessMonth2024.jpg" class="img-fluid rounded" alt="eventImage">
                </div>
                <div class="col-md-8">
                  <div>
                    <h5 class="card-title">Counselling Awareness Month 2024</h5>
                    <p class="card-text">INTI International College Penang</p>
                    <p class="card-text">Sunday, September 8, 2024 at 2.00 PM</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="pending-tab-pane" role="tabpanel" aria-labelledby="pending-tab" tabindex="0">
            <div class="card">
              <div class="row card-body">
                <div class="col card-text">
                  <div class="text-body-secondary text-center"><i class="material-symbols-outlined d-block mb-2">confirmation_number</i>No pending tickets</div>
                </div>
              </div>
            </div>
          </div>

        </div>
        
      </div>
      <div class="container-fluid pt-4">
        <!-- <table class="table">
          <tr>
            <td rowspan="3">SEP<br>8</td>
            <td rowspan="3"><img src="" alt="EventImage"></td>
            <td><h2>Changing The Narrative On Suicide</h2></td>           
          </tr>
          <tr>
              <td>INTI International College Penang</td>
          </tr>
          <tr>
              <td>Sunday, September 8, 2024 at 2.00 PM</td>
          </tr>
        </table> -->
        
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