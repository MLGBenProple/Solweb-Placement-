<?php 
session_start();
require_once('../../Scripts/checkLogin.php');
require_once('../../Models/Product.php');
require_once('../../Services/ProductService.php');
require_once('../../Models/User.php');
require_once('../../Services/UserService.php');
require_once('../../Scripts/checkAdmin.php');

$user= new User();
$userService = new UserService();

if (isset($_POST["username"])) {
    $username = $user->setUsername($_POST["username"]);
    $password = $user->setPassword($_POST["password"]);
    if(isset($_POST["admin"])) {
        $admin = $user->setIsAdmin("1");
    }
    else {
        $admin = $user->setIsAdmin("0");
    }
    $userService->create($user);
}
    
$currentUser = $userService->getByID($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../../styles.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="main.js"></script>
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <div class="row">
                <div class="col">
                    <form method="post" name="myform">
                    <input type="hidden"name="length" value="10"> <!-- sets the password length to 10 characters -->
                        Username:<br>
                        <input type="email" name="username"> <!-- username input -->
                        <br>
                        Password:<br>
                        <input type ="password" name="password" required> <!-- password input -->
                        <input type="button" value="Generate" onClick="generate();" tabindex="2"> <!-- generate a random password -->
                        <br>
                        <input type="checkbox" name="admin" value="admin"> Admin
                        <br>
                        <input type="submit" value="Create">
                    </form>
                </div>
                <div class="col">
                    <div class="button Home" onclick ="window.location='index.php'">Back</div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
function randomPassword(length) {
    var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"; // possible characters
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
}

function generate() {
    myform.password.value = randomPassword(myform.length.value);
}
</script>
</html>