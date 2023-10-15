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
<link rel="stylesheet" href="style.css">
</head> 
<body>
<div>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<p><?php echo $_SESSION["full_name"] ?>, bem vindo à página de atividades do professor Danilo.</p><br>
	<p>Você esta logado como <?php echo $_SESSION["uname"];?>.</p><br><br>
	<input type="submit" id="submit" name="submit" value="Sair">
</form>
</div>
</body>
</html>
