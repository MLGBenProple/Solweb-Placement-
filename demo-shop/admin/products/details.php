<?php 
session_start();
require_once('../../Scripts/checkLogin.php');
require_once('../../Models/Product.php');
require_once('../../Models/Catagory.php');
require_once('../../Models/Attribute.php');
require_once('../../Models/AttributeValue.php');
require_once('../../Services/ProductService.php');
require_once('../../Services/CatagoryService.php');
require_once('../../Services/AttributeService.php');
require_once('../../Services/AttributeValueService.php');
require_once('../../Models/User.php');
require_once('../../Services/UserService.php');
require_once('../../Scripts/checkAdmin.php');



$productService = new ProductService();
$catagoryService = new CatagoryService();
$attributeService = new AttributeService();
$attributeValueService = new AttributeValueService();
$userService = new UserService();
$catagories = $catagoryService->getAll();
$product = $productService->getByID($_GET['productID']);
$attributeValues = $attributeValueService->getAll();
$attributeHeaders = $attributeService->getAll();



if (isset($_POST["product-updated"])) {
    $product->setNumber($_POST["productname"]);
    $product->setDescription($_POST["productdescription"]);
    $product->setCatagoryID($_POST["productcatagoryID"]);
    $product->setImgName($_FILES["imgName"]["name"]);
    
    $target_dir = "../../Images/";
    $target_file = $target_dir . basename($_FILES["imgName"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["imgName"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["imgName"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["imgName"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["imgName"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    $productService->update($product);


}

if (isset($_POST["attributevalueID"])) {
    $attributeValue = $attributeValueService->getByID($_POST['attributevalueID']);
    $productService->assignAttribute($product, $attributeValue);
}

    $attributes = $attributeService->getByProduct($product);

    
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
                    You are editing the <?php echo $product->getNumber(); ?> product.
                </div>
                <div class="col">
                    <div class="button Home" onclick ="window.location='index.php'">Back</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <form method="post" enctype="multipart/form-data" >
                        <input type="hidden" name="product-updated" value="1"/>
                        Product Name:
                        <br>
                        <input type="text" name="productname" value="<?php echo $product->getNumber();?>">
                        <br>
                        <br>
                        Product Description:
                        <br>
                        <input type="text" name="productdescription" value="<?php echo $product->getDescription();?>">
                        <br>
                        <br>
                        Catagory:
                        <br>
                        <select name="productcatagoryID">
                            <?php foreach($catagories as $catagory)  { ?>
                               <option <?php if ($product->getCatagoryID() == $catagory->getID()) echo "selected"; ?> value="<?php echo $catagory->getID(); ?>"><?php echo $catagory->getName();?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <br>
                        <br>
                        Image:<br>
                        <input type="file" name="imgName" id="imgName"><br>
                        <br>
                        <input type="submit" value="Save">
                    </form>
                </div>
                <div class="col">
                <div class="itemCell center">
                    <span><img src='../../Images/<?php echo $product->getImgName();?>' class="thumbnail" alt="No image available"></span>
                    <br>
                    <span class= detailHeader>ID:</span> <?php echo $product->getID(); ?>
                    <br>
                    <span class= detailHeader>Name:</span> <?php echo $product->getNumber(); ?>
                    <br>
                <span class= detailHeader>Description:</span> <?php echo $product->getDescription(); ?>  
                </div>
                </div>
            </div>
        </div>
<br>
        <div class="jumbotron">
            <h3>Attributes</h3>
            <div class="row">
                <div class="col">
                    <ul class="attributes">
                        <?php foreach($attributes as $attribute){ ?>  
                            <?php $values = $attributeValueService->getByAttributeAndProduct($attribute, $product); ?>
                            <li>
                                <div class="header">
                                    <?php echo $attribute->getName();?>
                                </div>
                                <ul>
                                    <?php foreach($values as $value){ ?>
                                        <li class="attributeList">
                                            <?php echo $value->getValue(); ?>
                                            <span class="trash delete" data-value-id="<?php echo $value->getID(); ?>"><i class="fas fa-minus-circle"></i></span>
                                        </li>  
                                    <?php } ?>         
                                </ul>        
                            </li>
                        <?php }?>
                    </ul>                   
                </div>
                <div class="col">
                <h3>Add Attributes</h3>
                    <form method="post">
                        <select name="attributevalueID">    
                            <?php foreach($attributeHeaders as $attribute){ ?>                 
                                <optgroup label="<?php echo $attribute->getName(); ?>">
                                    <?php 
                                    $attributeValuesByParent = $attributeValueService->getByParent($attribute);
                                    foreach($attributeValuesByParent as $value){ ?>
                                        <option value="<?php echo $value->getID() ?>">
                                            <?php echo $value->getValue(); ?>
                                        </option>
                                    <?php } ?>
                                </optgroup>
                            <?php } ?>
                        </select>
                    <input type="submit" value="Add">
                    </form>
                </div>                   
            </div>
        </div>  
    </div>
</body>
<script>


    $(document).on('click', '.delete', function() {
        var id = $(this).data('value-id');

        if (confirm('Are you sure you want to delete this item?')) {
            $.post('unassignAttributeValue.php', { productID: <?php echo $product->getID() ?>, valueID: id }).done(function (response) {
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