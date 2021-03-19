<!DOCTYPE html>
<html lang="fr">
	<head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
<body>
<?php 
session_start();
if(!isset($_SESSION['id'])){
	header("Location: /index.php");
}
require 'database.php';
require 'navbar.php';

$sql = 'SELECT * FROM Chess ORDER BY id';
foreach ($conn->query($sql) as $row) {
	echo $row['id'] . "\t";
	echo $row['login'] . "\t";
	echo $row['elo'] . "\n";
}
?>
<h1> Oui Bonjour ceci est un titre </h1>
</body>
</html>