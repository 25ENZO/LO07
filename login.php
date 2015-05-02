<?php
session_start();
require('connec.php');


$username = $_POST['user_name'];;
$password = $_POST['password'];



$nbr = $db->query('Select count(*) as nbe, name   FROM registered_users where name= "'.$username.'" AND password = "' .$password .'"');
$nbr_final = $nbr->fetch();
$nbr_number = $nbr_final['nbe'];

		
		if( $nbr_number >=1 ) {

			echo 'Vous êtes loggez';
			$_SESSION['user_name']=$nbr_final['name'];;
                        header('Location: index.php');  
			
		}
		else{
			header('Location: index.php');
		}

?>