<?php
	require_once('./bd.php');
	
	$result_of_query_good = false;

	if($_POST['login'] and $_POST['password']){
		$login = $_POST['login'];
		$password = $_POST['password'];
		$query = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";
		$result = mysqli_query($link, $query); 
		mysqli_close($link);
		$row = mysqli_fetch_assoc($result);

		if(!empty($row['login'])) {
			session_start();
			$_SESSION = $row;
			header("Location: comments.php");
		}
 

	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Гостевая книга</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
   	<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css"> 
  	<script src="bootstrap/js/bootstrap.min.js"></script> 
</head>
<body>
	<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-3 col-xs-offset-1 col-lg-4 col-md-4 col-sm-6 col-xs-10 main-blok">
			<?php 
			if(!empty($login) && !empty($password) && !empty($first_name) && !empty($last_name)) {
				echo '<h4 class="result_of_query">Регистрация прошла успешно!</h4>';
			}
	
		?>
		<h2>Авторизация</h2>

		<form class="form" method="post">
			<p>
		    	<input placeholder="Логин" type="text" name="login">	
		    </p>
		    <p>
		    	<input placeholder="Пароль" type="password" name="password">
		    </p>
		    <p>
		    	<button type="submit" name="submit" class="button-form">Вход</button>
		    </p>
		</form>
		<h4><a href="registration.php">Регистрация</a></h4>
		<?php 
			if(!empty($login) && !empty($password)){
				if($result_of_query_good == false){
					echo '<h4 class="result_of_query">Неправильный ввод!</h4>';
				}
			}
			
		?>

	</div>
</html>