<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">

                <a class="navbar-brand navbar-name" href="#">
                    Welcome
                    <?php echo $_SESSION['name']; ?>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown nav-li">
                        <a href="php/logout.php" class=" btn btn btn-success text-white" data-toggle="dropdown" role="button"
                            aria-expanded="false">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
</body>

</html>