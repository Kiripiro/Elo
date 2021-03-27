<?php
session_start();
if(!isset($_SESSION['id'])){
	header("Location: /index.php");
}

require 'database.php';
require 'navbar.php';

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
		}
	}
	else
	{
		$message = 'Veuillez taper exactement le même mot de passe';
	}
}

if(!empty($_POST['actual_login'])){
	if (!empty($_POST['update_login'])){
		$sql = "UPDATE `Users` SET `login` = :update_login WHERE `Users`.`login` = :actual_login";
		$stmt = $conn->prepare($sql);

		$stmt->bindParam(':actual_login', $_POST['actual_login']);
		$stmt->bindParam(':update_login', $_POST['update_login']);
		if ($stmt->execute()){
			$message1= 'Le login a été mis à jour.';
		}
	}
	else
	{
		$message1= '';
	}
	if (!empty($_POST['update_email'])){
		$sql = "UPDATE `Users` SET `email` = :update_email WHERE `Users`.`login` = :actual_login";
		$stmt = $conn->prepare($sql);

		$stmt->bindParam(':actual_login', $_POST['actual_login']);
		$stmt->bindParam(':update_email', $_POST['update_email']);
		if ($stmt->execute()){
			$message1= 'L\'email a été mis à jour.';
		}
	}
	else
	{
		$message1= '';
	}
	if (!empty($_POST['update_password']) && (!empty($_POST['update_confirm_password']))){
		if ($_POST['update_password'] == $_POST['update_confirm_password'])
		{
			$sql = "UPDATE `Users` SET `password` = :update_password WHERE `Users`.`login` = :actual_login";
			$stmt = $conn->prepare($sql);

			$stmt->bindParam(':actual_login', $_POST['actual_login']);
			$password = password_hash($_POST['update_password'], PASSWORD_BCRYPT);
			$stmt->bindParam(':update_password', $password);
			if ($stmt->execute()){
				$message1= 'Le mot de passe a été mis à jour.';
			}
		}
		else
		{
			$message1= 'Veuillez entrez exactement le même mot de passe.';
		}
	}	
}

if (!empty($_POST['dead_login']) && !empty($_POST['confirm_dead_login'])){
	if ($_POST['dead_login'] == $_POST['confirm_dead_login'])
	{
		$sql = "DELETE FROM `Users` WHERE `Users`.`login` = :dead_login";
		$stmt = $conn->prepare($sql);

		$stmt->bindParam(':dead_login', $_POST['dead_login']);
		if ($stmt->execute()){
			$message2 = 'L\'utilisateur a bien été supprimé.'; 
		}
	}
	else
	{
		$message2 = 'Un problème est survenu, veuillez réessayer.';
	}
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<h1>Ajouter un nouvel utilisateur</h1>
	<form action="players.php" method="POST">
		<div class="register">
			<input type="login" placeholder="Entrez le login" name="login">
			<input type="email" placeholder="Entrez l'email" name="email">
			<input type="password" placeholder="Entrez le mot de passe" name="password">
			<input type="password" placeholder="Confirmez le mot de passe" name="confirm_password">
			<button type="submit" class="bouton btn-sm" style="vertical-align:middle"><span>Ajouter</span></button>
			<?php if(!empty($message)): ?>
			<p><?= $message ?></p>
			<?php endif; ?>
		</div>
	</form>

<h1>Modifier un utilisateur</h1>
<form action="players.php" method="POST">
		<div class="update">
			<input type="login" placeholder="Entrez le login de l'utilisateur" name="actual_login">
			<input type="login" placeholder="Entrez le nouveau login" name="update_login">
			<input type="email" placeholder="Entrez le nouvel email" name="update_email">
			<input type="password" placeholder="Entrez le nouveau mot de passe" name="update_password">
			<input type="password" placeholder="Confirmez le nouveau mot de passe" name="update_confirm_password">
			<button type="submit" class="bouton btn-sm" style="vertical-align:middle"><span>Modifier</span></button>
			<?php if(!empty($message1)): ?>
			<p><?= $message1 ?></p>
			<?php endif; ?>
		</div>
	</form>

<h1>Supprimer un utilisateur</h1>
<form action="players.php" method="POST">
		<div class="delete">
			<input type="login" placeholder="Entrez le login de l'utilisateur à supprimer" name="dead_login">
			<input type="login" placeholder="Confirmer le login de l'utilisateur à supprimer" name="confirm_dead_login">
			<button type="submit" class="bouton btn-sm" style="vertical-align:middle"><span>Supprimer</span></button>
			<?php if(!empty($message2)): ?>
			<p><?= $message2 ?></p>
			<?php endif; ?>
		</div>
	</form>

</body>
</html>