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

$attributeValueService = new AttributeValueService();
$productService = new ProductService();

$attributeValue = $attributeValueService->getByID($_POST['valueID']);
$product = $productService->getByID($_POST['productID']);
$productService->unassignAttribute($product, $attributeValue);
?>