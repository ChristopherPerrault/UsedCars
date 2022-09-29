<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <authors made-by="Christoper Perrault, Matthew Reda, Seena Sabet-Kassouf" in="Sept 2022">

        <meta name="keywords" content="used sell cars car classified classifieds php mysql javascript crud auth authentiaction validation REST RESTful api apis phpmyadmin database db">

        <meta name="description" content="This web application takes the role as a mock used car dealership to demonstrate CRUD capabilities within a PHP, MySQL and Javascript environment. See attached supporting documents and/or readme for more information.">

        <!-- Link to CSS Bootstrap CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

        <!-- Link to Custom CSS -->
        <link rel="stylesheet" href="css/style.css">

        <!-- Link to Favicon -->
        <link rel="icon" href="assets/img/favicon.png">

        <!-- Link to JS Bootstrap CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
        </script>
</head>

<!-- Universal header -->

<body>
    <header></header>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">

            <a class="navbar-brand">Used Cars</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                    #different nav display based on usertype (admin or user)

                    #store session user_id in var
                    $user_id = $_SESSION['user_id'];

                    #query -> check if user exists
                    $query = "SELECT * FROM `users` WHERE user_id='$user_id'";

                    #execute query  
                    $result = mysqli_query($con, $query) or die(mysqli_error($con));

                    #store user info
                    $row = mysqli_fetch_assoc($result);

                    #check if admin or user -> enable or disable links 
                    if ($row['usertype'] == 'admin') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="adminDashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="view-accounts.php">View All Accounts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="searchDatabase.php">Search Database</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="view-report.php">Reports</a>
                        </li>

                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index-logged-in.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="userdashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="my-account.php">My Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="addCar.php">Add Car Listing</a>
                        </li>
                    <?php }
                    ?>

                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Log Out</a>
                    </li>
                </ul>
            </div>

            <a class="nav-link"><b><?php echo "Hello, " . $row['username'] ?></b></a>
        </div>
    </nav>
    </header>