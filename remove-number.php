<?php
  require "connection.php";

  if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];

    $conn = connection();
    $sql = "";

    if ($type == 'even') {
      $sql = "DELETE FROM tbl_even WHERE id = $id";
    } else {
      $sql = "DELETE FROM tbl_odd WHERE id = $id";
    }

    if ($conn->query($sql)) {
      if (isEvenEmpty() && isOddEmpty()) {
        header("location: index.php");
      } else {
        header("location: display.php");
      }
      exit;
    } else {
      die("Error in deleting the tbl. " . $conn->error);
    }
  }

  function isEvenEmpty() {
    $conn = connection();
    $sql = "SELECT count(*) AS even_count FROM tbl_even";

    if ($result = $conn->query($sql)) {
      if ($result->num_rows == 1) {
        $record = $result->fetch_assoc();
        if ($record['even_count'] == 0) {
          return true;
        }
      } else {
        echo "There are multiple data." . $result->num_rows;
      }
    } else {
      die("Error in retrieving tbl_even " . $conn->error);
    }

    return false;
  }

  function isOddEmpty() {
    $conn = connection();
    $sql = "SELECT count(*) AS odd_count FROM tbl_odd";

    if ($result = $conn->query($sql)) {
      if ($result->num_rows == 1) {
        $record = $result->fetch_assoc();
        if ($record['odd_count'] == 0) {
          return true;
        }
      } else {
        echo "There are multiple data." . $result->num_rows;
      }
    } else {
      die("Error in retrieving tbl_odd " . $conn->error);
    }

    return false;
  }
?>