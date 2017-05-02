<?php
	require_once ("configtp28.php");
	$form = true;
	
	if(isset($_POST["submit"])){
		if ($_POST["lastname"] != "" && $_POST["firstname"] != "" && $_POST["username"] != ""){
			$test = $PDO->prepare ("SELECT COUNT(*) AS compteur FROM users WHERE username=:username");
			$test->bindValue(':username', $_POST["username"]);
			$test->execute();
			$result = $test->fetch();
			if ($result->compteur == 0){
				$req = $PDO->prepare ("INSERT INTO users (firstname, lastname, username) VALUES (:firstname, :lastname, :username)");
				$req->bindValue(':firstname', $_POST["firstname"]);
				$req->bindValue(':lastname', $_POST["lastname"]);
				$req->bindValue(':username', $_POST["username"]);
				if($req->execute()){
					header("Location: chat.php?pseudo=".$_POST["username"]);
				} else {
					echo "Une erreur est survenue";
				}
			} else {
				echo "Ce pseudo existe déjà";
			}
		} else {
			echo "Tous les champs sont obligatoires";
		}
	}
	
	if(isset($_POST["submitconnect"])){
		if ($_POST["userconnect"] != ""){
			$search = $PDO->prepare ("SELECT COUNT(*) AS exist FROM users WHERE username=:userconnect");
			$search->bindValue(':userconnect', $_POST["userconnect"]);
			$search->execute();
			$found = $search->fetch();
			if ($found->exist == 1){
				header("Location: chat.php?pseudo=".$_POST["userconnect"]);
			} else {
				echo "Ce pseudo n'existe pas.";
			}
		} else {
			echo "Un pseudo est requis!";
		}
	}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<title>Inscription</title>
	</head>
	<body>
		<div>Inscription au chat</div>
		<form action="indextp28.php" method="POST">
			<input type="text" id="lastname" name="lastname" placeholder="Nom"><br/>
			<input type="text" id="firstname" name="firstname" placeholder="Prénom"><br/>
			<input type="text" id="username" name="username" placeholder="Pseudo"><br/>
			<input type="submit" name="submit" value="s'inscrire">
		</form>
		<br/>
		<div>Si vous êtes déjà inscrit, entrez votre pseudo ci-dessous pour accéder au chat</div>
		<form action="indextp28.php" method="POST">
			<input type="test" id="userconnect" name="userconnect" placeholder="Pseudo">
			<input type="submit" name="submitconnect" value="accéder au chat">
		</form>
	</body>
</html>
