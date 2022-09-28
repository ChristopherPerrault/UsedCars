<?php
// require_once('./config/db.php');
// include('./config/uploadImage.php');
// include('./config/auth.php');
include('./templates/header-logged-in.php');


//--------------------------------------
// !important - work in progress - Chris
// -------------------------------------

//  initializing error message variables and form entries to empty strings
$makeErr = $modelErr = $yearErr = $mileageErr = $colorErr = $carConditionErr = $askPriceErr = "";
$make = $model = $year = $mileage = $color = $carCondition = $askPrice  = "";

//  all inputs passed through test_input() for security
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

//  ------ Validation & Error Handling ------

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["make"])) {
        $makeErr = "&nbsp Make is required &nbsp";
    } else {
        $makeErr = "";
        $make = test_input($_POST["make"]);
        //  regex: letters, dashes and spaces allowed, not numbers
        if (!preg_match("/^[a-zA-Z -]*$/", $make)) {
            $makeErr = "&nbsp Only letters, dashes and spaces allowed &nbsp";
        }
    }

    if (empty($_POST["model"])) {
        $modelErr = "&nbsp Model is required &nbsp";
    } else {
        $modelErr = "";
        $model = test_input($_POST["model"]);
        //  regex: alphanumeric, plus sign, spaces and dashes accepted 
        if (!preg_match("/^[a-zA-Z0-9 +-]*$/", $model)) {
            $modelErr = "&nbsp Only letters, numbers, spaces, '+', '-' allowed &nbsp";
        }
    }

    if (empty($_POST["year"])) {
        $yearErr = "&nbsp Year is required &nbsp";
    } else {
        $yearErr = "";
        $year = test_input($_POST["year"]);
        //  checks for years between 1930 & current year, also whether input is numeric
        if ($year < 1930 || $year > date("Y") || !is_numeric($year)) {
            $yearErr = "&nbsp Invalid year &nbsp";
        }
    };


    if (empty($_POST["mileage"])) {
        $mileageErr = "&nbsp Mileage is required &nbsp";
    } else {
        $mileageErr = "";
        $mileage = test_input($_POST["mileage"]);
        //  regex: only digits, min 1, max 6 as per db constraint
        if (!preg_match("/^[0-9]{1,6}$/", $mileage)) {
            $mileageErr = "&nbsp Please enter only digits &nbsp";
        }
    }

    if (empty($_POST["color"])) {
        $colorErr = "&nbsp Color is required &nbsp";
    } else {
        $colorErr = "";
        $color = test_input($_POST["color"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $color)) {
            $colorErr = "&nbsp Only letters and spaces allowed &nbsp";
        }
    }
    //  just-in-case check, but not necessary as this is a select/optgroup
    if (!empty($_POST["car_condition"])) {
        $carCondition = test_input($_POST["car_condition"]);
    }


    if (empty($_POST["asking_price"])) {
        $askPriceErr = "&nbsp Asking price is required &nbsp";
    } else {
        $askPriceErr = "";
        $askPrice = test_input($_POST["asking_price"]);
        // regex: only positive ints up to 7 digits long, no decimals. HTML input also has min/max constraints
        if (!preg_match("/^[0-9]{1,7}$/", $askPrice)) {
            $askPriceErr = "&nbsp Only digits allowed &nbsp";
        }
    }


    //  ------ Adding a new Car to the db ------

    if (
        empty($makeErr) &&
        empty($modelErr) &&
        empty($yearErr) &&
        empty($mileageErr) &&
        empty($colorErr) &&
        empty($$askPriceErr)
    ) {

        //  ------ Form input into variables for entry into db ------

        //  make, model, color are all converted to lowercase then thier first chars are capitalized, even if words are separated by space(s), new lines, tabs, dashes, return carriages or apostrophes (delimiters provided in arguments of ucwords()). Numbers unaffected/stay intact.

        $make = $_POST["make"];
        $make = ucwords(strtolower($make), " \t\r\n'-");

        $model = $_POST["model"];
        $model = ucwords(strtolower($model), " \t\r\n'-");

        $year = $_POST["year"];

        //  if toggled to miles, converts miles to km and rounds up to nearest whole integer
        if (isset($_POST["mileageSelect"])) {
            $mileage = ceil($_POST["mileage"] * 1.60934);
        } else {
            $mileage = $_POST["mileage"];
        }

        $color = $_POST["color"];
        $color = ucwords(strtolower($color), " \t\r\n'-");

        $carCondition = $_POST["car_condition"];

        $askPrice = $_POST["asking_price"];
        //  matches mySQL date format, adds the current actual date
        $datePosted = date("Y.m.d");

        $user_id = $_SESSION['user_id'];

        $addQuery = "INSERT INTO `cars`(user_id, make, model, `year`, mileage, color, car_condition, asking_price, date_posted) VALUES ('" . $user_id . "', '" . $make . "', '" . $model . "', '" . $year . "', '" . $mileage . "', '" . $color . "',  '" . $carCondition . "',  '" . $askPrice . "',  '" . $datePosted . "')";

        $flag = mysqli_query($con, $addQuery);

        if ($flag) {
            echo '<span class="success">Car has been successfully added</span>';
        } else {
            die("Cannot add record" . mysqli_error($con));
        }
    } else {
        //! needs to be fixed so it doesn't show as it does in top right corner
        echo '<span class="error">Form Incomplete</span>';
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UsedCars | Add Car</title>
</head>

<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

            <label for="make">Car Make: </label>
            <input type="text" name="make" placeholder="Ex: Honda" value="<?= (isset($make)) ? $make : ''; ?>"><br>
            <span class="error"><?= $makeErr ?></span>


            <label for="model">Car Model: </label>
            <input type="text" name="model" placeholder="Ex: Accord"
                value="<?= (isset($model)) ? $model : ''; ?>"><br><span class="error"><?= $modelErr ?></span>


            <label for="year">Year: </label>
            <input type="text" name="year" placeholder="Ex: 1998" value="<?= (isset($year)) ? $year : ''; ?>"><br>
            <span class="error"><?= $yearErr ?></span>


            <label for="mileage">Mileage: </label>
            <input type="text" name="mileage" placeholder="Ex: 210000"
                value="<?= (isset($mileage)) ? $mileage : ''; ?>">

            <!-- Mileage selector toggle: km/mi, km by default -->
            <label class="switch">
                <input type="checkbox" name="mileageSelect">
                <span class="slider round"></span>
            </label>

            <br><span class="error"><?= $mileageErr ?></span>


            <label for="color">Color: </label>
            <input type="text" name="color" placeholder="Ex: Blue" value="<?= (isset($color)) ? $color : ''; ?>"><br>
            <span class="error"><?= $colorErr ?></span>


            <label for="car_condition">Condition:</label>
            <select name="car_condition" value="<?= (isset($carCondition)) ? $carCondition : ''; ?>">
                <optgroup label="--Select Condition--">
                    <option value="Like New">Like New</option>
                    <option value="Very Good">Very Good</option>
                    <option value="Good">Good</option>
                    <option value="Fair">Fair</option>
                    <option value="Poor">Poor</option>
                    <option value="Very Poor">Very Poor</option>
                </optgroup>
            </select>
            <span class="error"><?= $carConditionErr ?></span>
            <br>

            <label for="asking_price">Asking Price: </label>
            <input type="text" name="asking_price" placeholder="Ex: 2400"
                value="<?= (isset($askPrice)) ? $askPrice : ''; ?>" min="1" max="9999999"><br>
            <span class="error"><?= $askPriceErr ?></span>


            <!-- <label>Select Image File:</label>
            <input type="file" name="image">
            <input type="submit" name="submitImage" value="Upload" formaction="./config/uploadImage.php"> -->

            <br>
            <!-- bottom-of-form buttons -->
            <input type="submit" value="Confirm" class="bottom-btn confirm"><br>
            <input type="reset" value="Reset Form" class="bottom-btn reset">

            <a href="userdashboard.php"><input type="submit" value="Go Back" class="bottom-btn back"></a>

        </form>
    </div>
</body>
<?php
include('./templates/footer.php');
?>

</html>