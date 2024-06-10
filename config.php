<?php //PHP code
//Connection to database
	$conn = new mysqli("localhost","root","","amourdatabase");
	if($conn->connect_error){
		die("Connection Failed!".$conn->connect_error);
	}
?>




