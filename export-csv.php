<?php
require('config/db.php');
require('config/auth.php');

$query = "SELECT reports.contract_id, reports.date, users.username, users.phone_number, users.email, cars.make, cars.mileage, cars.date_posted, cars.asking_price, reports.final_price
                FROM (
                (reports
                INNER JOIN users ON reports.user_id = users.user_id)
                INNER JOIN cars ON reports.car_id = cars.car_id);";
$result = mysqli_query($con, $query);

// function to store number of fields from SELECT query (10 in this case)
$number_of_fields = mysqli_num_fields($result);

// set the first line of CSV file with field headers
$headers = array();
for ($i = 0; $i < $number_of_fields; $i++) {

    //call to the custom function (line 44)
    $headers[] = mysqli_field_name($result, $i);
}

// setting first parameter to a URL instead of localfile
$url_handle = fopen('php://output', 'w');

// if stream to url AND database query both succeed
if ($url_handle && $result) {
    // create and define file type
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="contract_sales_reports.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // set the header of the file
    fputcsv($url_handle, $headers);

    // populate the rest of the rows 
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        fputcsv($url_handle, array_values($row));
    }
    die;
}

function mysqli_field_name($result, $index)
{
    // store the field name into fetched_name using the for loop index of line 20
    $fetched_name = mysqli_fetch_field_direct($result, $index);

    // if $fetched_name exists -> return the name and set in headers [] array
    return is_object($fetched_name) ? $fetched_name -> name : null;
}
