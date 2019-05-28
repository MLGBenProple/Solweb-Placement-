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

$userService = new UserService();

$user = $userService->getByID($_POST['UserID']);
$userService->delete($user);
?>