<?php

	session_start();
	
	include 'db_connection.php';

	$st = $pdo->prepare('SELECT * FROM users WHERE user_name=?');
	$st->execute(array($_SESSION["uname"]));
	if(($r=$st->fetch())==null||($r["password"]!=$_SESSION["pass"])) {
		header("Location:index.php");
		exit;
	}
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		session_destroy();
		header("Location:index.php");
		exit;
		
	}
?>

<!DOCTYPE HTML>
<html>
<head>
<style type="text/css">
	body {
		margin:0px;
		padding:0px;
		font-family: sans-serif;
		font-size:.9em;
	}
	div {
		top:50%;
		left:50%;
		transform: translate(-50%,-50%);
		-ms-transform: translate(-50%,-50%);
		-moz-transform: translate(-50%,-50%);
		-webkit-transform: translate(-50%,-50%);
		position:absolute;
		width:350px;
		background:#eee;
		padding:20px;
		border-radius: 2px;
		box-shadow:0px 0px 10px #aaa;
		box-sizing:border-box;
	}
	#submit {
		width:100%;
		display: inline-block;
		border:none;
		background-color: blue;
		color:white;
		font-size:1em;
		box-shadow: 0px 0px 3px #777;
		padding:10px 0px;
	}
	p {
		text-align: center;
		font-size: 1.75em;
	}
</style>
</head> 
<body>
<div>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<p><?php echo $_SESSION["fname"] ?>, bem vindo à página de atividades do professor Danilo.</p><br>
	<p>Você esta logado como <?php echo $_SESSION["uname"];?>.</p><br><br>
	<input type="submit" id="submit" name="submit" value="Sair">
</form>
</div>
</body>
</html>
