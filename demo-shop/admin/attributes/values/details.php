<?php 
session_start();
require_once('../../../Scripts/checkLogin.php');
require_once('../../../Models/AttributeValue.php');
require_once('../../../Services/AttributeValueService.php');
require_once('../../../Models/User.php');
require_once('../../../Services/UserService.php');
require_once('../../../Scripts/checkAdmin.php');


$attributeValueService = new AttributeValueService();
$attributeValue = new AttributeValue();

$attributeValue = $attributeValueService->getByID($_GET['attributevalueID']);


if (isset($_POST["attributevaluename"])) {
    $newName = $_POST["attributevaluename"];
    $attributeValue->setValue($newName);
    $attributeValueService->update($attributeValue);
}
$currentUser = $userService->getByID($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../../../styles.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <div class="row">
            <div class="col">
                You are editing the <?php echo $attributeValue->getValue(); ?> attribute value.
                </div>
                <div class="col">
                <div class="button Home" onclick ="window.location='../index.php'">Back</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <form method="post">
                        Attribute Value Name:<br>
                        <input type="text" name="attributevaluename">
                        <input type="submit" value="Save">
                    </form>
                    <div class="trash delete button home" data-value-id="<?php $attributeValue->getID() ?>"><i class="fas fa-minus-circle">Delete</i></div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>

$(document).on('click', '.delete', function() {
    var id = $(this).data('value-id');

    if (confirm('Are you sure you want to delete this attribute value?')) {
        $.post('deleteAttributeValue.php', { AttributeValueID: <?php echo $attributeValue->getID() ?>}).done(function (response) {
            if (response == "") {
                window.location='../index.php'
            }
            else {
                console.log(response);
            }
        });
    }
});
</script>
</html>