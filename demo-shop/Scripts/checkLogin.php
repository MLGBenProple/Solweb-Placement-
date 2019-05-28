<?php 
if ( isset( $_SESSION['user_id'] ) ) { // if the session is set with a user ID

} else { // if the session is not set

    header("Location:logIn.php"); //navigate to the login page
}

?>