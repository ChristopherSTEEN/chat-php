<?php
	require_once ("configtp28.php");

if ($_POST["form"] == "inscription"){
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
				echo true;
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

if ($_POST["form"] == "connexion"){
	if ($_POST["userconnect"] != ""){
		$search = $PDO->prepare ("SELECT COUNT(*) AS exist FROM users WHERE username=:userconnect");
		$search->bindValue(':userconnect', $_POST["userconnect"]);
		$search->execute();
		$found = $search->fetch();
		if ($found->exist == 1){
			$_SESSION["pseudo"] = $_POST["userconnect"];
			echo true;
		} else {
			echo "Ce pseudo n'existe pas.";
		}
	} else {
		echo "Un pseudo est requis!";
	}
}

if ($_POST["form"] == "message"){
	if ($_POST["message"] != ""){
		$pseudo = $_SESSION["pseudo"];
		$verif = $PDO->prepare ("SELECT COUNT(*) AS compteur FROM users WHERE username='".$pseudo."'");
		$verif->execute();
		$exist = $verif->fetch();
		if ($exist->compteur == 1){
			$userid = $PDO->prepare ("SELECT id FROM users WHERE username='".$pseudo."'");
			$userid->execute();
			$ident = $userid->fetch();
			$message = $PDO->prepare ("INSERT INTO chathistory (id_user, message) VALUES (:id, :message)");
			$message->bindValue(':id', $ident->id);
			$message->bindValue(':message', $_POST["message"]);
			$message->execute();
			echo "help";
		} else {
			echo "Une erreur est survenue";
		}
	} else {
		echo "Veuillez entrer un message!";
	}
}
?>
