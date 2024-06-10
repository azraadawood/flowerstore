


<?php
//PHP code

if(isset($_GET['Logout'])){

    
if(isset($_SESSION['admin_logged_in'])){
unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_email']);
unset($_SESSION['admin_name']);
//Goes back to login page for admin
header('location: alogin.php');
exit;

}
}
?>