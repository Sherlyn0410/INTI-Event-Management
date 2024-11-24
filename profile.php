<?php
include 'checkLogin.php';
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

$user_id = $_SESSION['user_id'];
$user_profile = $database->getUserProfile($user_id);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profilePic'])) {
    $image = $_FILES['profilePic']['name'];
    $tmp = explode('.', $image);
    $newFileName = round(microtime(true)) . '.' . end($tmp);
    $uploadPath = 'img/' . $newFileName;
    if (move_uploaded_file($_FILES['profilePic']['tmp_name'], $uploadPath)) {
        // Update user profile image in the database
        $database->updateUserProfileImage($user_id, $newFileName);
        // Refresh the user profile data
        $user_profile = $database->getUserProfile($user_id);
        echo "<script>alert('Profile image updated successfully.');</script>";
    } else {
        echo "<script>alert('Unable to upload image.');</script>";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTI Event Management</title>
</head>
<body>
  <?php include 'session_script.php'; ?>
  <div id="navbar-placeholder"></div>
  <div class="main-wrapper">
      <div class="wrapper-padding">
          <h3>Profile Settings</h3>
          <div class="row align-items-center">
            <div class="col-12 col-md-4 text-center d-flex justify-content-center position-relative">
              <div>
                <?php
                $profileImage = !empty($user_profile['profilePic']) ? htmlspecialchars($user_profile['profilePic']) : 'default-profile.jpg';
                ?>
                <img class="profile-pic mb-3" src="img/<?php echo $profileImage; ?>" alt="profilePic">
                <form action="profile.php" method="post" enctype="multipart/form-data">
                  <div class="input-group text-center">
                    <input type="file" class="form-control d-none" id="profilePic" name="profilePic" accept=".jpg, .jpeg, .png" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                    <button class="btn btn-light border position-absolute bottom-0 end-0 rounded d-flex" type="button" id="editButton"><i class="material-symbols-outlined">edit</i>Edit</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-12 col-md-8 profile-form">
                <form>
                    <div class="pb-2 pb-md-3">
                        <label for="user_id">Student ID</label>
                        <input class="form-control text-capitalize" type="text" value="<?php echo htmlspecialchars($user_profile['id']); ?>" readonly>
                    </div>
                    <div class="pb-2 pb-md-3">
                        <label for="name">Name</label>
                        <input type="text" class="text-uppercase form-control" value="<?php echo htmlspecialchars($user_profile['name']); ?>" readonly>
                    </div>
                    <div class="pb-2 pb-md-3">
                        <label for="email">Email</label>
                        <input class="form-control" type="text" value="<?php echo htmlspecialchars($user_profile['email']); ?>" readonly>
                    </div>
                    <div class="pb-2 pb-md-3">
                        <label for="phoneNo">Phone No.</label>
                        <input class="form-control" type="text" value="+60 <?php echo htmlspecialchars($user_profile['phoneNo']); ?>" readonly>
                    </div>
                    <div class="pb-2 pb-md-3">
                        <label for="campus">Campus</label>
                        <input class="form-control" type="text" value="<?php echo htmlspecialchars($user_profile['campus_name']); ?>" readonly>
                    </div>
                </form>
            </div>
          </div>
          
      </div>
  </div>
    
    
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="javascript.js"></script>
<script>
  loadNavbar('profile');

  document.getElementById('editButton').addEventListener('click', function() {
    document.getElementById('profilePic').click();
  });

  document.getElementById('profilePic').addEventListener('change', function() {
    this.form.submit();
  });
</script>