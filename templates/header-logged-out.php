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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</head>

<!-- Universal header -->

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">

                <a class="navbar-brand" href="index-logged-out.php" title="View All Active Listings">Used Cars</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <!-- Main Nav-Bar Items -->
                        <li class="nav-item">
                            <a class="nav-link" href="registration.php">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Log In</a>
                        </li>
                        
                    </ul>

                </div>
            </div>
        </nav>
    </header>
</body>
</html>
