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
					$_SESSION["pseudo"] = $_POST["username"];
					header("Location: chat.php");
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
				$_SESSION["pseudo"] = $_POST["userconnect"];
				header("Location: chat.php");
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
		<style>
			form {
				border: 1px solid black;
				box-shadow: 5px 5px 5px blue;
				margin: 0% 40% 50px 40%;
				width: 20%;
			}
			h3 {
				color: blue;
				font-weight: bold;
				text-align: center;
			}
		</style>
	</head>
	<body>
		<h3>Inscription au chat</h3>
		<form action="indextp28.php" method="POST">
			<center><input style="margin-top: 10px;" type="text" id="lastname" name="lastname" placeholder="Nom"><br/>
			<input type="text" id="firstname" name="firstname" placeholder="Prénom"><br/>
			<input type="text" id="username" name="username" placeholder="Pseudo"><br/>
			<input style="margin-bottom: 10px;" type="submit" name="submit" value="s'inscrire"></center>
		</form>
		<br/>
		<h3>Si vous êtes déjà inscrit, <br/>entrez votre pseudo ci-dessous pour accéder au chat</h3>
		<form action="indextp28.php" method="POST">
			<center><input style="margin-top: 10px;" type="test" id="userconnect" name="userconnect" placeholder="Pseudo"><br/>
			<input style="margin-bottom: 10px;" type="submit" name="submitconnect" value="accéder au chat"></center>
		</form>
	</body>
</html>
