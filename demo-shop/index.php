<?php
    session_start();

    require_once('Scripts/checkLogin.php');
    require_once('Models/Product.php');
    require_once('Models/Catagory.php');
    require_once('Services/ProductService.php');
    require_once('Services/CatagoryService.php');
    require_once('Models/User.php');
    require_once('Services/UserService.php');

    $productService = new ProductService(); // Create a new instance of the product service
    $catagoryService = new CatagoryService(); // Create a new instance of the catagory service
    $userService= new UserService(); // Create a new instance of the user service
    $catagory = null; // by default set the catagory to null
    if (isset($_GET['catagoryID'])) {                               //if the catagory ID is set in the URL...
        $catagory = $catagoryService->getByID($_GET['catagoryID']); // get all the information about the catagory with that ID
    }
    $currentUser = $userService->getByID($_SESSION['user_id']); // Gets the current user information from the session
    $catagories = $catagoryService->getByParent($catagory);
    $products = $productService->getByCatagoryRecursive($catagory);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="jumbotron">
            <div class="row">
                <div class="col">
                    <div class="button Home" onclick="window.location='Scripts/logOut.php'">Log-Out</div>
                    <!-- navigate to the log out page -->

                    <?php if( $currentUser->getIsAdmin() == '1') { ?>
                    <!-- Check if the current user is an admin -->
                    <div class="button Home" onclick="window.location='admin/index.php'">Admin</div>
                    <!-- Display the admin button if they are -->
                    <?php } ?>

                    <div class="button Home" onclick="window.location='profile/index.php'">Profile</div>
                    <!-- navigate to the user profile page -->
                </div>
            </div>

            <?php if ($catagory != null) // if the $catagory variable is not null (there is a catagory ID in the url) display...
                { ?>
            <div class="row">
                <div class="button">
                    <a href="?catagoryID=<?php echo $catagory->getParentID()?>">
                        <!-- Set catagory ID in the URL to the 'parent catagory ID' of the current catagory ID -->
                        <?php echo $catagory->getName()?>
                        <!-- Set the value of the button to the name of the catagory with the ID in the URL -->
                    </a>
                </div>
            </div>
            <?php }?>
            <div class="row">
                <?php foreach($catagories as $catagory)  {?>
                <!-- Seporate the array of catagories into individuals and do the following for each of them...-->
                <a class="button" href="?catagoryID=<?php echo $catagory->getID() ?>">
                    <!-- set the catagory ID in the URL to the selected catagory ID -->
                    <?php echo $catagory->getName(); ?>
                    <!-- set the value of the button to the catagory name -->
                </a>
                <?php }?>
            </div>
        </div>
        <div class="jumbotron">
            <?php foreach($products as $product) { ?>
            <!-- Seporate the array of products into individuals and do the following for each of them...-->
            <div class="button" onclick="window.location='products.php?id=<?php echo $product->getID(); ?>';">
                <!-- navigate to the products page and sets the product ID in the UR: to the selected products ID -->
                <?php echo $product->getNumber(); ?>
                <!-- set the value of the button to the name of the product -->
            </div>
            <?php }?>
        </div>
    </div>
</body>

</html>