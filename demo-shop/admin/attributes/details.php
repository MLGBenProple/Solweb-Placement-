<?php 
session_start();
require_once('../../Scripts/checkLogin.php');
require_once('../../Models/Attribute.php');
require_once('../../Models/AttributeValue.php');
require_once('../../Services/AttributeValueService.php');
require_once('../../Services/AttributeService.php');
require_once('../../Models/User.php');
require_once('../../Services/UserService.php');
require_once('../../Scripts/checkAdmin.php');


$attributeService = new AttributeService();
$attributeValueService = new AttributeValueService();
$attribute = new Attribute();

$currentUser = $userService->getByID($_SESSION['user_id']);

$attribute = null;
if (isset($_GET['attributeID'])) {
    $attribute = $attributeService->getByID($_GET['attributeID']);
}

if (isset($_POST["attributename"])) {
    $newName = $_POST["attributename"];
    $attribute->setName($newName);
    $attributeService->update($attribute);
}

$attributes = $attributeValueService->getByParent($attribute);

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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="jumbotron">
        <div class="row">
                <div class="col">
                You are editing the <?php echo $attribute ->getName();?> attribute.
                </div>
            </div>
            <div class="row">
                <div class="col">
                <div class="button Home" onclick ="window.location='index.php'">Back</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <form method="post">
                        Attribute Name:<br>
                        <input type="text" name="attributename">
                        <input type="submit" value="Save">
                    </form>
                </div>
                <div class="col">
                    <div class="button Home" onclick ="window.location='values/new.php?attributeID=<?php echo $attribute->getID() ?>'">New Value</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php
                        foreach($attributes as $attribute)  {
                    ?>
                            <a class="button" href="values/details.php?attributevalueID=<?php echo $attribute->getID() ?>">
                                <?php echo $attribute->getValue(); ?>
                            </a>
                    <?php
                    }
                    ?>
                </div>
			</div>
        </div>
    </div>
</body>
</html>