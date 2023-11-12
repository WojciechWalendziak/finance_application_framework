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

      $incomes = sprintf('SELECT category, amount, payment_date, additional_comment FROM income_list WHERE users_id="%s"',
      mysqli_real_escape_string($database_connection,$user_id));
      $incomes .= ' ORDER BY amount DESC';
      $income_result = $database_connection->query($incomes);
    }
    return $income_result;
?>