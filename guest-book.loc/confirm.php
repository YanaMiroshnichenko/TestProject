<?php
	require_once('./bd.php');
	$hash_link=$_GET['hash'];

	$query = "SELECT * FROM users WHERE `confirmation_hash`='$hash_link'";
	$result = mysqli_query($link, $query); 
	$row = mysqli_fetch_assoc($result);

	if ($row['activated']==0) {
		$reg=1;
		$query = "UPDATE `users` SET `activated`='$reg' WHERE `confirmation_hash`='$hash_link'";
		$result = mysqli_query($link, $query); 
		mysqli_close($link);
		$message_1='Регистрация прошла успешно!';
		$message_2='';
	}
	else {
		$message_2='Вы уже зарегистировались!!!';
		$message_1='';
	}
	session_start();
	$_SESSION['user_id'] = $row['id'];
	
require_once('./head.php');
?>
	<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-3 col-xs-offset-1 col-lg-4 col-md-4 col-sm-6 col-xs-10 main-blok">
		<h2 class="good_result"><?php echo $message_1 ?></h2>
		<h2 class="result_of_query"><?php echo $message_2 ?></h2>
		<h4><a href="comments.php">Вход</a></h4>
	</div>
</html>