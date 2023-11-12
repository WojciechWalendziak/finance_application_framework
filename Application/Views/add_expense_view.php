<?php

  //include 'connect_test_db.php';
  include('Get_expense_category_list.php');
  include('Get_payment_list.php');
?>
<!DOCTYPE html>
<html lang="pl"></html>
<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha3104-gH1yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV10i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha3104-A3rJD1056KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="styles/styles.css" type="text/css"/>
  <script src="scripts/Add_expense_js.js"></script>
</head>
<body onload="current_date()">
  <h1>Dodaj Wydatek:</h1>
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <form id="form_field" action="Call_add_expense.php" method="post">
        <div class="select_field_common">
          <div class="row">
            <div class="col-sm-1"></div>  
            <div class="col-sm-10">
              <div class="row row_margin">
                <div class="col-sm-6">
                  <label for="kwota">Kwota:</label><br>
                </div>
                <div class="col-sm-6">
                  <input type="number" name="amount" placeholder="0.00" step="0.01" min="0" required/><br><br>
                </div>
              </div>
            </div>
            <div class="col-sm-1"></div> 
          </div>
          <div class="row">
            <div class="col-sm-1"></div>  
            <div class="col-sm-10">
              <div class="row row_margin">
                <div class="col-sm-6">
                  <label for="kwota">Sposob platnosci:</label><br>
                </div>
                <div class="col-sm-6">
                  <select name="payment_method" id="payment_method" required><br><br>
                    <option disabled selected value></option>
                    <?php
                      while($row = $payment_methods_list->fetch_assoc()) 
                      {
                        ?>
                      <option value=<?php echo $row['payment_name'];?>><?php echo $row['payment_name'];?></option>
                    <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-sm-1"></div>
          </div>
          <div class="row">
            <div class="col-sm-1"></div>  
            <div class="col-sm-10">
              <div class="row row_margin">
                <div class="col-sm-6">
                  <label for="data">Data:</label><br>
                </div>
                <div class="col-sm-6">
                  <input type="date" id="date" name="date" placeholder=<?php echo date("d/m/y"); ?> required><br><br>
                </div>
              </div>
            </div>
            <div class="col-sm-1"></div> 
          </div>
          <div class="row">
            <div class="col-sm-1"></div>  
            <div class="col-sm-10">
              <div class="row row_margin">
                <div class="col-sm-6">
                  <label for="category">Kategoria:</label><br>
                </div>
                <div class="col-sm-6">
                  <select name="category" id="category" onchange="add_new_category()" required><br><br>
                    <?php
                          while($row = $category_list->fetch_assoc()) 
                          {
                            ?>
                            <option value=<?php echo $row['expense_category'];?>><?php echo $row['expense_category'];?></option>
                            <?php
                          }
                      ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-sm-1"></div>
          </div>
          <div class="row">
            <div class="col-sm-1"></div>  
            <div class="col-sm-10">
              <div class="row end_margin">
                <div class="col-sm-6">
                  <label for="amount">komentarz:</label><br>
                </div>
                <div class="col-sm-6">
                  <input type="text" id="comment_to_add" name="additional_comment" /><br><br>
                </div>
              </div>
            </div>
            <div class="col-sm-1"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3"></div>
          <div class="col-sm-6">
            <div id="submit">
              <input class="submit_button" type="submit" value="Dodaj">
            </div>
          </div>
          <div class="col-sm-3"></div>
        </div>
      </form>
    </div>
    <div class="col-sm-3"></div>
  </div>
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
          <form id="return_field" action="Return_to_menu.php" method="post">
            <div id="return">
              <input class="submit_button" type="submit" value="Wróć do Menu">
            </div>
          </form>
        </div>
        <div class="col-sm-3"></div>
      </div>
    </div>
    <div class="col-sm-3"></div>
  </div>
</body>

</html>

