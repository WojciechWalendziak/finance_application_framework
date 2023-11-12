<?php

namespace App\Models;

use PDO;
use Controllers\Redirection;
class User {
  /**
   * Summary of name
   * @var 
   */
  public $name;
  /**
   * Summary of surname
   * @var 
   */
  public $surname;
  /**
   * Summary of login
   * @var 
   */
  public $login;
  /**
   * Summary of password
   * @var 
   */
  public $password;


  /**
   * Summary of __construct
   * @param mixed $name
   * @param mixed $surname
   * @param mixed $login
   * @param mixed $password
   */
  function __construct($name, $surname, $login, $password) {
    $this->name = $name;
    $this->surname = $surname;
    $this->login = $login;
    $this->password = $password;
  }

  /**
     * Save the user model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */

  /**
   * Summary of save
   * @return void
   */
  
  //public function connect_to_database()
  //{
    //require_once "connect.php";
    //$database_connection = @new mysqli($host, $db_user, $db_password, $db_name);
   // return $database_connection;
 // } 
  public function save()
  {
    require_once "connect.php";
    $database_connection = @new mysqli($host, $db_user, $db_password, $db_name);
    if ($database_connection->connect_errno!=0)
    {
      echo "Error: ".$database_connection->connect_errno;
    }
    else
    {
      $name = $_POST['name'];
      $login = $_POST['login'];
      $password = $_POST['password'];
      $surname = $_POST['surname'];
      
      $name = htmlentities($name, ENT_QUOTES, "UTF-8");
      $surname = htmlentities($surname, ENT_QUOTES, "UTF-8");
      $login = htmlentities($login, ENT_QUOTES, "UTF-8");
      $password = htmlentities($password, ENT_QUOTES, "UTF-8");
    
      //if ($result = @$database_connection->query(
      $txt = sprintf("SELECT * FROM users_list WHERE user_login='%s' OR user_password='%s'",
      mysqli_real_escape_string($database_connection,$login),
      mysqli_real_escape_string($database_connection,$password));
      
      $result = $database_connection->query($txt);
      
      $ilu_userow = $result->num_rows;

      if($ilu_userow == 0)
      {
        $sql = "INSERT INTO users_list (user_first_name, user_surname, user_login, user_password) VALUES (':name', ':surname', ':login', ':password')";
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':surname', $this->surname, PDO::PARAM_STR);
        $stmt->bindValue(':login', $this->login, PDO::PARAM_STR);
        $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);
      }
      else
      {				
        $_SESSION['blad'] = '<span style="color:red">Login lub hasło juz zajete!</span>';
        //header('Location: rejestracja.php');
        Redirection::redirect('/signup.php');	
        echo "0 results";
      }
      if ($database_connection->query($sql) === TRUE)
      {
        $_SESSION['blad'] = '<h1 style="color:white">Konto zostalo stworzone, proszę się zalogować</h1>';
        //header('Location: login_view.php');
        $this->redirect('/login_view.php');	
      } 
      else 
      {
        echo "Error: " . $sql . "<br>" . $database_connection;
      }
    }
    $database_connection->close();
  }
  public function login()
  {
    require_once "connect.php";
    $database_connection = @new mysqli($host, $db_user, $db_password, $db_name);
    if ($database_connection->connect_errno!=0)
    {
      echo "Error: ".$database_connection->connect_errno;
    }
    else
    {
      $login = $_POST['login'];
      $haslo = $_POST['password'];
      
      $login = htmlentities($login, ENT_QUOTES, "UTF-8");
      $haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
    
      $sql = "SELECT * FROM users_list WHERE user_login=':login' AND user_password=':password'";
      //mysqli_real_escape_string($database_connection,$login),
      //mysqli_real_escape_string($database_connection,$haslo));

      $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':login', $this->login, PDO::PARAM_STR);
        $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);

      $rezultat = $database_connection->query($sql);
      $ilu_userow = $rezultat->num_rows;
      if($ilu_userow>0)
      {
        $_SESSION['zalogowany'] = true;
        $wiersz = $rezultat->fetch_assoc();
        $_SESSION['user_id'] = $wiersz['user_id'];
        unset($_SESSION['blad']);
        $rezultat->free_result();
        //header('Location: menu.php');
        $this->redirect('/menu_view.php');
        exit();
      }
      else
      {			
        $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
        //header('Location: rejestracja.php');
        $this->redirect('/signup_view.php');	
      }
    }
      $database_connection->close();
  }
  public function change_login_data()
  {
    require_once "connect.php";
    $database_connection = @new mysqli($host, $db_user, $db_password, $db_name);
    if ($database_connection->connect_errno!=0)
    {
      echo "Error: ".$database_connection->connect_errno;
    }
    else
    {
      $user_id = $_SESSION['user_id'];
      $new_login = $_POST['new_login'];
      $new_password = $_POST['new_password'];
      
      $new_login = htmlentities($new_login, ENT_QUOTES, "UTF-8");
      $new_password = htmlentities($new_password, ENT_QUOTES, "UTF-8");
      
      $sql = "SELECT * FROM users_list WHERE user_id = ':user_id'";
      
      $db = static::getDB();
      $stmt = $db->prepare($sql);

      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

      $result = $database_connection->query($sql);
      
      $ilu_userow = $result->num_rows;

      if($ilu_userow == 1)
      {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
        $sql = $database_connection->query("UPDATE users_list SET user_login = ':new_login', user_password = ':new_password' WHERE user_id = ':user_id'");

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':new_login', $new_login, PDO::PARAM_STR);
        $stmt->bindValue(':new_password', $new_password, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

        if ($sql === TRUE)
        {
          echo '<!DOCTYPE html><html lang="pl"></html><html><head><link rel="stylesheet" href="/styles/styles/styles.css" type="text/css"/></head><tbody><h1>Dane zostaly zmienione</h1><form class="container" action="Return_to_menu.php" method="post"><input class="submit_button" type="submit" value="Wróć do Menu"></form></tbody</html>';
        } 
        else
        {
          echo "Error: " . $sql . "<br>" . $database_connection;
          echo '<!DOCTYPE html><html lang="pl"></html><html><head><link rel="stylesheet" href="/styles/styles/styles.css" type="text/css"/></head><tbody><h1>Error: ' . $sql . '<br>' . $database_connection.'</h1><form class="container" action="Return_to_menu.php" method="post"><input class="submit_button" type="submit" value="Wróć do Menu"></form></tbody</html>';
        }
      }
      else
      {				
        $_SESSION['blad'] = '<span style="color:red">Operacja zmiany danych nie powiodla sie!</span><form class="container" action="Return_to_menu.php" method="post"><input class="submit_button" type="submit" value="Wróć do Menu"></form>';
      }
    }
    $database_connection->close();
  }
  public function add_income_category()
  {
    require_once "connect.php";
    $database_connection = @new mysqli($host, $db_user, $db_password, $db_name);
    if ($database_connection->connect_errno!=0)
    {
      echo "Error: ".$database_connection->connect_errno;
    }
    else
    {
      $category = $_POST['new_income_category'];
      
      $category = htmlentities($category, ENT_QUOTES, "UTF-8");
      
      $sql = "INSERT INTO income_categories (category_name) VALUE ':new_category'";

      $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':new_category', $category, PDO::PARAM_STR);

      if ($database_connection->query($sql) === TRUE)
      {
        echo '<!DOCTYPE html><html lang="pl"></html><html><head><link rel="stylesheet" href="/styles/styles/styles.css" type="text/css"/></head><tbody><h1>Kategoria zostala dodana</h1><form class="container" action="Return_to_menu.php" method="post"><input class="submit_button" type="submit" value="Wróć do Menu"></form></tbody</html>';
      } 
      else
      {
        echo 'Error: ' . $sql . '<br>' . $database_connection;
        echo '<link rel="stylesheet" href="styles/styles.css" type="text/css"/><form class="container" action="Return_to_menu.php" method="post"><input class="submit_button" type="submit" value="Wróć do Menu"></form>';
      }
    }
    $database_connection->close();
  }

  public function add_expense_category()
  {
    require_once "connect.php";
    $database_connection = @new mysqli($host, $db_user, $db_password, $db_name);
    if ($database_connection->connect_errno!=0)
    {
      echo "Error: ".$database_connection->connect_errno;
    }
    else
    {
      $category = $_POST['new_expense_category'];
      
      $category = htmlentities($category, ENT_QUOTES, "UTF-8");
      
      $sql = "INSERT INTO expense_categories (expense_category) VALUE ':new_category'";

      $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':new_category', $category, PDO::PARAM_STR);

      if ($database_connection->query($sql) === TRUE)
      {
        echo '<!DOCTYPE html><html lang="pl"></html><html><head><link rel="stylesheet" href="/styles/styles/styles.css" type="text/css"/></head><tbody><h1>Kategoria zostala dodana</h1><form class="container" action="Return_to_menu.php" method="post"><input class="submit_button" type="submit" value="Wróć do Menu"></form></tbody</html>';
      } 
      else
      {
        echo 'Error: ' . $sql . '<br>' . $database_connection;
        echo '<link rel="stylesheet" href="styles/styles.css" type="text/css"/><form class="container" action="Return_to_menu.php" method="post"><input class="submit_button" type="submit" value="Wróć do Menu"></form>';
      }
    }
    $database_connection->close();
  }
  public function add_payment_method()
  {
    require_once "connect.php";
    $database_connection = @new mysqli($host, $db_user, $db_password, $db_name);
    if ($database_connection->connect_errno!=0)
    {
      echo "Error: ".$database_connection->connect_errno;
    }
    else
    {
      $payment_method = $_POST['new_payment_method'];
      
      $payment_method = htmlentities($payment_method, ENT_QUOTES, "UTF-8");
      
      $sql = "INSERT INTO payment_methods (payment_name) VALUE ':new_payment_method'";

      $db = static::getDB();
      $stmt = $db->prepare($sql);

      $stmt->bindValue(':new_payment_method', $payment_method, PDO::PARAM_STR);

      if ($database_connection->query($sql) === TRUE)
      {
        echo '<!DOCTYPE html><html lang="pl"></html><html><head><link rel="stylesheet" href="/styles/styles/styles.css" type="text/css"/></head><tbody><h1>Metoda platnosci zostala dodana</h1><form class="container" action="Return_to_menu.php" method="post"><input class="submit_button" type="submit" value="Wróć do Menu"></form></tbody</html>';
      } 
      else
      {
        echo 'Error: ' . $sql . '<br>' . $database_connection;
        echo '<link rel="stylesheet" href="styles/styles.css" type="text/css"/><form class="container" action="Return_to_menu.php" method="post"><input class="submit_button" type="submit" value="Wróć do Menu"></form>';
      }
    }
    $database_connection->close();
  }
  public function add_income()
  {
    require_once "connect.php";
    $database_connection = @new mysqli($host, $db_user, $db_password, $db_name);
    if ($database_connection->connect_errno!=0)
    {
      echo "Error: ".$database_connection->connect_errno;
    }
    else
    {
      $category = $_POST['category'];
      $amount = $_POST['amount'];
      $date = $_POST['date'];
      $additional_comment = $_POST['additional_comment'];
      $user_id = $_SESSION['user_id'];
      
      $category = htmlentities($category, ENT_QUOTES, "UTF-8");
      $amount = htmlentities($amount, ENT_QUOTES, "UTF-8");
      $date = htmlentities($date, ENT_QUOTES, "UTF-8");
      
      $sql = "INSERT INTO income_list (category, amount, payment_date, users_id, additional_comment) VALUES (':category', ':amount', ':date', ':user_id', ':additional_comment')";

      $db = static::getDB();
      $stmt = $db->prepare($sql);

      $stmt->bindValue(':category', $category, PDO::PARAM_STR);
      $stmt->bindValue(':amount', $amount, PDO::PARAM_STR);
      $stmt->bindValue(':date', $date, PDO::PARAM_STR);
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
      $stmt->bindValue(':additional_comment', $additional_comment, PDO::PARAM_STR);

      if ($database_connection->query($sql) === TRUE)
      {
        echo '<!DOCTYPE html><html lang="pl"></html><html><head><link rel="stylesheet" href="/styles/styles/styles.css" type="text/css"/></head><tbody><h1>Przychod zostal dodany</h1><form class="container" action="Return_to_menu.php" method="post"><input class="submit_button" type="submit" value="Wróć do Menu"></form></tbody</html>';
      } 
      else
      {
        echo "Error: " . $sql . "<br>" . $database_connection;
        echo '<!DOCTYPE html><html lang="pl"></html><html><head><link rel="stylesheet" href="/styles/styles/styles.css" type="text/css"/></head><tbody><h1>Error: ' . $sql . '<br>' . $database_connection.'</h1><form class="container" action="Return_to_menu.php" method="post"><input class="submit_button" type="submit" value="Wróć do Menu"></form></tbody</html>';
      }
    }
    $database_connection->close();
  }
  public function add_expense()
  {
    require_once "connect.php";
    $database_connection = @new mysqli($host, $db_user, $db_password, $db_name);
    if ($database_connection->connect_errno!=0)
    {
      echo "Error: ".$database_connection->connect_errno;
    }
    else
    {
      $category = $_POST['category'];
      $amount = $_POST['amount'];
      $date = $_POST['date'];
      $additional_comment = $_POST['additional_comment'];
      $payment_method = $_POST['payment_method'];
      $user_id = $_SESSION['user_id'];
      
      $category = htmlentities($category, ENT_QUOTES, "UTF-8");
      $amount = htmlentities($amount, ENT_QUOTES, "UTF-8");
      $date = htmlentities($date, ENT_QUOTES, "UTF-8");
      $payment_method = htmlentities($payment_method, ENT_QUOTES, "UTF-8");
      
      $sql = "INSERT INTO expenses_list (category, amount, payment_date, payment_method, users_id, additional_comment) VALUES (':category', ':amount', ':date', ':payment_method', ':user_id', ':additional_comment')";

      $db = static::getDB();
      $stmt = $db->prepare($sql);

      $stmt->bindValue(':category', $category, PDO::PARAM_STR);
      $stmt->bindValue(':amount', $amount, PDO::PARAM_STR);
      $stmt->bindValue(':date', $date, PDO::PARAM_STR);
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
      $stmt->bindValue(':additional_comment', $additional_comment, PDO::PARAM_STR);

      if ($database_connection->query($sql) === TRUE)
      {
        echo '<!DOCTYPE html><html lang="pl"></html><html><head><link rel="stylesheet" href="/styles/styles/styles.css" type="text/css"/></head><tbody><h1>Wydatek zostal dodany</h1><form class="container" action="Return_to_menu.php" method="post"><input class="submit_button" type="submit" value="Wróć do Menu"></form></tbody</html>';
      } 
      else
      {
        echo "Error: " . $sql . "<br>" . $database_connection;
        echo '<!DOCTYPE html><html lang="pl"></html><html><head><link rel="stylesheet" href="/styles/styles/styles.css" type="text/css"/></head><tbody><h1>Error: ' . $sql . '<br>' . $database_connection.'</h1><form class="container" action="Return_to_menu.php" method="post"><input class="submit_button" type="submit" value="Wróć do Menu"></form></tbody</html>';
      }
    }
    $database_connection->close();
  }
}
?>