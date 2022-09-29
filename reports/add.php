<!-- Header -->
<?php
require('../config/db.php');
require('../config/auth.php');
include('./../templates/header-reports.php');
?>

<h1 class="text-center">Create a Report</h1>
<div class="container">
  <form action="" method="post">
    <div class="form-group">
      <label for="selectedUser" class="form-label">Select a User: </label>
      <select name="selectedUser">
        <?php
        $user_id = $_SESSION['user_id'];
        $view_usernames = "SELECT * FROM `users`";
        $allUsers = mysqli_query($con, $view_usernames);
        #$count = mysqli_num_rows($allUsers);


        while ($rows = mysqli_fetch_assoc($allUsers)) {
        ?>
          <option value="<?php echo $rows['username']; ?>" selected><?php echo $rows['username']; ?></option>
        <?php }
        ?>
      </select>
      <br><br>
      <h4>Info to include from the User</h4>
      <input type="checkbox" name="first_name" value="first_name">
      <label for="first_name"> First Name</label>
      <input type="checkbox" name="last_name" value="last_name">
      <label for="last_name"> Last Name</label>
      <input type="checkbox" name="phone_number" value="phone_number">
      <label for="phone_number"> Phone Number</label>
      <input type="checkbox" name="email" value="email">
      <label for="email"> Email</label>
      <br><br>
      <h4>Info to include from the Cars they have Listed</h4>
      <input type="checkbox" name="make" value="make">
      <label for="make"> Make</label>
      <input type="checkbox" name="model" value="model">
      <label for="model"> Model</label>
      <input type="checkbox" name="year" value="year">
      <label for="year"> Year</label>
      <input type="checkbox" name="color" value="color">
      <label for="color"> Color</label>
      <input type="checkbox" name="car_condition" value="car_condition">
      <label for="car_condition"> Car Condition</label>
      <input type="checkbox" name="asking_price" value="asking_price">
      <label for="asking_price"> Asking Price</label>
      <input type="checkbox" name="date_posted" value="date_posted">
      <label for="date_posted"> Date Posted</label>
      <br><br>
    </div>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $chosenUsername = $_POST['selectedUser'];
      echo "<h5>$chosenUsername</h5><hr>";
      $requestedData = "SELECT * FROM `users` WHERE username = '" . $chosenUsername . "'";
      $finalResult = mysqli_query($con, $requestedData);
      $chosenUser_id = "";
      while ($userInfo = mysqli_fetch_assoc($finalResult)) {
        if (isset($_POST['first_name'])) {
          echo $userInfo['first_name'];
        }
        if (isset($_POST['last_name'])) {
          echo $userInfo['last_name'];
        }
        if (isset($_POST['phone_number'])) {
          echo $userInfo['phone_number'];
        }
        if (isset($_POST['email'])) {
          echo $userInfo['email'];
        }

        $chosenUser_id = $userInfo['user_id'];
      }

      echo "<br><br><br>";
      $requestedData = "SELECT * FROM `cars` WHERE user_id = '" . $chosenUser_id . "'";
      $finalResult2 = mysqli_query($con, $requestedData);

      while ($carInfo = mysqli_fetch_assoc($finalResult2)) {
        if (isset($_POST['make'])) {
          echo $carInfo['make'];
        }
        if (isset($_POST['model'])) {
          echo $carInfo['model'];
        }
        if (isset($_POST['year'])) {
          echo $carInfo['year'];
        }
        if (isset($_POST['color'])) {
          echo $carInfo['color'];
        }
        if (isset($_POST['car_condition'])) {
          echo $carInfo['car_condition'];
        }
        if (isset($_POST['asking_price'])) {
          echo $carInfo['asking_price'];
        }
        if (isset($_POST['date_posted'])) {
          echo $carInfo['date_posted'];
        }
      }
    }
    ?>

    <div class="form-group">
      <input type="submit" name="submit" class="btn btn-primary mt-2" value="Generate Report">
    </div>
  </form>
</div>


<!-- a BACK button to go to the home page -->
<div class="container text-center mt-5">
  <a href="home.php" class="btn btn-warning mt-5"> Back </a>
</div>



<!-- Footer -->
<?php include "../templates/footer.php" ?>