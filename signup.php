<?php

	include 'db_connection.php';
	
	session_start();
	
	$post = $_SERVER['REQUEST_METHOD']=='POST';

	if ($post) {
		if(
			empty($_POST['uname'])||
			empty($_POST['fname'])||
			empty($_POST['lname'])||
			empty($_POST['email'])||
			empty($_POST['pass'])||
			empty($_POST['repass'])
		) $empty_fields = true;

		else {
				$st = $pdo->prepare('SELECT * FROM users WHERE user_name=?');
				$st->execute(array($_POST['uname']));
				$uname_err = $st->fetch() != null;
				$st = $pdo->prepare('SELECT * FROM users WHERE email=?');
				$st->execute(array($_POST['email']));
				$email_err = $st->fetch() != null;
				if(!$uname_err&&!$email_err) {
					$stmt = 'INSERT INTO users(user_name,first_name,last_name,email,password) VALUES (?,?,?,?,?)';
					$pdo->prepare($stmt)->execute(array(
						$_POST['uname'],
						$_POST['fname'],
						$_POST['lname'],
						$_POST['email'],
						$_POST['pass']
					));
					$_SESSION["uname"] = $_POST["uname"];
					$_SESSION["pass"] = $_POST["pass"];
					$_SESSION["fname"] = $_POST["fname"];
					header("Location:success.php");
					exit;
			}
		}
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
		padding:10px 20px;
		border-radius: 2px;
		box-shadow:0px 0px 10px #aaa;
		box-sizing:border-box;
	}
	input {
		display: inline-block;
		border: none;
		width:100%;
		border-radius:2px;
		margin:5px 0px;
		padding:7px;
		box-sizing: border-box;
		box-shadow: 0px 0px 2px #ccc;
	}
	#submit {
		border:none;
		background-color: blue;
		color:white;
		font-size:1em;
		box-shadow: 0px 0px 3px #777;
		padding:10px 0px;
	}
	span {
		color:red;
		font-size: 0.75em;
	}
	p {
		text-align: center;
		font-size: 1.75em;
	}
	a {
		text-decoration: none;
		color:blue;
		font-weight: bold;
	}
</style>
</head> 
<body>
<div>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<p>Cadastrar</p>
	<?php
	echo 'Usuário<br><input type="text" name="uname" value="'.$_POST['uname'].'" placeholder="Usuário"><br>';
	echo '<br>Nome<br><input type="text" name="fname" value="'.$_POST['fname'].'" placeholder="Primeiro nome"><br>';
	echo '<input type="text" name="lname" value="'.$_POST['lname'].'" placeholder="Último nome"><br>';
	echo '<br>E-mail<br><input type="text" name="email" value="'.$_POST['email'].'" placeholder="email@examplo.com"><br>';
	echo '<br>Senha<br><input type="password" name="pass" placeholder="Senha"><br>';
	echo '<input type="password" name="repass" placeholder="Repita a senha">';
	?>
	<br>
	<input type="submit" id="submit" value="Cadastrar"><br><br>
	Já possui uma conta? <a href="index.php">LogIn</a>.<br><br>
</form>
</div>
</body>
</html>
