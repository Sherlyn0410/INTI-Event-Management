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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTI Event Management</title>
</head>
<body>
  <script>
    // Pass the PHP session variable to JavaScript
    const userName = '<?php echo isset($_SESSION["name"]) ? $_SESSION["name"] : ""; ?>';
  </script>
  <div id="navbar-placeholder"></div>
  <div class="main-wrapper">
    <div class="wrapper-padding">
      <div class="d-flex flex-column flex-md-row">
        <input class="me-md-2 mb-2 mb-md-0 form-control" type="search" placeholder="Search events you are interested here..." aria-label="Search">
        <select name="Select Campus" class="form-select me-md-2 mb-2 mb-md-0">
          <option value="1">INTI International University</option>
          <option value="2">INTI International College Subang</option>
          <option value="3">INTI International College Penang</option>
          <option value="4">INTI International College Sabah</option>
          <option value="0">All Campuses</option>
        </select>
        <button class="btn btn-secondary btn-radius" type="submit">Search</button>
      </div>
      <div class="container-fluid pt-4">
        <h3>Events</h3>
        <div class="row row-cols-1 row-cols-md-4 g-4">
          <div class="col">
            <div>
              <section>
                <div class="card">
                  <a href="#">
                      <img src="/INTIEventManagement/img/CounsellingAwarenessMonth2024.jpg" alt="eventImage" class="card-img-top">
                  </a>
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
  loadNavbar('browse');
</script>