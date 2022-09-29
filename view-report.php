<!-- Header -->
<?php
require('config/db.php');
require('config/auth.php');
include('templates/header-logged-in.php');
?>



<div class="container">
    <h1 class="text-center">Current Reports</h1><br>
    <p class="text-center">
        Build Reports and Export them to your local computer!
    </p>
    <hr>

</div>
<div>
    <?php
    $add_report = "";
    $view_reports = "SELECT * FROM `reports`;";

    $listings = mysqli_query($con, $view_reports);

    $count = mysqli_num_rows($listings);

    if ($count == 0) {
        $add_report = "<p style='text-align:center;font-size:15pt;'> It looks like you do not have any active listings.<a href='add-report.php'> Add a new report here!</a></p>";
        echo $add_report;
    } else {
    ?>
        <table class="listings">
            <thead>
                <tr>
                    <th><strong>Contract ID</strong></th>
                    <th><strong>User ID</strong></th>
                    <th><strong>Car ID</strong></th>
                    <th><strong>Date</strong></th>
                    <th><strong>Final Price</strong></th>
                    <th><strong><a href="add-report.php" class='btn btn-outline-dark mb-2'> <i class="bi bi-person-plus"></i> Generate New Report</a></strong></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM reports";
                $view_reports = mysqli_query($con, $query);
                while ($row = mysqli_fetch_assoc($view_reports)) {
                ?>
                    <tr>
                        <td align="center"><?php echo $row['contract_id']; ?></td>
                        <td align="center"><?php echo $row['user_id']; ?></td>
                        <td align="center"><?php echo $row['car_id']; ?></td>
                        <td align="center"><?php echo $row['date']; ?></td>
                        <td align="center"><?php echo $row['final_price']; ?></td>
                        <td align="center">
                            <button id="edit-report"><a href="update-report.php?edit&contract_id=<?php echo $row['contract_id']; ?>">Edit</a></button>
                            <button id="delete-report"><a href="delete-report.php?contract_id=<?php echo $row['contract_id']; ?>">Delete</a></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
        </table>
</div>

<!-- Footer -->
<?php include "templates/footer.php" ?>