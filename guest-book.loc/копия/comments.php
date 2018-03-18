<?php
	session_start();
	require_once('./bd.php');


if($_POST['comment']){
	    $user_first_name = $_SESSION['first_name'];
	    $user_last_name = $_SESSION['last_name'];
	    $comment = $_POST['comment'];
	    $query = "INSERT INTO `comments`(`user_comment`, `user_first_name`, `user_last_name`) VALUES ('$comment', '$user_first_name', '$user_last_name')";
		mysqli_query($link, $query);
		}

		$query = "SELECT * FROM comments ORDER BY ID DESC";

		$result=mysqli_query($link, $query);
		
	
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
	<h4 class="out"><a href="index.php">Выход</a></h4>
	<div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-1 col-xs-offset-1 col-lg-8 col-md-8 col-sm-10 col-xs-10 comment-blok">
		<h2>Гостевая книга</h2>
		<form class="form" method="post">
			<p class="form-textarea">
				<textarea type="text" placeholder="Введите ваш комментарий" rows="3" name="comment"></textarea>
			</p>
		    <p class="form-textarea">
		    	<button type="submit" name="submit" class="button-form">Опубликовать</button>
		    </p>   
		</form>
		
		<div class="comments">
			<?php 
							
			while ( $row = mysqli_fetch_assoc($result)) {
			    echo '<div class="comment">
					<h5><b>' . $row['user_first_name']  . " " . $row['user_last_name'] . '</b> <i>' . $row['datetime']  . '</i></h5>
					<span>' . $row['user_comment'] . '</span>
					</div>';
				} 
				mysqli_close($link);
    		?>

		</div>
	</div>
</html>