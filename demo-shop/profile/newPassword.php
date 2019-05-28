<?php
session_start();
require_once('../Models/User.php');
require_once('../Services/UserService.php');


$userService = new UserService();
$user = $userService->getByID($_POST["UserID"]);
$userEmail = $user->getUsername();
$msg = "Email Message";
echo ("mail($userEmail,My subject,$msg); Email sent");
?>
