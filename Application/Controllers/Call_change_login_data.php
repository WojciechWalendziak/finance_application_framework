<?php

	namespace Application\Controllers;
	use \Application\Models\User;
	session_start();
	
	if ((!isset($_POST['new_login'])) || (!isset($_POST['new_password'])) || (!isset($_SESSION['zalogowany'])))
	{
		header('Location: menu_view.php');
		exit();
	}
	else
	{
		$user = new User($_POST);
        $user->change_login_data();
	}
?>