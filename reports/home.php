<!-- Header -->
<?php
require('../config/db.php');
require('../config/auth.php');
include('../templates/header-reports.php');
?>


<div class="container">
    <h1 class="text-center">Current Reports</h1><br>
    <a href="add.php" class='btn btn-outline-dark mb-2'> <i class="bi bi-person-plus"></i> Generate New Report</a>

    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">Contract ID</th>
                <th scope="col">User ID</th>
                <th scope="col">Car ID</th>
                <th scope="col">Date</th>
                <th scope="col">Final Price</th>
                <th scope="col" colspan="2" class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            <tr>

                <?php
                $query = "SELECT * FROM reports";               // SQL query to fetch all table data
                $view_reports = mysqli_query($con, $query);    // sending the query to the database

                //  displaying all the data retrieved from the database using while loop
                while ($row = mysqli_fetch_assoc($view_reports)) {
                    $contract_id = $row['contract_id'];
                    $user_id = $row['user_id'];
                    $car_id = $row['car_id'];
                    $date = $row['date'];
                    $final_price = $row['final_price'];

                    echo "<tr >";
                    echo " <th scope='row' >{$contract_id}</th>";
                    echo " <td > {$user_id}</td>";
                    echo " <td > {$car_id}</td>";
                    echo " <td >{$date} </td>";
                    echo " <td >{$final_price} </td>";


                    echo " <td class='text-center' > <a href='update.php?edit&contract_id={$contract_id}' class='btn btn-secondary'><i class='bi bi-pencil'></i> EDIT</a> </td>";

                    echo " <td  class='text-center'>  <a href='delete.php?contract_id={$contract_id}' class='btn btn-danger'> <i class='bi bi-trash'></i> DELETE</a> </td>";
                    echo " </tr> ";
                }
                ?>
            </tr>
        </tbody>
    </table>
</div>

<!-- Footer -->
<?php include "../templates/footer.php" ?>