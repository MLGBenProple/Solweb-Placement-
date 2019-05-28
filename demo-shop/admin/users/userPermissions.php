<?php
session_start();
require_once('../../Scripts/checkLogin.php');
require_once('../../Services/ProductService.php');
require_once('../../Services/AttributeValueService.php');
require_once('../../Models/AttributeValue.php');
require_once('../../Models/Product.php');
require_once('../../Models/User.php');
require_once('../../Services/UserService.php');
require_once('../../Scripts/checkAdmin.php');

$userService = new UserService(); // new instance of the user service

$user = $userService->getByID($_POST['UserID']);  //get the posted user id
if ($user->getIsAdmin() == 0){ //if the user with that id doesnt have admin rights do the following
    $user->setIsAdmin(1); // give them admin rights
}
else { //if they do have admin rights
    $user->setIsAdmin(0); // take away the admin rights
}
$userService->update($user); // run the update method passing in the user
?>