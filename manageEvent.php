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
        <h3>Events</h3>
        <div class="row justify-content-between mb-3">
          <div class="col-6 d-flex">
            <input class="form-control me-md-2" type="search" placeholder="Search events here..." aria-label="Search">
          </div>
            <div class="col-2 text-end">
                <a class="btn btn-secondary btn-create" href="createEvent.html">Create Event</a>
            </div>
        </div>
        <div>
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
                  <tr class="p-2">
                    <th scope="row" class="text-uppercase">sep<br>8</th>
                    <td class="col-3"><img src="/INTIEventManagement/img/CounsellingAwarenessMonth2024.jpg" class="img-fluid rounded" alt="EventImage"></td>
                    <td>
                        <strong>Changing The Narrative On Suicide</strong><br>
                        <div><small class="text-muted">INTI International College Penang</small></div>
                        <div><small class="text-muted">Sunday, September 8, 2024 at 2.00 PM</small></div>
                    </td>           
                    <td>56/100</td>
                    <td class="text-success">Published</td>
                    <td>
                        <span role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-symbols-outlined">more_vert</i></span>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Edit event</a></li>
                        <li><a class="dropdown-item" href="#">Export CSV</a></li>
                        <li><a class="dropdown-item" href="#">Delete</a></li>
                        </ul>
                    </td>
                  </tr>
                  <tr>
                      <th scope="row" class="text-uppercase">oct<br>15</th>
                      <td><img src="" alt="EventImage"></td>
                    <td>
                        <strong>Changing The Narrative On Suicide</strong><br>
                        <p class="card-text">INTI International College Penang</p>
                        <p>Sunday, September 8, 2024 at 2.00 PM</p>
                    </td>           
                    <td>56/100</td>
                    <td class="text-danger">Cancelled</td>
                    <td>
                        <span role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-symbols-outlined">more_vert</i></span>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Edit event</a></li>
                        <li><a class="dropdown-item" href="#">Export CSV</a></li>
                        <li><a class="dropdown-item" href="#">Delete</a></li>
                        </ul>
                    </td>
                  </tr>
                </tbody>
            </table>
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