<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Data-Table-1.css">
    <link rel="stylesheet" href="assets/css/Data-Table.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="assets/css/Search-Field-With-Icon.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>

<body>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <div class="login-clean" style="background-color: rgb(244,244,244);">
        <form action="loginback.php" method="post">
            Username
            <div class="form-group"><input class="form-control" style="background-color: rgb(244,244,244);" type="username" name="Username"></div>
            Password 
            <div class="form-group"><input class="form-control" style="background-color: rgb(244,244,244);" type="password" name="Password"></div>
            <div class="form-group"><button class="btn btn-secondary btn-block" type="submit">Log In</button></div>
        </form>
    </div>
</body>

<?php include "./classes/nav2.php"; ?>

</html>