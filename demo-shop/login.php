<?php 
ob_start();
session_start();
    require_once('Models/User.php');
    require_once('Services/UserService.php');
    $userService= new UserService(); // Create a new instance of the user service
    $user = new User(); // Create a new instance of the user class  
?>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
        crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <script src="Scripts/login.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="login-page">
        <div class="form">
            <div id="register">
                <form class="register-form">
                    <input type="email" placeholder="E-Mail" name="RegisterUsername" id="RegisterUsername" /> <!-- username input -->
                    <label class="error" for="RegisterUsername" id="RegisterUsername_error" style="color: #ba0000;">This
                        field is required.</label> <!-- error message -->
                    <label class="error" for="RegisterUsername" id="RegisterUsername_error2" style="color: #ba0000;">Email
                        adress must contain '@' and '.'</label> <!-- error message -->
                    <input type="password" placeholder="Password" name="RegisterPassword" id="RegisterPassword" /> <!-- password input -->
                    <label class="error" for="RegisterPassword" id="RegisterPassword_error" style="color: #ba0000;">This
                        field is required.</label> <!-- error message -->
                    <input type="password" placeholder="Confirm Password" name="ConfirmRegisterPassword" id="ConfirmRegisterPassword" /> <!-- password confirmation input -->
                    <label class="error" for="ConfirmRegisterPassword" id="ConfirmRegisterPassword_error" style="color: #ba0000;">This
                        field is required.</label> <!-- error message -->
                    <label class="error" for="ConfirmRegisterPassword" id="ConfirmRegisterPassword_error2" style="color: #ba0000;">Password
                        Must Match.</label> <!-- error message -->
                    <button type="submit" name="submit" class="register-btn" id="submit_btn">Register</button> <!-- Form submission -->
                    <p class="message">Already have an account? <a href="#">Log in now</a></p> <!-- Navigation to Log in form -->
                </form>
            </div>
            <div id="forgottenPassword">
                <form class="forgottenPassword-form">
                    <input type="email" placeholder="E-Mail" name="Username" id="Username" /> <!-- email input -->
                    <label class="error" for="Username" id="Username_error" style="color: #ba0000;">This field is
                        required.</label> <!-- error message -->
                    <label class="error" for="Username" id="Username_error2" style="color: #ba0000;">Email adress must
                        contain '@' and '.'</label> <!-- error message -->
                    <button type="submit" name="submit" class="request-btn" id="request-btn">Request</button> <!-- Form submission -->
                    <p class="backtologinmessage">Suddenly Remembered?<a href="#">Back to Log in</a></p> <!-- Navigation to Log in form -->
                </form>
            </div>
            <form class="login-form" method="post">
                <input type="email" placeholder="Username" name="username" /> <!-- username input -->
                <input id="password" type="password" placeholder="Password" name="password" /> <!-- password input -->
                <p class="forgottenPassword"><a href="#">Forgotten Password?</a></p> <!-- Navigation to the forgotten password form -->
                <?php
                    if ( ! empty( $_POST ) ) { //if there is no posted data do the following...
                        if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) { //if the username and password have been posted do the following...
                            $user = $userService->getByUsername($_POST['username']); // get all the user data for the user with the posted username
                            $password = $user->getPassword(); // set the password variable to the users stored password
                            $passwordHash = password_hash("$password", PASSWORD_DEFAULT); //creates variable eholded an encrypted version of the password
                            if ( password_verify( $_POST['password'], $passwordHash ) ) { //if the password matches the un-encrypted password do the following..
                                $_SESSION['user_id'] = $user->getID(); // sests the sessions ID to the logged in users ID.
                                header("Location:index.php"); //navingate to the home page.
                            }
                            else {?> <!-- if the password  does not match the un-encrypted password do the following.. -->
                                <p style="margin-bottom: 15px; color: #ba0000;">
                                    <?php echo "Wrong Username / Password"; ?> <!-- alert the user -->
                                </p>
                            <?php }
                        }
                    }
                ?>
                <button type="submit">Log In</button> <!-- form submission -->
                <p class="message">Not registered?
                    <a href="#">Create an account</a> <!-- navigate to the registration form -->
                </p>
            </form>
        </div>
    </div>
</body>
<script>
    $('.message a').click(function () { // when an action is performed within the messsage class do the following...
        $('.register-form').animate({ //animate everything with the register-form class
            height: "toggle", // toggle the height
            opacity: "toggle" //toggle the oppacity
        }, "slow"); // perform the animation slower than default speed
        $('.login-form').animate({ //animate everything with the login-form class
            height: "toggle", // toggle the height
            opacity: "toggle" //toggle the oppacity
        }, "slow"); // perform the animation slower than default speed
    });
    $('.forgottenPassword a').click(function () { 
        $('.forgottenPassword-form').animate({ 
            height: "toggle", 
            opacity: "toggle"
        }, "slow");
        $('.login-form').animate({
            height: "toggle",
            opacity: "toggle"
        }, "slow");
    });
    $('.backtologinmessage a').click(function () {
        $('.forgottenPassword-form').animate({
            height: "toggle",
            opacity: "toggle"
        }, "slow");
        $('.login-form').animate({
            height: "toggle",
            opacity: "toggle"
        }, "slow");
    });
</script>
</html>