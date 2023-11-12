<?php

  //include 'connect_test_db.php';
  include('Get_income.php');
  include('Get_expense.php');
?>
<!DOCTYPE html>
<html lang='pl'></html>
<html>
<head>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx' crossorigin='anonymous'>
	<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa' crossorigin='anonymous'></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['corechart']}]}"></script>
  <script>
      google.charts.load('current', { packages: ['corechart'] });
			//google.charts.load.setOnLoadCallback(drawChart);
  </script>
  <script type="text/javascript"></script>
<link rel='stylesheet' href='styles/styles.css' type='text/css'/>
<script src='scripts/Table_transformation_js.js'></script>
</head>
<body>
  <div id='myModal' class='modal'>
    <div class='modal-content'>
      <span class='close' onclick='close_modal()'>&times;</span>
      <p>Podaj szukany okres: </p>
      <form class='form_modal'>
        <label for='start_date'>Data poczatkowa:</label><br>
        <input class='input_modal' type='date' id='start_date' name='date' placeholder=<?php echo date("d/m/y"); ?> required><br><br>
        <label for='end_date'>Data koncowa:</label><br>
        <input class='input_modal' type='date' id='end_date' name='date' placeholder=<?php echo date("d/m/y"); ?> required><br><br>
        <div id='submit'><input class='submit_button' type='submit' onclick='filter_by_own_timeframe(event)' value='Submit'></div>
      </form>
    </div>
  </div>
  <form class='corner_button' action='Return_to_menu.php' method='post'>
    <input class='submit_button' type='submit' value='Wróć do Menu'>
  </form>
  <div class='select_field select_field_common'>
    <label for='period'>Wybierz zakres:</label>
    <select name='period' id='period' onchange='transform_table()'>
      <option selected value disabeled></option>
      <option value='biezacy_miesiac'>Bieżący miesiąc</option>
      <option value='poprzedni_miesiac'>Poprzedni miesiąc</option>
      <option value='biezacy_rok'>Bieżacy rok</option>
      <option value='cala_historia'>Cała historia</option>
      <option value='niestandardowy'>Niestandardowy</option>
    </select>
  </div>
  <div class='tables'>
    <div class='container'>
      <div class='row'>
        <div class='col-sm-6'>
          <table class='container my_border' id='income_table'>
            <tbody class='my_border'>
              <tr class='row'>
                <th class='col-sm-3'>Kategorie Przychodow</th>
                <th class='col-sm-3'>Kwoty</th>
                <th class='col-sm-3'>Daty</th>
                <th class='col-sm-3'>Komentarz</th>
              </tr>
              <?php
                  while($row = $income_result->fetch_assoc()) 
                  {
                    ?>
                      <tr class='row row_of_review'>
                        <td class='col-sm-3'><?php echo $row['category'];?></td>
                        <td class='col-sm-3'><?php echo $row['amount'];?></td>
                        <td class='col-sm-3'><?php echo $row['payment_date'];?></td>
                        <td class='col-sm-3'><?php echo $row['additional_comment'];?></td>
                      </tr>
                      <?php
                  }
              ?>
            </tbody>
          </table>
          <div id="income_chart" style="width:80%;"></div>
        </div>
        <div class='col-sm-6'>
          <table class='container' id='expense_table'>
            <tbody class='my_border'>
              <tr class='row'>
                <th class='col-sm-3'>Kategorie Wydatkow</th>
                <th class='col-sm-2'>Kwoty</th>
                <th class='col-sm-2'>Daty</th>
                <th class='col-sm-2'>Sposob platnosci</th>
                <th class='col-sm-3'>Komentarz</th>
              </tr>
              <?php
                while($row = $expense_result->fetch_assoc()) 
                {
                  ?>
                    <tr class='row row_of_review'>
                      <td class='col-sm-3'><?php echo $row['category'];?></td>
                      <td class='col-sm-2'><?php echo $row['amount'];?></td>
                      <td class='col-sm-2'><?php echo $row['payment_date'];?></td>
                      <td class='col-sm-2'><?php echo $row['payment_method'];?></td>
                      <td class='col-sm-3'><?php echo $row['additional_comment'];?></td>
                    </tr>
                  <?php
                }
              ?>
            </tbody>
          </table>
          <div id="expense_chart" style="width:80%;"></div>
        </div>
      </div>
    </div>
  </div>
</body>