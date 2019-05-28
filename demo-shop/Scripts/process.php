<?php

require_once('../Models/User.php');
require_once('../Services/UserService.php');

$userService= new UserService(); // new instance of the user service
$user = new User(); // new instance of the user model
session_start();

if (isset($_POST["registerusername"])) { // if registerusername is posted do the following...
            $user->setUsername($_POST['registerusername']); // set the username of the user to the value of registerusername
            $user->setPassword($_POST['registerpassword']); // set the password of the user to the value of registerpassword
            $user->setIsAdmin('0'); // dont give the user admin rights by default
        
            $userService->create($user); // run the create method passing the data just set
}



if (isset($_POST["username"])) { // if a username (email) is posted do the following...
    $userEmail = $_POST["username"]; //set the userEmail variable to the posted username
    $stmt->bindParam(':UserEmail', $userEmail); //bind the :UserEmail peramiter to the value of the userEmail variable
     if ('SELECT * FROM Username WHERE Username = :username'){ // select everything from the users table where the username = the passed username
        $msg = "Email Message"; // sets the msg variable to a message
         mail($userEmail,'Password Reset', $message); // send an email to the users email with the message
    }
    else {
        //user with that email adress not found.
    }

 }

?>

