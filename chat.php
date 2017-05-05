<?php
	require_once ("configtp28.php");
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<title>MoonChat, the php chat!</title>
		<style>
			.censored {
				color: gray;
				font-style: italic;
			}
			#chat {
				border: 1px solid black;
				box-shadow: 5px 5px 5px blue;
				height: 400px;
				margin-left: 15%;
				margin-bottom: 15px;
				overflow-y: scroll;
				padding: 5px;
				width: 70%;
			}
			form {
				width: 40%;
				margin-left: 30%;
			}
			h1 {
				text-align: center;
			}
			img {
				width: 20px;
			}
			.userchat {
				color: blue;
			}
			
			.username {
				color: blue;
				font-weight: bold;
			}
			p {
				text-align: center;
			}
		</style>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script>
			$(function(){
				$('#chat').scrollTop($('#chat')[0].scrollHeight);
				$('#message').focus();
				$('#sendmsg').on("submit", function(q){
					q.preventDefault()
					data = {
						message: $("#sendmsg").val(),
						form: "message"
					}
					$.ajax({
						method: "POST",
						url: "ajaxtp28.php",
						data : data,
						success: function(result){
							if (result = true){
								$("#errorchat").html(result)
							} else {
								$("#errorchat").html(result)
							}
						}
					})	
				})
			})
		</script>
	</head>
	<body>
		<h1>MoonChat!</h1>
		<div id="chat">
			<?php
				function test($a){
					$history = $a->query("SELECT * FROM chathistory INNER JOIN users ON users.id = chathistory.id_user");
					foreach ($history as $row){
						$messenvoi = $row->message;
						$censure = array(
								"connard", "con", "conne", "cons", "connes", "connards",
								"pute", "putes", "putain",
								"salope", "salopes", 
								"bite", "bites", 
								"couille", "couilles",
								"encule", "enculé", "encules", "enculés", "enculée", "enculées", "enculer"
						);
						$emotes = array(
								"#cat" => "<img src='./img/cat.png' alt='cat'>",
								"#angry" => "<img src='./img/angry.png' alt='angry'>",
								"#excited" => "<img src='./img/excited.png' alt='excited'>",
								"#silly" => "<img src='./img/silly.png' alt='silly'>",
								"#love" => "<img src='./img/love.png' alt='love'>",
								"#sunglasses" => "<img src='./img/sung.png' alt='sunglasses'>",
								"#happy" => "<img src='./img/happy.png' alt='happy'>",
								"#bored" => "<img src='./img/bored.png' alt='bored'>",
								"#cry" => "<img src='./img/cry.png' alt='cry'>",
								"#surprised" => "<img src='./img/surprised.png' alt='surprised'>",
								"#death" => "<img src='./img/death.png' alt='death'>",
								"#confused" => "<img src='./img/confused.png' alt='confused'>",
								"#sad" => "<img src='./img/sad.png' alt='sad'>",
								"#laught" => "<img src='./img/laught.png' alt='laught'>",
								"#pissed" => "<img src='./img/pissed.png' alt='pissed'>",
								"#kiss" => "<img src='./img/kiss.png' alt='kiss'>"
						);
						foreach (array_keys($emotes) as $emokey){
							$messenvoi = str_replace($emokey, $emotes[$emokey], $messenvoi);
						}	
						foreach ($censure as $badword){
							$messenvoi = str_replace($badword, "<span class='censored'>*censored*</span>", $messenvoi);
						}
						echo "<div><span class='userchat'>" . $row->firstname . " " . $row->lastname . " </span><span class='username'>(" . $row->username . ")</span> > <span class='messchat'>" . $messenvoi . "</span></div>";
					}
				}
				test($PDO); ?>
		</div>
		<form action="chat.php" method="POST" id="message">
			<center><input type="text" name="message" id="sendmsg" placeholder="Entrez votre message ici">
			<input type="submit" name="submit" value="Envoyer"></center>
		</form>
		<div id="errorchat"></div>
		<p><a href="indextp28.php">Retourner à l'écran de connexion</a></p>
	</body>
</html>
