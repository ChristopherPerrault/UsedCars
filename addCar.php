<?php
require_once('./config/db.php');
// include('./config/uploadImage.php');

//--------------------------------------
// !important - work in progress - Chris
// -------------------------------------

//  initializing message variables to blank
$makeErr = $modelErr = $yearErr = $mileageErr = $colorErr = $carConditionErr = $askPriceErr = $imagesErr = "";
$make = $model = $year = $mileage = $color = $carCondition = $askPrice = $images = "";

//  all inputs passed through test_input for security
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
    //  just in case check, but not necessary as this is a select/optgroup
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

    // absolutely fix this, but remember it's an added feature
    // if (empty($_POST["images"])) {
    //     $imagesErr = "&nbsp You must include at least 1 image &nbsp";
    // } else {
    //     $imagesErr = "";
    //     $images = test_input($_POST["images"]);
    //     if (!preg_match("/^[a-zA-Z]*$/", $images)) {
    //         $imagesErr = "&nbsp Only letters and white space allowed &nbsp";
    //     }
    // }
}


//  ------ Adding a new Car to the db ------

if ((isset($_POST['make'])) &&
    isset($_POST['model']) &&
    isset($_POST['year']) &&
    isset($_POST['mileage']) &&
    isset($_POST['color']) &&
    isset($_POST['car_condition']) &&
    isset($_POST['asking_price'])
    // &&
    // isset($_POST['images'])

) {

    //  ------ Form input into variables for entry into db ------
    $make = $_POST["make"];
    $model = $_POST["model"];
    $year = $_POST["year"];
    //  if miles selected, converts miles to km and rounds up to nearest whole int
    if (isset($_POST["mileageSelect"])) {
        $mileage = ceil($_POST["mileage"] * 1.60934);
    } else {
        $mileage = $_POST["mileage"];
    }
    $color = $_POST["color"];
    $carCondition = $_POST["car_condition"];
    $askPrice = $_POST["asking_price"];
    $datePosted = date("Y.m.d");
    // $images = $_POST["images"];

    $addQuery = "INSERT INTO `cars`(make, model, `year`, mileage, color, car_condition, asking_price, date_posted) VALUES ('" . $make . "', '" . $model . "', '" . $year . "', '" . $mileage . "', '" . $color . "',  '" . $carCondition . "',  '" . $askPrice . "',  '" . $datePosted . "')";

    $flag = mysqli_query($con, $addQuery);

    if ($flag) {
        echo '<span class="success">Car has been successfully added</span>';
    } else {
        die("Cannot add record" . mysqli_error($con));
    }
} else {
    //! needs to be removed/fixed so it doesn't show
    echo '<span class="error">Form Incomplete</span>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UsedCars | Add Car</title>
    <link rel="stylesheet" href="./css/style.css">
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


            <!-- changed from spans to p's for some reason, fix -->
            <label for="year">Year: </label>
            <input type="text" name="year" placeholder="Ex: 1998" value="<?= (isset($year)) ? $year : ''; ?>"><br>
            <span class="error"><?= $yearErr ?></span>


            <label for="mileage">Mileage: </label>
            <input type="text" name="mileage" placeholder="Ex: 210000"
                value="<?= (isset($mileage)) ? $mileage : ''; ?>">

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
            <!-- bottom buttons -->
            <input type="submit" value="Confirm"><br>
            <input type="reset" value="Reset Form">
            <a href="index.php"><input type="submit" value="Go Back"></a>

        </form>
    </div>
</body>

</html>