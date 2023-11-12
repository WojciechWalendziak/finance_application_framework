<?php

namespace Application\Controllers;
use \Application\Models\User;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class Signup
{
	public function createAction()
    {
		session_start();

		if ((!isset($_POST['login'])) || (!isset($_POST['password'])) || (!isset($_POST['name'])) || (!isset($_POST['surname'])))
		{
			header('Location: signup_view.php');
			exit();
		}
        else
        {
            $user = new User($_POST);
            $user->save();
        }
    }
}
?>