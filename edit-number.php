<?php
  require "connection.php";

  if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];

    $recode = getRecord($id, $type);
  }

  function getRecord($id, $type) {
    $conn = connection();
    $sql = "";

    if ($type == 'even') {
      $sql = "SELECT even_num AS org_num FROM tbl_even WHERE id = $id";
    } else {
      $sql = "SELECT odd_num AS org_num FROM tbl_odd WHERE id = $id";
    }

    if ($result = $conn->query($sql)) {
      if ($result->num_rows == 1) {
        $record = $result->fetch_assoc();
        return $record;
      } else {
        echo "There are multiple data." . $result->num_rows;
      }
    } else {
      echo "Error in retrieving the tbl " . $conn->error;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <title>Edit</title>
</head>
<body>
  <div class="container mt-5">
    <div class="card w-50 mx-auto my-auto px-0">
      <div class="card-header text-center fw-bold">
        Enter in the textbox the new number that you want to save to the table
      </div>
      <div class="card-body">
        <form action="" method="post">
          <input type="number" name="number" id="number"
            class="form-control" value="<?=$recode['org_num']?>"
            autofocus required>
          <button type="submit" name="btn_edit"
            class="btn btn-info w-100 mt-3">Change</button>
        </form>
      </div>

      <?php
        if (isset($_POST['btn_edit'])) {
          $num = $_POST['number'];
          $message = checkNumber($num, $type);

          if ($message == 'Valid') {
            updateNumber($num, $id, $type);
          } else {
            displayErrorMessage($message);
          }
        }

        function checkNumber($num, $type) {
          if ($num < 1 || $num > 100) {
            return "New number entered is not within 1-100.";
          }

          if ($type == 'even' && $num % 2 != 0) {
            return "New number entered is not EVEN like the previous number.";
          }

          if ($type == 'odd' && $num % 2 == 0) {
            return "New number entered is not ODD like the previous number.";
          }

          return "Valid";
        }

        function updateNumber($num, $id, $type) {
          $conn = connection();
          $sql = "";

          if ($type == 'even') {
            $sql = "UPDATE tbl_even SET even_num = $num WHERE id = $id";
          } else {
            $sql = "UPDATE tbl_odd SET odd_num = $num WHERE id = $id";
          }

          if ($conn->query($sql)) {
            header("location: display.php");
            exit;
          } else {
            die("Error in updating the tbl_odd. " . $conn->error);
          }
        }

        function displayErrorMessage($message) {
          echo <<<EOM
            <div class="card-footer text-danger text-center">
              $message
            </div>
          EOM;
        }
      ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>
</html>