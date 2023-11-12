<?php

	namespace Application\Controllers;
	use \Application\Models\User;
	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: login_view.php');
		exit();
	}
	else
    {
        $user = new User($_POST);
        $user->add_payment_method();
    }
?>