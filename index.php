<?php
require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico">
    <link rel="icon" href="icon.ico" type="image/ico">
    <title>Log-In</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="assets/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
</head>

<body class="bg-light hold-transition login-page"
    style="background:url(assets/img/wp2.jpg) no-repeat center center fixed; background-size: cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;">
    <div class="container">
        <br><br><br><br><br><br><br><br>
        <div class="row justify-content-center">
            <div class="col-sm-8 col-md-6 col-lg-4">
                <div class="card-body bg-white shadow-sm">
                    <h1 class="h3 text-center mb-3" style="font-weight:600;">TB <span class="text-primary">Pilar Mas</span></h1>
                    <center>
                        <h2 class="h3 text-center mb-3" style="font-weight:600;">Login</h2>
                    </center>
                    <br>
                    <form method="POST" action="login_process.php">
                        <label for="user">Username</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="user" name="username" placeholder="Username"
                                required>
                        </div>

                        <label for="pass">Password</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-lock"></i></div>
                            </div>
                            <input type="password" class="form-control" id="pass" name="password" placeholder="Password"
                                required>
                        </div>
                        <center>
                            <div class="row">
                                <div class="col-6 pl-1 mt-2 text-center">
                                    <button class="btn btn-primary btn-block" name="login" type="submit">Login</button>
                                </div>
                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>