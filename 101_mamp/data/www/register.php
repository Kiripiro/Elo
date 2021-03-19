<?php
session_start();
require 'database.php';

if(isset($_SESSION['id'])){
  $records = $conn->prepare('SELECT * FROM Users WHERE id = :id');
  $records->bindParam(':id', $_SESSION['id']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);
}

if(!empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])){
	if ($_POST['password'] == $_POST['confirm_password'])
	{
		$sql = "INSERT INTO `Users` (`login`, `email`, `password`, `role`) VALUES (:login, :email, :password, 'user')";
		$stmt = $conn->prepare($sql);

		$stmt->bindParam(':login', $_POST['login']);
		$stmt->bindParam(':email', $_POST['email']);
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$stmt->bindParam(':password', $password);
		if ($stmt->execute()){
			$message = "Le compte a été créé";
		
			header("Location: /accueil.php");
		}
	}
	else
	{
		$message = 'Veuillez taper exactement le même mot de passe';
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Inscription</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="assets/css/style1.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
<body>
	<h1>Inscription</h1>
	<form action="register.php" method="POST">
		<div class="register">
			<input type="login" placeholder="Entrez le login" name="login">
			<input type="email" placeholder="Entrez l'email" name="email">
			<input type="password" placeholder="Entrez le mot de passe" name="password">
			<input type="password" placeholder="Confirmez le mot de passe" name="confirm_password">
			<button type="submit" class="bouton btn-sm" style="vertical-align:middle"><span>Envoyer</span></button>
			<a href="accueil.php">Accueil</a>

			<?php if(!empty($message)): ?>
			<p><?= $message ?></p>
			<?php endif; ?>

		</div>
	</form>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>