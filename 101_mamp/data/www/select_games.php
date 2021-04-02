<?php
session_start();
if(!isset($_SESSION['id'])){
	header("Location: /accueil.php");
}

require 'database.php';
$message = '';

$sql = "SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = 'Elo' AND TABLE_NAME NOT LIKE 'Users'";
$stmt = $conn->prepare($sql);
if ($stmt->execute()){
	$datas = $sql;
}


if (isset($_POST['Selected'])){
	if ($_POST['Selected'] != 'Sélectionner'){
		if ($_POST['login'] && $_POST['elo']){

			$sql2 = "SELECT `id` FROM `Users` WHERE `login` = '".$_POST['login']."'";
			$stmt2 = $conn->prepare($sql2);
			$stmt2->execute();
			$id_login = $stmt2->fetch(PDO::FETCH_ASSOC);

		//	$stmt2->bindParam(':login', $_POST['login']);
			if ($stmt2->execute()){
				$datas2 = $sql2;
				$sql3 = "INSERT INTO ".$_POST['Selected']." (`user_id`, `elo`) VALUES (".$id_login['id'].", :elo)";
				$stmt3 = $conn->prepare($sql3);	
				// $stmt3->bindParam(':user_id', $datas2);
				$stmt3->bindParam(':elo', $_POST['elo']);
				
				if ($stmt3->execute()){
					$message = 'Utilisateur ajouté avec succès';
				}
			}
			else
				$message = 'Veuillez remplir correctement tous les champs !';
		}
		else
			$message = 'Entrez un login valide';
	}
	else
		$message = 'Merci de sélectionner un jeu';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<?php require 'navbar.php'; ?>
<h1>Sélectionner le jeu</h1>

<form action="select_games.php" method="POST">
    <select name="Selected">
        <option selected="selected">Sélectionner</option>
        <?php
        foreach($conn->query($sql) as $row){
            echo '<option value="'.$row['TABLE_NAME'].'">'.$row['TABLE_NAME'].'</option>';
        }
        ?>
    </select>
	<input type="login" placeholder="Entrez le login" name="login">
	<select name="elo">
		<option selected="elo">Sélectionner</option>
		<option value=300>Monkey</option>
		<option value=800>Noob</option>
		<option value=1000>Average</option>
		<option value=1200>PGM(non)</option>
		<option value=1400>PGM(vrai de vrai)</option>
	</select>
    <input type="submit" value="Ok">
</form>
</body>
</html>