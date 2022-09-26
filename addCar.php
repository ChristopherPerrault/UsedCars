<?php
require_once('db.php');
//--------------------------------------
// !important work in progress - Chris
// -------------------------------------

//  initializing message variables to blank
$makeErr = $modelErr = $yrErr = $mileageErr = $colorErr = $carConditionErr = $askPriceErr = $imagesErr = "";
$make = $model = $yr = $mileage = $color = $carCondition = $askPrice
    // = $images   might not be needed here 
    = "";

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
        if (!preg_match("/^[a-zA-Z]*$/", $make)) {
            $makeErr = "&nbsp Only letters and white space allowed &nbsp";
        }
    }

    if (empty($_POST["model"])) {
        $modelErr = "&nbsp model is required &nbsp";
    } else {
        $modelErr = "";
        $model = test_input($_POST["model"]);
        if (!preg_match("/^[a-zA-Z]*$/", $model)) {
            $modelErr = "&nbsp Only letters and white space allowed &nbsp";
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
        $mileageErr = "&nbsp mileage is required &nbsp";
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
        if (!preg_match("/^[a-zA-Z]*$/", $color)) {
            $colorErr = "&nbsp Only letters and white space allowed &nbsp";
        }
    }

    if (empty($_POST["carCondition"])) {
        $carConditionErr = "&nbsp Condition is required &nbsp";
    } else {
        $carConditionErr = "";
        $carCondition = test_input($_POST["carCondition"]);
        if (!preg_match("/^[a-zA-Z]*$/", $carCondition)) {
            // $carConditionErr = "&nbsp Only letters and white space allowed &nbsp";
            //! needs to be option box
        }
    }

    if (empty($_POST["asking_price"])) {
        $askPriceErr = "&nbsp Asking price is required &nbsp";
    } else {
        $askPriceErr = "";
        $askPrice = test_input($_POST["asking_price"]);
        //! FIXME: needs to be int, no decimals unless change to float in db
        if (!preg_match("/^[a-zA-Z]*$/", $askPrice)) {
            $askPriceErr = "&nbsp Only digits allowed &nbsp";
        }
    }

    //! absolutely fix this, but remember it's an added feature
    if (empty($_POST["images"])) {
        $imagesErr = "&nbsp You must include at least 1 image &nbsp";
    } else {
        $imagesErr = "";
        $images = test_input($_POST["images"]);
        if (!preg_match("/^[a-zA-Z]*$/", $images)) {
            $imagesErr = "&nbsp Only letters and white space allowed &nbsp";
        }
    }
}


//? -----ADD RECORDS-----

if ((isset($_POST['make'])) &&
    isset($_POST['model']) &&
    isset($_POST['yr']) &&
    isset($_POST['mileage']) &&
    isset($_POST['mileageSelect']) &&
    isset($_POST['color']) &&
    isset($_POST['car_condition']) &&
    isset($_POST['asking_price'])
    //  &&
    // isset($_POST['date_posted']) &&
    // isset($_POST['images'])
) {

    //  ------ Form input for entry into db ------
    $make = $_POST["make"];
    $model = $_POST["model"];
    $year = $_POST["year"];
    //  if miles selected, converts miles to km and rounds up to nearest whole int
    if ($_POST["mileageSelect"]) {
        $mileage = ceil($_POST["mileage"] * 1.60934);
    };
    $color = $_POST["color"];
    $carCondition = $_POST["car_condition"];
    $askPrice = $_POST["asking_price"];
    $images = $_POST["images"];
    // $datePosted = $_POST["date_posted"];

    $addQuery = "INSERT INTO used_inventory(make, model, `year`, mileage, color, car_condition, asking_price, images) VALUES ('" . $make . "', '" . $model . "', '" . $year . "', '" . $mileage . "', '" . $color . "',  '" . $carCondition . "',  '" . $askPrice . "', '" . $images . "')";

    $flag = mysqli_query($conn, $addQuery);

    if ($flag) {
        echo "Car added";
    } else {
        die("Cannot add record" . mysqli_error($conn));
    }
} else {
    //! needs to be removed/fixed so it doesn't show
    echo "Form incomplete";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UsedCars | Add Car</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>

<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <label for="make">Car Make: </label>
            <input type="text" name="make" placeholder="Ex: Honda" value="<?= (isset($make)) ? $make : ''; ?>"><br>
            <span class="error"><?= $makeErr ?></span>
            <br>

            <label for="model">Car Model: </label>
            <input type="text" name="model" placeholder="Ex: Accord"
                value="<?= (isset($model)) ? $model : ''; ?>"><br><span class="error"><?= $modelErr ?></span>
            <br>

            <!-- changed from spans to p's for some reason, fix -->
            <label for="year">Year: </label>
            <input type="text" name="yr" placeholder="Ex: 1998" value="<?= (isset($year)) ? $year : ''; ?>"><br>
            <p class="error"><?= $yearErr ?></p>
            <br>

            <label for="mileage">Mileage: </label>
            <input type="text" name="mileage" placeholder="Ex: 210000"
                value="<?= (isset($mileage)) ? $mileage : ''; ?>">

            <label class="switch">
                <input type="checkbox" name="mileageSelect">
                <span class="slider round"></span>
            </label>

            <br><span class="error"><?= $mileageErr ?></span>
            <br>

            <label for="color">Color: </label>
            <input type="text" name="color" placeholder="Ex: Blue" value="<?= (isset($color)) ? $color : ''; ?>"><br>
            <p class="error"><?= $colorErr ?></p>
            <br>

            <label for="car_condition">Condition: </label>
            //!-------------------------------------
            <!-- gotta change this to option boxes -->
            <input type="text" name="car_condition" value="<?= (isset($carCondition)) ? $carCondition : ''; ?>"><br>
            <p class="error"><?= $carConditionErr ?></p>
            <br>

            <label for="asking_price">Asking Price: </label>
            <input type="text" name="asking_price" placeholder="2400"
                value="<?= (isset($askPrice)) ? $askPrice : ''; ?>"><br>
            <p class="error"><?= $askPriceErr ?></p>
            <br>

            //! also need fix here to accomodate uploads
            <label for="images">Upload Image(s): </label>
            <input type="text" name="images" value="<?= (isset($images)) ? $images : ''; ?>"><br>
            <p class="error"><?= $imagesErr ?></p>
            <br>


            <input type="submit" value="Confirm"><br>
            <input type="reset" value="Reset Form">

        </form>
    </div>
</body>

</html>