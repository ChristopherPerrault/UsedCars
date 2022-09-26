<?php
require_once('./config/db.php');
include('./config/uploadImage.php');

//--------------------------------------
// !important - work in progress - Chris
// -------------------------------------

//  initializing message variables to blank
$makeErr = $modelErr = $yearErr = $mileageErr = $colorErr = $carConditionErr = $askPriceErr = $imagesErr = "";
$make = $model = $year = $mileage = $color = $carCondition = $askPrice
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
        $modelErr = "&nbsp Model is required &nbsp";
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
        if (!preg_match("/^[a-zA-Z]*$/", $color)) {
            $colorErr = "&nbsp Only letters and white space allowed &nbsp";
        }
    }

    if (empty($_POST["car_condition"])) {
        $carConditionErr = "&nbsp Condition is required &nbsp";
    } else {
        $carConditionErr = "";
        $carCondition = test_input($_POST["car_condition"]);
        if (!preg_match("/^[a-zA-Z]*$/", $carCondition)) {
            $carConditionErr = "&nbsp Select a condition &nbsp";
        }
    }

    if (empty($_POST["asking_price"])) {
        $askPriceErr = "&nbsp Asking price is required &nbsp";
    } else {
        $askPriceErr = "";
        $askPrice = test_input($_POST["asking_price"]);
        // regex: only positive ints up to 7 didgits long, no decimals. HTML input also has constraints
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


//? -----ADD RECORDS-----

if ((isset($_POST['make'])) &&
    isset($_POST['model']) &&
    isset($_POST['yr']) &&
    isset($_POST['mileage']) &&
    isset($_POST['mileageSelect']) &&
    isset($_POST['color']) &&
    isset($_POST['car_condition']) &&
    isset($_POST['asking_price'])
    &&
    // isset($_POST['date_posted']) &&
    isset($_POST['images'])

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

    $addQuery = "INSERT INTO 'cars'(make, model, `year`, mileage, color, car_condition, asking_price, images) VALUES ('" . $make . "', '" . $model . "', '" . $year . "', '" . $mileage . "', '" . $color . "',  '" . $carCondition . "',  '" . $askPrice . "', '" . $images . "')";

    $flag = mysqli_query($con, $addQuery);

    if ($flag) {
        echo "Car added";
    } else {
        die("Cannot add record" . mysqli_error($con));
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
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

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
            <input type="text" name="year" placeholder="Ex: 1998" value="<?= (isset($year)) ? $year : ''; ?>"><br>
            <span class="error"><?= $yearErr ?></span>
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
            <span class="error"><?= $colorErr ?></span>
            <br>

            <label for="car_condition">Condition:</label>
            <select name="car_condition" value="<?= (isset($carCondition)) ? $carCondition : ''; ?>">
                <!-- broken -->
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
            <br>

            <label>Select Image File:</label>
            <input type="file" name="image">
            <input type="submit" name="submitImage" value="Upload" formaction="./config/uploadImage.php">

            <br>
            <!-- bottom buttons -->
            <input type="submit" value="Confirm"><br>
            <input type="reset" value=Reset Form>
            <a href="index.php"><input type="submit" value="Back"></a>

        </form>
    </div>
</body>

</html>