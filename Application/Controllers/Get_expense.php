<?php

  //include 'connect_test_db.php';
  session_start();

  if (!isset($_SESSION['zalogowany']))
	{
		header('Location: login_view.php');
		exit();
	}
  require_once 'connect.php';

    $database_connection = @new mysqli($host, $db_user, $db_password, $db_name);
    
    if ($database_connection->connect_errno!=0)
    {
      echo 'Error: '.$database_connection->connect_errno;
    }
    else
    {
      $user_id = $_SESSION['user_id'];

      $expenses = sprintf('SELECT category, amount, payment_date, payment_method, additional_comment FROM expenses_list WHERE users_id="%s"', 
      mysqli_real_escape_string($database_connection,$user_id));
      $expenses .= ' ORDER BY amount DESC'; 
      $expense_result = $database_connection->query($expenses);
      
    }
    return $expense_result;
?>