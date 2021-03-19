<?php
session_start();
if(isset($_SESSION['id'])){
	header("Location: /accueil.php");
}
require 'database.php';
if(!empty($_POST['email']) && !empty($_POST['password'])):
	$records = $conn->prepare('SELECT * FROM Users WHERE email = :email');
	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);
	$message = '';
	if(isset($results) > 0 && password_verify($_POST['password'], $results['password'])){
		echo $_POST['password'];
		echo $results['password'];
		$_SESSION['id'] = $results['id'];
		header("Location: /accueil.php");
	} else {
		$message = 'Désolé, ces informations d\'identification ne correspondent pas';
	}
endif;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Se connecter</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="assets/css/style1.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>
	<h1>Se connecter</h1>
	<form action="index.php" method="POST">
		<div class="login">
			<input type="email" placeholder="Entrez votre email" name="email">
			<input type="password" placeholder="Entrez votre mot de passe" name="password">
		</div>
		<button type="submit" clss="bouton" style="vertical-aalign:middle"><span>Go </span></button>
		<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>
	</form>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>