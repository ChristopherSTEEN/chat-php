<?php
	require_once ("configtp28.php");
	
	if(isset($_POST["submit"])){
		if ($_POST["message"] != ""){
			$pseudo = $_GET["pseudo"];
			$verif = $PDO->prepare ("SELECT COUNT(*) AS compteur FROM users WHERE username=".$pseudo);
			$verif->execute();
			$exist = $verif->fetch();
			if ($exist->compteur == 1){
				$userid = $PDO->prepare ("SELECT id FROM users WHERE username=".$pseudo);
				$userid->execute();
				$ident = $userid->fetch();
				$message = $PDO->prepare ("INSERT INTO chathistory (id_user, message) VALUES (:id, :message)");
				$message->bindValue(':id', $ident->id);
				$message->bindValue(':message', $_POST["message"]);
				$message->execute();
				echo $_POST["message"];
				echo $ident->id;
			} else {
				echo $exist->compteur;
			}
		} else {
			echo "Veuillez entrer un message!";
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
		<?php
			$history = $PDO->query("SELECT * FROM chathistory INNER JOIN users ON users.id = chathistory.id_user");
			foreach ($history as $row){
		?>
		<div id="chat"><?php echo $row->lastname . " " . $row-> firstname . " (" . $row->username . ") : " . $row->message; ?></div>
		<?php } ?>
		<form action="chat.php" method="POST">
			<input type="text" name="message" id="message" placeholder="Entrez votre message ici">
			<input type="submit" name="submit" value="Envoyer">
		</form>
	</body>
</html>
