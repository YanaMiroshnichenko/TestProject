<?php
	require_once('./bd.php');
	
	if($_POST['first-name'] and $_POST['last-name'] and $_POST['login'] and $_POST['password']){
	    $first_name = $_POST['first-name'];
	    $last_name = $_POST['last-name'];
		$login = $_POST['login'];
		$password = $_POST['password'];
	$query = "INSERT INTO `users`(`first_name`, `last_name`, `login`, `password`) VALUES 
	    							('$first_name','$last_name','$login','$password')";
	    							
		mysqli_query($link, $query);
		mysqli_close($link);
		header("Location: index.php");

	    } 
	   
	    

?>

<!DOCTYPE html>
<html>
<head>
	<title>Регистрация</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
   	<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
  	<script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-3 col-xs-offset-1 col-lg-4 col-md-4 col-sm-6 col-xs-10 main-blok">
		<h2>Регистрация</h2>
		<form class="form" method="post">
			<p>
		    	<input placeholder="Имя" type="text" name="first-name">	
		    </p>
		    <p>
		    	<input placeholder="Фамилия" type="text" name="last-name">	
		    </p>
			<p>
		    	<input placeholder="Логин" type="text" name="login">	
		    </p>
		    <p>
		    	<input placeholder="Пароль" type="password" name="password">
		    </p>
		    <!-- <p>
		    	<input placeholder="Повторный пароль" type="password" name="second-password">
		    </p> -->
		    <p>
		    	<button type="submit" name="submit" class="button-form">Да</button>
		    </p>
		    
		    
		</form>
		
		<h4><a href="index.php">Назад</a></h4>
	</div>
</html>

