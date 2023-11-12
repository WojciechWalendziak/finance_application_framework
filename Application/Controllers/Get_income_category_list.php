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

    $categories = "SELECT category_name FROM income_categories";
    $category_list = $database_connection->query($categories);	
  }

  return $category_list;
?>