<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: menu_view.php');
		exit();
	}

?>
<!DOCTYPE html>
<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="styles/styles.css" type="text/css"/>
  <script src="scripts/logowanie.js"></script>
</head>
<body>
  <div class="wrapper">
    <h1>Witaj w aplikacji !</h1>
    <form class="container" action="Redirect_to_registration.php" method="post">
      <input class="submit_button" type="submit" value="UTWÓRZ KONTO">
    </form>
    <form class="container" action="Redirect_to_login.php" method="post">
      <input class="submit_button" type="submit" value="MAM JUŻ KONTO">
    </form>
  </div>
  <?php
    if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
  ?>
</body>
</html>

