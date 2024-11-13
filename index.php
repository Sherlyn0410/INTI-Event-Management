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
      <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="/INTIEventManagement/img/Anti-DrugCampaign.jpg" class="d-block w-100" alt="Anti-DrugCampaign">
          </div>
          <div class="carousel-item">
            <img src="/INTIEventManagement/img/CounsellingAwarenessMonth2024.jpg" class="d-block w-100" alt="CounsellingAwareness">
          </div>
          <div class="carousel-item">
            <img src="/INTIEventManagement/img/FunGamesforHappMinds.jpg" class="d-block w-100" alt="FunGamesforHappMinds">
          </div>
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
          <div class="col">
            <div type="button" data-bs-toggle="modal" data-bs-target="#registerModal">
              <div class="card">
                  <img src="/INTIEventManagement/img/CounsellingAwarenessMonth2024.jpg" alt="eventImage" class="card-img-top">
                  <section>
                    <div class="card-body">
                        <h5 class="card-title">Counselling Awareness Month 2024</h5>
                        <p class="card-text">
                          <small>Mon, 2 Sep 2024 • 10.00 AM<br>
                            <span class="text-muted">INTI International College Penang</span></small>
                        </p>
                        <span class="d-flex"><small class="material-symbols-outlined me-1">person</small>87 registered</span>
                    </div>
                  </section>
              </div>
            </div>
            <div class="modal" id="registerModal">
              <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
            
                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Summary</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
            
                  <!-- Modal body -->
                  <div class="modal-body">
                    <img src="/INTIEventManagement/img/CounsellingAwarenessMonth2024.jpg" alt="eventImage" class="img-fluid rounded">
                    <h2>Counselling Awareness Month 2024</h2>
                    <form class="event-info pt-2">
                      <div class="pb-4">
                        <h3>Date and Time</h3>
                        <span>Mon, 2 Sep 2024 • 10.00 AM</span>
                      </div>
                      <div class="pb-4">
                        <h3>Location</h3>
                        <span>INTI International College Penang</span>
                      </div>
                      <div class="pb-4">
                        <h3>About this event</h3>
                        <span>INTI International College Penang</span>
                      </div>
                    </form>
                  </div>
            
                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-secondary">Register</button>
                  </div>
            
                </div>
              </div>
            </div>
          </div>
          <div class="col">
              <div>
                  <section>
                    <div class="card">
                      <a href="#">
                          <img src="/INTIEventManagement/img/Anti-DrugCampaign.jpg" alt="eventImage" class="card-img-top">
                      </a>
                      <section>
                        <div class="card-body">
                            <h5 class="card-title">Anti-Drug Campaign</h5>
                            <p class="card-text">
                              <small>Sun, 22 Oct 2024 • 12.00 PM<br>
                                <span class="text-muted">INTI International College Penang</span></small>
                            </p>
                            <span class="d-flex"><small class="material-symbols-outlined me-1">person</small>60 registered</span>
                        </div>
                      </section>
                    </div>
                  </section>
              </div>
          </div>
          <div class="col">
              <div>
                  <section>
                    <div class="card">
                      <a href="#">
                          <img src="/INTIEventManagement/img/Accounting&Finance.jpg" alt="eventImage" class="card-img-top">
                      </a>
                      <section>
                        <div class="card-body">
                            <h5 class="card-title">Accounting & Finance Week</h5>
                            <p class="card-text">
                              <small>Tue, 26 Oct 2024 • 12.00 PM<br>
                                <span class="text-muted">INTI International College Subang</span></small>
                            </p>
                            <span class="d-flex"><small class="material-symbols-outlined me-1">person</small>90 registered</span>
                        </div>
                      </section>
                    </div>
                  </section>
              </div>
          </div>
          <div class="col">
              <div>
                  <section>
                    <div class="card">
                      <a href="#">
                          <img src="/INTIEventManagement/img/InternationalCharityFoodFestival.jpg" alt="eventImage" class="card-img-top">
                      </a>
                      <section>
                        <div class="card-body">
                            <h5 class="card-title">International Charity</h5>
                            <p class="card-text">
                              <small>Sun, 3 Nov 2024 • 2.00 PM<br>
                                <span class="text-muted">INTI International College Penang</span></small>
                            </p>
                            <span class="d-flex"><small class="material-symbols-outlined me-1">person</small>60 registered</span>
                        </div>
                      </section>
                    </div>
                  </section>
              </div>
          </div>
          <div class="col">
              <div>
                  <section>
                    <div class="card">
                      <a href="#">
                          <img src="/INTIEventManagement/img/Anti-DrugCampaign.jpg" alt="eventImage" class="card-img-top">
                      </a>
                      <section>
                        <div class="card-body">
                            <h5 class="card-title">Anti-Drug Campaign</h5>
                            <p class="card-text">
                              <small>Sun, 22 Oct 2024 • 12.00 PM<br>
                                <span class="text-muted">INTI International College Penang</span></small>
                            </p>
                            <span class="d-flex"><small class="material-symbols-outlined me-1">person</small>60 registered</span>
                        </div>
                      </section>
                    </div>
                  </section>
              </div>
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
  loadNavbar('home');
</script>
