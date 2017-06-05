<?php
  session_start();
  unset($_SESSION['user']); // reset ค่าใน session
  header('location: ../index.php');
 ?>
