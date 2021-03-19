<?php
$servername = "172.18.0.2";
$username = "root";
$password = "rootpass";

try {
  $conn = new PDO("mysql:host=$servername;dbname=Elo", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>