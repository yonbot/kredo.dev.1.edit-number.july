<?php
  session_start();
  require "connection.php";

  if (isset($_POST['btn_submit'])) {
    createData();
    $_SESSION['created'] = true;
  }

  /** 
   * Insert 10 numbers
   */
  function createData() {
    $conn = connection();

    for ($i = 1; $i <= 10; $i++) {
      $num = rand(1, 100);
      $sql = "";

      if ($num % 2 == 0) {
        $sql = "INSERT INTO tbl_even (`even_num`) VALUES($num)";
      } else {
        $sql = "INSERT INTO tbl_odd (`odd_num`) VALUES($num)";
      }
      
      if ($conn->query($sql)) {
        // success
      } else {
        die("Error in inserting the tbl. " . $conn->error);
      }
    }
  }

  function getEvenData() {
    $conn = connection();
    $sql = "SELECT * FROM tbl_even";

    if ($result = $conn->query($sql)) {
      return $result;
    } else {
      die("Error in retrieving tbl_even " . $conn->error);
    }
  }

  function getOddData() {
    $conn = connection();
    $sql = "SELECT * FROM tbl_odd";

    if ($result = $conn->query($sql)) {
      return $result;
    } else {
      die("Error in retrieving tbl_odd " . $conn->error);
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
  
  <title>Display</title>
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col h4 text-start bg-dark text-white" style="height: 60px; line-height: 60px;">
        The numbers generated are:
      </div>
    </div>
    <div class="row mt-3">
      <div class="col">
        <div class="h5 fw-bold text-center">
          Even Table(tbl-even)
        </div>
        <table class="table table-hover table-sm w-50 mx-auto">
          <tbody class="text-center">
            <?php
              $evenDatas = getEvenData();
              $evenTotal = 0;
              while ($even = $evenDatas->fetch_assoc()) {
                $evenTotal += $even['even_num'];
            ?>
              <tr>
                <td>
                  <?=$even['even_num']?>
                </td>
                <td>
                  <a href="edit-number.php?id=<?=$even['id']?>&type=even" 
                    class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-pencil"></i></a>
                  <a href="remove-number.php?id=<?=$even['id']?>&type=even" 
                    class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                </td>
              </tr>
            <?php
              }
            ?>
          </tbody>
        </table>
        <div class="text-center text-success fw-bold">
          The sum of all EVEN numbers in the tbl-even table is <?=$evenTotal?>.
        </div>
      </div>
      <div class="col">
        <div class="h5 fw-bold text-center">
          Odd Table(tbl-odd)
        </div>
        <table class="table table-hover table-sm w-50 mx-auto">
          <tbody class="text-center">
            <?php
              $oddDatas = getOddData();
              $oddTotal = 0;
              while ($odd = $oddDatas->fetch_assoc()) {
                $oddTotal += $odd['odd_num'];
            ?>
              <tr>
                <td>
                  <?=$odd['odd_num']?>
                </td>
                <td>
                  <a href="edit-number.php?id=<?=$odd['id']?>&type=odd" 
                    class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-pencil"></i></a>
                  <a href="remove-number.php?id=<?=$odd['id']?>&type=odd" 
                    class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                </td>
              </tr>
            <?php
              }
            ?>
          </tbody>
        </table>
        <div class="text-center text-success fw-bold">
          The sum of all ODD numbers in the tbl-odd table is <?=$oddTotal?>.
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>
</html>