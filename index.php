<?php

	session_start();
	include 'db_connection.php';

	$post = $_SERVER['REQUEST_METHOD']=='POST';
	if ($post) {
		if(
			empty($_POST['uname'])||
			empty($_POST['pass'])
		) $empty_fields = true;

		else
		{
			$st = $pdo->prepare('SELECT * FROM users WHERE user_name=?');
			$st->execute(array($_POST['uname']));
			$r=$st->fetch();
			if($r != null && $r["password"]==$_POST['pass'])
			{
				echo $_POST["uname"];
				echo $_POST["pass"];
				$_SESSION["uname"] = $_POST["uname"];
				$_SESSION["pass"] = $_POST["pass"];
				$_SESSION["fname"] = $r["first_name"];
				echo $_SESSION["uname"];
				echo $_SESSION["pass"];
				header("Location:success.php");
				exit;
			} else $login_err = true;
		}
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
	<p>Login</p>
	<?php 
	echo 'Usuário<br><input type="text" name="uname" value="'.$_POST['uname'].'" placeholder="Usuário"><br>';
	echo '<br>Senha<br><input type="password" name="pass" value="'.$_POST['pass'].'" placeholder="Senha"><br>';
	if(!empty($login_err)&&$login_err) echo "<span>Usuário e/ou senha incorretos.</span>";
	if(!empty($empty_fields)&&$empty_fields) echo "<span>Digite um usuário e uma senha.</span>";
	?>
	<br>
	<input type="submit" id="submit" value="Login"><br><br>
	Não tem uma conta? <a href="signup.php">Cadastre-se</a>.<br><br>
</form>
</div>
</body>
</html>
