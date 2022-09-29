<?php
require('config/db.php');
require('config/auth.php');

$query = "SELECT reports.contract_id, reports.date, users.username, users.phone_number, users.email, cars.make, cars.mileage, cars.date_posted, cars.asking_price, reports.final_price
                FROM (
                (reports
                INNER JOIN users ON reports.user_id = users.user_id)
                INNER JOIN cars ON reports.car_id = cars.car_id);";
$result = mysqli_query($con, $query);

$number_of_fields = mysqli_num_fields($result);
$headers = array();
for ($i = 0; $i < $number_of_fields; $i++) {
    $headers[] = mysqli_field_name($result, $i);
}
$fp = fopen('php://output', 'w');
if ($fp && $result) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="export.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    fputcsv($fp, $headers);
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        fputcsv($fp, array_values($row));
    }
    die;
}

function mysqli_field_name($result, $field_offset)
{
    $properties = mysqli_fetch_field_direct($result, $field_offset);
    return is_object($properties) ? $properties->name : null;
}
