<?php 
session_start();
require_once('../Scripts/checkLogin.php');
require_once('../Models/Attribute.php');
require_once('../Models/Catagory.php');
require_once('../Services/AttributeService.php');
require_once('../Services/CatagoryService.php');
require_once('../Models/User.php');
require_once('../Services/UserService.php');

$userService = new UserService(); // create a new instance of the user service
$userId= ($_SESSION["user_id"]); // sets the current user to the user with the current session id

$user = $userService->getByID($userId);

if (isset($_POST['username'])){ //if a username is posted
    $user->setUsername($_POST['username']); //post the username to the user model
    $userService->update($user); // run the update method passing the user
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
    <link rel="stylesheet" type="text/css" media="screen" href="../styles.css" />
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
                   You are editing <?php echo ($user->getUsername($userId))?>'s Email.
                </div>
                <div class="col">
                    <div class="button Home" onclick ="window.location='index.php'">Back</div> <!-- navigation -->
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <form method="post"> <!-- post the data on submit -->
                        <input required type="email" name="username" value="<?php echo($user->getUsername())?>" placeholder="Enter New Email"> <!-- displays the users current email and allows them to type a new email -->
                        <input type="submit" value="Submit"> <!-- submit the form -->
                    </form>
                </div>
            </div>
        </div>
    </div>   
</body>
</html>