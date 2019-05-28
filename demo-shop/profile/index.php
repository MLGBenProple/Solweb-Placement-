<?php 
session_start();

$RootPath = "http://www.dmd-winchester.org.uk/00-DMD19-STUDENTS/BenPople/demo-shop";
require_once('../Scripts/checkLogin.php');
require_once('../Models/Attribute.php');
require_once('../Models/Catagory.php');
require_once('../Services/AttributeService.php');
require_once('../Services/CatagoryService.php');
require_once('../Models/User.php');
require_once('../Services/UserService.php');

$userService = new UserService();
$userId= ($_SESSION["user_id"]);

$user = $userService->getByID($userId);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $RootPath;?>/styles.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <div class="row">
            <div class="col">
                    <h1><?php echo ($user->getUsername($userId))?>'s Profile</h1>
                </div>
                <div class="col">
                    <div class="button Home" onclick ="window.location='<?php echo $RootPath;?>/index.php'">Back</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                <h1>Edit Profile</h1><br>
                        <h3>Email:</h3>
                        <?php echo $user->getUsername(); ?> <button onclick="window.location='newUsername.php'">Change</button>
                        <br>
                        <br>
                        <h3>Password:</h3>
                        <button class="newpass" data-value-id="<?php echo $user->getID(); ?>">Change</button>
                        
                </div>
            </div>
        </div>
    </div>   
</body>
<script>   
    $(document).on('click', '.newpass', function() {
        var id = $(this).data('value-id');
        if (confirm('Are you sure you want to chnage your password?')) {
            $.post('newPassword.php', {UserID: <?php echo $user->getID() ?>}).done(function (response) {
                if (response == "") {
                location.reload();
            }
            else {
                
                console.log(response);
            }          
            });
        }
    })
</script>
</html>