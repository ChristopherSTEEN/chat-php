<?php
	require_once ("configtp28.php");
	unset($_SESSION["pseudo"]);
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
				margin: 0px 0px 50px 35%;
				width: 30%;
			}
			h3 {
				color: blue;
				font-weight: bold;
				text-align: center;
			}
		</style>
		<script>
			$(function(){
				$("#inscript").on("submit", function(q){
					q.preventDefault()
					data = {
						firstname: $("#firstname").val(),
						lastname: $("#lastname").val(),
						username: $("#username").val(),
						form: "inscription"
					}
					$.ajax({
						method: "POST",
						url: "ajaxtp28.php",
						data : data,
						success: function(result){
							if (result = true){
								window.location.href = "./chat.php"
							} else {
								$("#errormsg").html(result)
							}
						}
					})	
				})
				$("#connect").on("submit", function(q){
					q.preventDefault()
					data = {
						username: $("#userconnect").val(),
						form: "connexion"
					}
					$.ajax({
						method: "POST",
						url: "ajaxtp28.php",
						data : data,
						success: function(result){
							if (result = true){
								window.location.href = "./chat.php"
							} else {
								$("#errormsg").html(result)
							}
						}
					})
				})
			})
		</script>
	</head>
	<body>
		<h3>Inscription au chat</h3>
		<form action="indextp28.php" method="POST" id="inscript">
			<center><input style="margin-top: 10px;" type="text" id="lastname" name="lastname" placeholder="Nom"><br/>
			<input type="text" id="firstname" name="firstname" placeholder="Prénom"><br/>
			<input type="text" id="username" name="username" placeholder="Pseudo"><br/>
			<input style="margin-bottom: 10px;" type="submit" name="submit" value="s'inscrire"></center>
		</form>
		<br/>
		<h3>Si vous êtes déjà inscrit, <br/>entrez votre pseudo ci-dessous pour accéder au chat</h3>
		<form action="indextp28.php" method="POST" id="connect">
			<center><input style="margin-top: 10px;" type="test" id="userconnect" name="userconnect" placeholder="Pseudo"><br/>
			<input style="margin-bottom: 10px;" type="submit" name="submitconnect" value="accéder au chat"></center>
		</form>
		<div id="errormsg"></div>
	</body>
</html>
