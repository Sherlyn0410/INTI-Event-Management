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

$isEdit = false;
if (isset($_GET['id'])) {
    $isEdit = true;
    $event->id = $_GET['id'];
    $event->readOne();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Set event property values
    $event->name = $_POST['name'];
    $event->description = $_POST['description'];
    $event->startdatetime = $_POST['startdate'] . ' ' . $_POST['starttime'];
    $event->endtime = $_POST['startdate'] . ' ' . $_POST['endtime'];
    $event->campus_id = $_POST['campus_id'];
    $event->capacity = $_POST['capacity'];
    $event->status = "Published";
    $event->user_id = $_SESSION['user_id'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $originalImageName = $_FILES['image']['name'];
        $tmp = explode('.', $originalImageName);
        $newFileName = round(microtime(true)) . '.' . end($tmp);
        $uploadPath = 'img/' . $newFileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            $event->image = $newFileName;
        } else {
            $event->image = null; // Handle the case where the image upload fails
        }
    }

    // Create or update the event
    if ($isEdit) {
        if ($event->update()) {
            echo "<script>
                alert('Event was successfully updated. The changes will notify the registrants.');
                window.location.href = 'manageEvent.php';
            </script>";
        } else {
            echo "<script>
                alert('Unable to update event.');
                window.history.back();
            </script>";
        }
    } else {
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
  <?php include 'session_script.php'; ?>
  <div id="navbar-placeholder"></div>
  <div class="main-wrapper">
    <div class="wrapper-padding">
      <h3><?php echo $isEdit ? 'Edit' : 'Create'; ?> Event</h3>
      <p>Want to host your own event? Easily create an event by filling out the form below.</p>
      <form class="create-event-form pt-4" id="createEventForm" action="createEvent.php<?php echo $isEdit ? '?id=' . $event->id : ''; ?>" method="post" enctype="multipart/form-data">
        <div class="pb-4">
          <label for="name">What's the name of your event?</label>
          <input type="text" name="name" class="mb-1 form-control" placeholder="Event Title" value="<?php echo $isEdit ? htmlspecialchars($event->name) : ''; ?>" required>
          <textarea type="text" name="description" class="form-control" placeholder="Event Description" required><?php echo $isEdit ? htmlspecialchars($event->description) : ''; ?></textarea>
        </div>
        <div class="pb-4">
          <label for="startdatetime">When does your event start and end?</label>
          <div class="d-md-flex gap-2">
            <input class="mb-1 mb-md-0 form-control" type="date" name="startdate" id="startdate" value="<?php echo $isEdit ? date('Y-m-d', strtotime($event->startdatetime)) : ''; ?>" required>
            <div class="d-flex gap-2 w-100">
              <input type="time" class="form-control" name="starttime" value="<?php echo $isEdit ? date('H:i', strtotime($event->startdatetime)) : ''; ?>" required>
              <input type="time" class="form-control" name="endtime" value="<?php echo $isEdit ? date('H:i', strtotime($event->endtime)) : ''; ?>" required>
            </div>
          </div>
        </div>
        <div class="pb-4">
          <label for="campus">Where is it located?</label>
          <select id="campus" name="campus_id" class="form-select" required>
              <option value="" disabled>Select campus</option>
              <option value="1" <?php echo $isEdit && $event->campus_id == 1 ? 'selected' : ''; ?>>INTI International University</option>
              <option value="2" <?php echo $isEdit && $event->campus_id == 2 ? 'selected' : ''; ?>>INTI International College Subang</option>
              <option value="3" <?php echo $isEdit && $event->campus_id == 3 ? 'selected' : ''; ?>>INTI International College Penang</option>
              <option value="4" <?php echo $isEdit && $event->campus_id == 4 ? 'selected' : ''; ?>>INTI International College Sabah</option>
          </select>
        </div>
        <div class="pb-4">
          <label for="capacity">What's the capacity for your event?</label>
          <div>Event capacity refers to the maximum number of registrants allowed.</div>
          <input class="mt-2 form-control" type="number" name="capacity" min="10" placeholder="Capacity" value="<?php echo $isEdit ? htmlspecialchars($event->capacity) : ''; ?>" required>
        </div>
        <div class="pb-4">
          <label for="image">Upload Event Image</label><br>
          <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png" <?php echo $isEdit ? '' : 'required'; ?>>
          <?php if ($isEdit && $event->image): ?>
            <div class="mt-2">
              <img src="img/<?php echo htmlspecialchars($event->image); ?>" alt="Event Image" class="img-fluid rounded" style="max-width: 200px;">
            </div>
          <?php endif; ?>
        </div>
        <div class="pt-4 gap-md-3 d-md-flex justify-content-md-end">
          <input class="col-12 col-md-2 mb-1 mb-md-0 btn btn-md btn-light border" type="button" value="Exit" id="exitButton">
          <input class="col-12 col-md-2 btn btn-md btn-secondary" type="submit" value="<?php echo $isEdit ? 'Update Event' : 'Create Event'; ?>">
        </div>  
      </form>
    </div>
  </div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="javascript.js"></script>
<script>
  loadNavbar('<?php echo $isEdit ? 'edit' : 'create'; ?>');
</script>