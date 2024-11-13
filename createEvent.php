<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// get database connection
include_once 'config/database.php';

// instantiate event object
include_once 'objects/event.php';

$database = new Database();
$db = $database->getConnection();

$event = new Event($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Set event property values
    $event->name = $_POST['name'];
    $event->image = $_FILES['image']['name'];
    $event->description = $_POST['description'];
    $event->startdatetime = $_POST['startdate'] . ' ' . $_POST['starttime'];
    $event->endtime = $_POST['startdate'] . ' ' . $_POST['endtime'];
    $event->campus_id = $_POST['campus_id'];
    $event->capacity = $_POST['capacity'];
    $event->status = "Published";
    $event->user_id = $_SESSION['user_id'];

    // Create the event
    if ($event->create()) {
        echo "<script>
            alert('Event was successfully created.');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Unable to create event.');
            window.history.back();
        </script>";
    }
}
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
  <script>
    // Pass the PHP session variable to JavaScript
    const userName = '<?php echo isset($_SESSION["name"]) ? $_SESSION["name"] : ""; ?>';
  </script>
  <div id="navbar-placeholder"></div>
  <div class="main-wrapper">
    <div class="wrapper-padding">
      <h3>Create an event</h3>
      <p>Want to host your own event? Easily create a new event by filling out the form below.</p>
      <form class="create-event-form pt-4" id="createEventForm" action="createEvent.php" method="post" enctype="multipart/form-data">
        <div class="pb-4">
          <label for="name">What's the name of your event?</label>
          <input type="text" name="name" class="mb-1 form-control" placeholder="Event Title" required>
          <textarea type="text" name="description" class="form-control" placeholder="Event Description" required></textarea>
        </div>
        <div class="pb-4">
          <label for="startdatetime">When does your event start and end?</label>
          <div class="d-md-flex gap-2">
            <input class="mb-1 mb-md-0 form-control" type="date" name="startdate" id="startdate" required>
            <div class="d-flex gap-2 w-100">
              <input type="time" class="form-control" name="starttime" required>
              <input type="time" class="form-control" name="endtime" required>
            </div>
          </div>
        </div>
        <div class="pb-4">
          <label for="campus">Where is it located?</label>
          <select id="campus" name="campus_id" class="form-select" required>
              <option value="" disabled selected>Select campus</option>
              <option value="1">INTI International University</option>
              <option value="2">INTI International College Subang</option>
              <option value="3">INTI International College Penang</option>
              <option value="4">INTI International College Sabah</option>
          </select>
        </div>
        <div class="pb-4">
          <label for="capacity">What's the capacity for your event?</label>
          <div>Event capacity refers to the maximum number of registrants allowed.</div>
          <input class="mt-2 form-control" type="number" name="capacity" min="10" placeholder="Capacity" required>
        </div>
        <div class="pb-4">
          <label for="image">Upload Event Image</label><br>
          <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png" required>
        </div>
        <div class="pt-4 gap-md-3 d-md-flex justify-content-md-end">
          <input class="col-12 col-md-2 mb-1 mb-md-0 btn btn-md btn-light border" type="button" value="Exit" id="exitButton">
          <input class="col-12 col-md-2 btn btn-md btn-secondary" type="submit" value="Create event">
        </div>  
      </form>
    </div>
  </div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="javascript.js"></script>
<script>
  loadNavbar('create');
</script>