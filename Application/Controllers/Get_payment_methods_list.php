<?php

  //include 'connect_test_db.php';
  session_start();

  if (!isset($_SESSION['zalogowany']))
	{
		header('Location: login_view.php');
		exit();
	}
  
	require_once "connect.php";

	$database_connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($database_connection->connect_errno!=0)
	{
		echo "Error: ".$database_connection->connect_errno;
    echo "<form class='container' action='Return_to_menu.php' method='post'><input class='submit_button' type='submit' value='Wróć do Menu'></form>";
	}
  else
  {
    $user_id = $_SESSION['user_id'];	
    $payment_methods_names = "SELECT payment_name FROM payment_methods";
    $payment_methods_list = $database_connection->query($payment_methods_names);

    return $payment_methods_list;
  }
?>