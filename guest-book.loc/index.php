<?php
	require_once('./bd.php');
	$email = '';
	$password = '';
	$arrayName = array();
	$result_of_query_good = false;
	if(isset($_POST) && !empty($_POST)) {
		$email = $_POST['email'];
		$password = $_POST['password'];
		if (empty($_POST['email']) ) { 
			$arrayName['email'] = '<span class="result_of_query">Введите e-mail адрес!</span>'; 
		}
		if (empty($_POST['password']) ) {
			$arrayName['password'] = '<span class="result_of_query">Введите пароль!</span>'; 
		}
		$hash_password = md5($password);
		$hash_email = md5($email);
		$query = "SELECT * FROM users WHERE email = '$hash_email' AND password = '$hash_password'";
		$result = mysqli_query($link, $query); 
		mysqli_close($link);
		$row = mysqli_fetch_assoc($result);
		if (!empty($row['email'])) {
			session_start();
			$_SESSION['user_id'] = $row['id'];

			header("Location: comments.php");
		}	
		elseif (!empty($email) && !empty($password)) {
			$arrayName['wrong_data'] = '<h4 class="result_of_query">Неверный ввод!</h4>';
		}	
	}
	require_once('./head.php');
?>

	<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-3 col-xs-offset-1 col-lg-4 col-md-4 col-sm-6 col-xs-10 main-blok">
	
		<h2>Авторизация</h2>

		<form class="form form-horizontal form-group " method="post">
			<?php 
				$has_error_class = isset($arrayName['email']) && !empty($arrayName['email']) ? 'has-error' : '';
				$has_success_class = isset($arrayName['email']) && empty($arrayName['email']) ? 'has-success' : '';
			?>
		    <div class="form-element form-group <?php echo $has_error_class; echo $has_success_class;?>">
			 	<div class="col-sm-12">
		    		<input class="form-control" placeholder="Email" type="text" name="email" value="<?php echo $email; ?>">	
		    	</div>
			</div>
			<?php 
		    		if(isset($arrayName['email']) && !empty($arrayName['email']) ){
						echo $arrayName['email'];
					}
	    		?>	
		    <?php 
				$has_error_class = isset($arrayName['password']) && !empty($arrayName['password']) ? 'has-error' : '';
				$has_success_class = isset($arrayName['password']) && empty($arrayName['password']) ? 'has-success' : '';
			?>
		    <div class="form-element form-group <?php echo $has_error_class; echo $has_success_class;?>">
			 	<div class="col-sm-12">
		    		<input class="form-control" placeholder="Пароль" type="password" name="password" value="<?php echo $password; ?>">
		    	</div>
			</div>
			<?php 
		    		if(isset($arrayName['password']) && !empty($arrayName['password']) ){
						echo $arrayName['password'];
					}
	    		?>
		    <div class="form-group form-element">
			 	<div class="col-sm-12">
		    		<button type="submit" name="submit" class="form-control button-form">Вход</button>
		    	</div>
			</div>
		</form>

		<?php
			if(isset($arrayName['wrong_data']) && !empty($arrayName['wrong_data']) ) {
				echo $arrayName['wrong_data'];
			}
		?>
		<h4><a href="registration.php">Регистрация</a></h4>
	</div>
</html>