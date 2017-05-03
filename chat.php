<?php
	require_once ("configtp28.php");
	
	if(isset($_POST["submit"])){
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
		<title>MoonChat, the php chat!</title>
		<style>
			#chat {
				border: 1px solid black;
				box-shadow: 5px 5px 5px blue;
				height: 80%;
				margin-left: 30%;
				margin-bottom: 15px;
				oveflow: scroll;
				padding: 5px;
				width: 40%;
			}
			form {
				width: 40%;
				margin-left: 30%;
			}
			.userchat {
				color: blue;
			}
			
			.userchat, .messchat {
				display: inline-block;
			}
			
			.userchat span {
				font-weight: bold;
			}
		</style>
	</head>
	<body>
		<div id="chat">
		<?php
			$history = $PDO->query("SELECT * FROM chathistory INNER JOIN users ON users.id = chathistory.id_user");
			foreach ($history as $row){
		?>
		<div class="userchat"><?php echo $row->firstname . " " . $row-> lastname . " <span>(" . $row->username . ")</span> : ";?></div><div class="messchat"><?php echo $row->message; ?></div><br/>
		<?php } ?>
		</div>
		<form action="chat.php" method="POST">
			<center><input type="text" name="message" id="message" placeholder="Entrez votre message ici">
			<input type="submit" name="submit" value="Envoyer"></center>
		</form>
	</body>
</html>
