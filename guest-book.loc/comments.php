<?php
	session_start();
	require_once('./bd.php');
	if (empty($_SESSION)) {
		header("Location: error.php");
	}
	
	$arrayName = array();
	if (isset($_POST) && !empty($_POST)) {
		$user_id = $_SESSION['user_id'];
		$comment =  preg_replace("/\s{2,}/",' ',trim($_POST['comment']));
		if (empty($comment) ) {
			$arrayName['comment'] = '<span class="result_of_query">Данное поле должно быть заполнено!</span>'; 
		}
		else {
			$query = "INSERT INTO `comments` (`user_id`, `user_comment`) VALUES ('$user_id', '$comment')";
			mysqli_query($link, $query);
		}
	}
	$query = "SELECT * FROM comments INNER JOIN users ON comments.user_id=users.id ORDER BY comments.datetime DESC";
	$result = mysqli_query($link, $query);
	require_once('./head.php');
?>

	
	<h4 class="out"><a href="out.php">Выход</a></h4>
	<div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-1 col-xs-offset-1 col-lg-8 col-md-8 col-sm-10 col-xs-10 comment-blok">
		<h2>Гостевая книга</h2>
		<form class="form" method="post">
			<p class="form-textarea">
				<textarea type="text" placeholder="Введите ваш комментарий" rows="3" name="comment"></textarea>
				<?php if(isset($arrayName['comment']) && !empty($arrayName['comment'])   ) {
						echo $arrayName['comment'];
					}
	    		?>
			</p>
		    <p class="form-textarea">
		    	<button type="submit" name="submit" class="button-form">Опубликовать</button>
		    </p>   
		</form>
		
		<div class="comments">
			<?php 			
				while ( $row = mysqli_fetch_assoc($result)) {
				    echo '<div class="comment">
						<h5><b>' . $row['first_name']  . " " . $row['last_name'] . '</b> <i>' . $row['datetime']  . '</i></h5>
						<span>' . $row['user_comment'] . '</span>
						</div>';
				} 
				mysqli_close($link);
    		?>
		</div>
	</div>
</html>
