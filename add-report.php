<!-- Header -->
<?php
require('config/db.php');
require('config/auth.php');
include('templates/header-logged-in.php');
?>


<?php
$finalPrice = $finalPriceErr = $success = $failure = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //  all inputs passed through test_input() for security
  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
  }

  //  ------ Validation & Error Handling ------
  if (empty($_POST["final_price"])) {
    $finalPriceErr = "&nbsp Asking price is required &nbsp";
  } else {
    $finalPriceErr = "";
    $finalPrice = test_input($_POST["final_price"]);
    // regex: only positive ints up to 7 digits long, no decimals. HTML input also has min/max constraints
    if (!preg_match("/^[0-9]{1,7}$/", $finalPrice)) {
      $finalPriceErr = "&nbsp Only positive digits allowed (min 1 and max 7) &nbsp";
    }
  }

  //  ------ Creating New Contract ------

  if (
    isset($_POST['userID']) &&
    isset($_POST['carID']) &&
    empty($finalPriceErr)
  ) {
    $userID = $_POST['userID'];
    $carID = $_POST['carID'];
    $date = date("Y.m.d");
    $finalPrice = $_POST["final_price"];

    $validateQuery = "SELECT * FROM `cars` WHERE car_id = '" . $carID . "' and user_id = '" . $userID . "'";
    $check = mysqli_query($con, $validateQuery);
    $num_rows = mysqli_num_rows($check);

    if ($num_rows == 1) {
      $addQuery = "INSERT INTO `reports`(user_id, car_id, `date`, final_price) VALUES ('" . $userID . "', '" . $carID . "', '" . $date . "', '" . $finalPrice . "')";
      $flag = mysqli_query($con, $addQuery);

      if ($flag) {
        $success = '<span class="success">Contract has been successfully added</span>';
      } else {
        die("Cannot add contract" . mysqli_error($con));
      }
    } else {
      $failure = "Those User and Car IDs do not match!";
    }
  } else {
    $failure = "Error somewhere";
  }
}
?>


<div class="container mt-5">
<h1 class="text-center">Create Official Contract for Sold Car</h1>
  <form action="" method="post">
    <div class="form-group">
      <label for="userID" class="form-label">Select a User ID: </label>
      <select name="userID">
        <?php
        $view_userIds = "SELECT `user_id` FROM `users`";
        $allUserIds = mysqli_query($con, $view_userIds);
        while ($rows = mysqli_fetch_assoc($allUserIds)) {
        ?>
          <option value="<?php echo $rows['user_id']; ?>" selected><?php echo $rows['user_id']; ?></option>
        <?php }
        ?>
      </select>
      <label for="carID" class="form-label">Select a Car ID: </label>
      <select name="carID">
        <?php
        $view_carIds = "SELECT `car_id` FROM `cars`";
        $allCarIds = mysqli_query($con, $view_carIds);
        while ($rows = mysqli_fetch_assoc($allCarIds)) {
        ?>
          <option value="<?php echo $rows['car_id']; ?>" selected><?php echo $rows['car_id']; ?></option>
        <?php }
        ?>
      </select>
      <label for="final_price">Final Price</label>
      <input type="number" name="final_price">
      <?php echo $finalPriceErr; ?>

      <?php
      echo "<br><br><hr>";
      echo "$success";
      echo "$failure";
      ?>
    </div>

    <div class="form-group">
      <input type="submit" name="submit" class="btn btn-primary mt-2" value="Generate Report">
    </div>
  </form>
</div>



<!-- a BACK button to go to the home page -->
<div class="container text-center mt-5">
  <a href="view-report.php" class="btn btn-warning mt-5"> Back </a>
</div>



<!-- Footer -->
<?php include "templates/footer.php" ?>