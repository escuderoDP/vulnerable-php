<?php

	include 'db_connection.php';
	
	session_start();
	
	$post = $_SERVER['REQUEST_METHOD']=='POST';

	if ($post)
	{
		if(
			empty($_POST['uname'])||
			empty($_POST['full_name'])||
			empty($_POST['email'])||
			empty($_POST['pass'])||
			empty($_POST['repass'])
		) $empty_fields = true;

		else
		{
			$peq = $_POST['pass']==$_POST['repass'];
			$st = $pdo->prepare('SELECT * FROM users WHERE user_name=?');
			$st->execute(array($_POST['uname']));
			$uname_err = $st->fetch() != null;
			$st = $pdo->prepare('SELECT * FROM users WHERE email=?');
			$st->execute(array($_POST['email']));
			$email_err = $st->fetch() != null;
			if(!$uname_err&&!$email_err)
			{
				$stmt = 'INSERT INTO users(user_name,full_name,email,password) VALUES (?,?,?,?)';
				$pdo->prepare($stmt)->execute(array(
					$_POST['uname'],
					$_POST['full_name'],
					$_POST['email'],
					$_POST['pass']
				));
				$_SESSION["uname"] = $_POST["uname"];
				$_SESSION["pass"] = $_POST["pass"];
				$_SESSION["full_name"] = $_POST["full_name"];
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
	if(!empty($uname_err)&&$uname_err) echo "<span>Usuário já cadastrado no sistema.</span>";
	echo '<br>Nome completo<br><input type="text" name="full_name" value="'.$_POST['full_name'].'" placeholder="Nome completo"><br>';
	echo '<br>E-mail<br><input type="text" name="email" value="'.$_POST['email'].'" placeholder="email@examplo.com"><br>';
	if(!empty($email_err)&&$email_err) echo "<span>E-mail já cadastrado no sistema.</span>";
	echo '<br>Senha<br><input type="password" name="pass" placeholder="Senha"><br>';
	echo '<input type="password" name="repass" placeholder="Repita a senha">';
	if($post&&!$empty_fields&&!$peq) echo '<span>As senhas devem ser iguais</span><br>';
	if($post &&$empty_fields) echo "<br><span>Todos os campos são obrigatórios.</span><br>";
	?>
	<br>
	<input type="submit" id="submit" value="Cadastrar"><br><br>
	Já possui uma conta? <a href="index.php">LogIn</a>.<br><br>
</form>
</div>
</body>
</html>
