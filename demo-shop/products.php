<?php
session_start();
require_once('Scripts/checkLogin.php');
    require_once('Models/Product.php');
    require_once('Models/Attribute.php');
    require_once('Models/AttributeValue.php');
    require_once('Services/ProductService.php');
    require_once('Services/AttributeService.php');
    require_once('Services/AttributeValueService.php');

    $productService = new ProductService(); // Create a new instance of the product service
    $attributeService = new AttributeService(); // Create a new instance of the attribute service
    $attributeValueService = new AttributeValueService(); // Create a new instance of the attribute value service

    $id = $_GET['id']; //passed the ID in the URL to a variable
    $product = $productService->getByID($id); //get all the data for the product with the ID in the URL
    $attributes = $attributeService ->getByProduct($product); // get all the attributes asscoated with the product
    
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
</head>


<body>
    <div class="container">
        <div class="jumbotron">
            <div class="row">
                <div class="col">
                    <div class="button Home" onclick="window.location='http://www.dmd-winchester.org.uk/00-DMD19-STUDENTS/BenPople/demo-shop/?categoryID=';">Home</div> <!-- navigate to the home page and set the category ID to null -->
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 center">
                    <div class="itemCell center">
                        <span><img src='Images/<?php echo $product->getImgName();?>' class="thumbnail" alt="No image available"></span> <!-- get the product image -->
                        <br>
                        <span class=detailHeader>ID:</span>
                        <?php echo $product->getID(); ?> <!-- get the product ID -->
                        <br>
                        <span class=detailHeader>Name:</span>
                        <?php echo $product->getNumber(); ?> <!-- get the product name -->
                        <br>
                        <span class=detailHeader>Description:</span>
                        <?php echo $product->getDescription(); ?> <!-- get the product description -->
                    </div>
                </div>

                <div class="col-sm-8">
                    <ul class="attributes-flex">
                        <?php foreach($attributes as $attribute){ ?> <!-- Separate the array of attributes into individuals and do the following for each of them...-->
                        <li>
                            <?php $values = $attributeValueService->getByAttributeAndProduct($attribute, $product); ?> <!-- get all the attribute values associated with the product and attribute-->
                            <div class="dropdown">
                                <button class="btn button dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <!-- create a dropdown button -->
                                    <?php echo $attribute->getName();?> <!-- set the value of the button to the attribute header name -->
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> <!-- create a dropdown menu -->
                                    <?php foreach($values as $value){ ?> <!-- Separate the array of attribute values into individuals and do the following for each of them...-->
                                    <a class="dropdown-item" href="#"> <!-- create a dropdown item in the dropdown menu -->
                                        <?php echo $value->getValue(); ?> <!-- set the value of the dropdown item to the attribute value name -->
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </li>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>
</body>

</html>