<?php
  session_start();
  require "connection.php";

  if (isset($_SESSION['created'])) {
    clearData();
    session_unset();
  }

  function clearData() {
    $conn = connection();
    $sql = "DELETE FROM tbl_even;";

    if ($conn->query($sql)) {
      // success

      // header("refresh: 0");
      // exit;
    } else {
      die("Error in deleting the tbl-even. " . $conn->error);
    }

    $sql = "DELETE FROM tbl_odd;";

    if ($conn->query($sql)) {
      // header("refresh: 0");
      // exit;
    } else {
      die("Error in deleting the tbl-odd. " . $conn->error);
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
  
  <title>Index</title>
</head>
<body>
  <div class="container mt-5">
    <div class="row m-0">
      <div class="card w-75 mx-auto px-0">
        <div class="card-body text-center">
          <div class="h4">
            Click the button to generate 10 random numbers from 1-100.
          </div>
          <div class="text-success fst-italic">
            The even numbers generated will be saved to the table named <span class="fw-bold">tbl-even</span>. The odd numbers generated will be saved to the table named <span class="fw-bold">tbl-odd</span>.
          </div>
        </div>
        <div class="card-footer text-center">
          <form action="display.php" method="post">
            <button type="submit" name="btn_submit"
              class="btn btn-primary w-50">Click Me!</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>
</html>