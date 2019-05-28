<?php 
session_start();
require_once('../../Scripts/checkLogin.php');
require_once('../../Models/User.php');
require_once('../../Services/UserService.php');
require_once('../../Scripts/checkAdmin.php');
$userService = new UserService();
$users = $userService->getAll();
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
        <div class="jumbotron">
            <div class="row">
                <div class="col">
                <div class="button Home" onclick ="window.location='http://www.dmd-winchester.org.uk/00-DMD19-STUDENTS/BenPople/demo-shop/?categoryID=';">Home</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                <div class="button Home" onclick ="window.location='new.php'">New User</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                <h1>Users</h1>
                    <table style="width:50%";>
                    <tr>
                        <th>ID</th>
                        <th>Username</th> 
                        <th>Is Admin</th>
                    </tr>
                    <?php
                        foreach($users as $user)  {
                    ?>
                    <tr>
                    <td><?php echo $user->getID(); ?>
                    <td><?php echo $user->getUsername(); ?>
                    <td><?php echo $user->getIsAdmin(); ?>
                    <td>
                        <?php if ($user->getID() != $_SESSION['user_id']){ ?>
                            <span class="trash permissions" data-value-id="<?php echo $user->getID(); ?>"><i class="fas fa-unlock-alt"></i>
                            <?php } ?>
                    <Td>
                        <?php if ($user->getID() != $_SESSION['user_id']){ ?>
                        <span class="trash delete" data-value-id="<?php echo $user->getID(); ?>"><i class="fas fa-minus-circle"></i></span>
                        <?php } ?>
                    </tr>
                    <?php
                    }
                    ?>
                    </table>
                   
                </div>
            </div>
        </div>
    </div>
</body>
<script>

$(document).on('click', '.delete', function() {
    var id = $(this).data('value-id');

    if (confirm('Are you sure you want to delete this user?')) {
        $.post('deleteUser.php', { UserID: <?php echo $user->getID() ?>}).done(function (response) {
            if (response == "") {
                location.reload();
            }
            else {
                console.log(response);
            }
        });
    }
});

$(document).on('click', '.permissions', function() {
    var id = $(this).data('value-id');

    if (confirm('Are you sure you would like to change <?php echo $user->getUsername()?>\'s permissions')) {
        $.post('userPermissions.php', { UserID: <?php echo $user->getID() ?>}).done(function (response) {
            if (response == "") {
                location.reload();
            }
            else {
                console.log(response);
            }
        });
    }
});
</script>
</html>