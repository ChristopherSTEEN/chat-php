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
	if ($_POST["username"] != ""){
		$search = $PDO->prepare ("SELECT COUNT(*) AS exist FROM users WHERE username=:userconnect");
		$search->bindValue(':userconnect', $_POST["username"]);
		$search->execute();
		$found = $search->fetch();
		if ($found->exist == 1){
			$_SESSION["pseudo"] = $_POST["username"];
			echo true;
		} else {
			echo "Ce pseudo n'existe pas.";
		}
	} else {
		echo "Un pseudo est requis!";
	}
}

if ($_POST["form"] == "message"){
	if ($_POST["msgchat"] != ""){
		if ($_POST["msgchat"] == "!reset"){
			$adminpseudo = $_SESSION["pseudo"];
			$admin = $PDO->prepare ("SELECT admin FROM users WHERE username=:useradmin");
			$admin->bindValue(':useradmin', $adminpseudo);
			$admin->execute();
			$verifadmin = $admin->fetch();
			if ($verifadmin->admin == "1"){
				$delete = $PDO->prepare ("DELETE FROM chathistory");
				$delete->execute();
				$resetmsg = "<span class='censored'>Le chat a été réinitialisé par un administrateur #cat</span>";
				$userid = $PDO->prepare ("SELECT id FROM users WHERE username='".$adminpseudo."'");
				$userid->execute();
				$ident = $userid->fetch();
				$message = $PDO->prepare ("INSERT INTO chathistory (id_user, message) VALUES (:id, :message)");
				$message->bindValue(':id', $ident->id);
				$message->bindValue(':message', $resetmsg);
				$message->execute();
			} else {
				echo "Une erreur est survenue";
			}
		} else {
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
				$message->bindValue(':message', $_POST["msgchat"]);
				$message->execute();
			} else {
				echo "Une erreur est survenue";
			}
		}
	} else {
		echo "Veuillez entrer un message!";
	}
}
?>
