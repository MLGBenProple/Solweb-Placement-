<?php 

$userService = new UserService(); // create a new instance of the user service
$user = $userService->getByID($_SESSION['user_id']); // get the current user based on the current session

    if ($user->getIsAdmin() == 1){ // if the current user has admin rights in the database do the following...

    }
    else { //if they dont have admin rights do the following
        header("Location:../index.php"); // navigate them back to the home page
    }
    


?>
