<?php

	namespace Application\Controllers;
	use \Application\Models\User;
	session_start();
	if ((!isset($_POST['login'])) || (!isset($_POST['password'])))
	{
		header('Location: login_view.php');
		exit();
	}
	else
    {
		$user = new User($_POST);
        $user->login();
    }
?>