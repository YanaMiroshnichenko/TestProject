<?php
	require_once('./bd.php');
	$arrayErrors = [];
	$first_name =  '';
	$last_name = '';
	$email = '';
	$password = '';
	$second_password = '';
	$has_errors = FALSE;
	if (isset($_POST) && !empty($_POST)) {
		$first_name = preg_replace("/\s{2,}/",' ',trim($_POST['first-name']));
		$last_name = preg_replace("/\s{2,}/",' ',trim($_POST['last-name']));
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$second_password = trim($_POST['second-password']);

		$arrayErrors['first-name'] = '';
		$arrayErrors['last-name'] = '';
		$arrayErrors['email'] = '';
		$arrayErrors['password'] = '';
		$arrayErrors['second-password'] = '';
		
		if (empty($first_name) ) {
			$arrayErrors['first-name'] = 'Введите имя!'; 
			$has_errors = TRUE;
		}

		if (empty($last_name) ) { 
			$arrayErrors['last-name'] = 'Введите фамилию!'; 
			$has_errors = TRUE;
		}

		if (empty($email) ) {
			$arrayErrors['email'] = 'Введите e-mail адрес!'; 
			$has_errors = TRUE;
		}
		if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$arrayErrors['wrong-email'] = 'Введите корректный e-mail адрес!'; 
			$has_errors = TRUE;
		}

		if (empty($password) ) {
			$arrayErrors['password'] = 'Введите пароль!'; 
			$has_errors = TRUE;
		}

		if (empty($second_password) ) {
			$arrayErrors['second-password'] = 'Введите пароль ещё раз!';
			$has_errors = TRUE;
		}
		if (!empty($second_password) && $password!=$second_password) {
			$arrayErrors['wrong-password'] = 'Пароли не совпадают!';
			$has_errors = TRUE;
		}
		if (!empty($password) && strlen($password) < 5) {
			$arrayErrors['min-password'] = 'Введите не менее 5-ти символов!';
			$has_errors = TRUE;
		}
		if (strlen($password) > 10) {
			$arrayErrors['max-password'] = 'Максимальное количество символов - 10!';
			$has_errors = TRUE;
		}
		$query = "SELECT `email` FROM users WHERE email=`$email`";
		$result = mysqli_query($link, $query);

		if (!empty($result) && !empty($email)) {
			$arrayErrors['exists-email'] = 'Такой e-mail адрес уже зарегистрирован!';
			$has_errors = TRUE;
		}
		if ($password==$second_password && $has_errors==FALSE) {
			$hash_password = md5($password);
			$hash_email = md5($email);
			$query = "INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`) VALUES 
		    							('$first_name', '$last_name', '$hash_email', '$hash_password')";
			mysqli_query($link, $query);
			mysqli_close($link);
			
			header("Location: index.php");
		}
	}
	require_once('./head.php');
?>


	<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-3 col-xs-offset-1 col-lg-4 col-md-4 col-sm-6 col-xs-10 main-blok">
		<h2>Регистрация</h2>
		<form class="form form-horizontal form-group " method="post" id="form">
			<?php 
				$has_error_class = isset($arrayErrors['first-name']) && !empty($arrayErrors['first-name']) ? 'has-error' : '';
				$has_success_class = isset($arrayErrors['first-name']) && empty($arrayErrors['first-name']) ? 'has-success' : '';
				

			?>
			<div class="form-element form-group <?php echo $has_error_class; echo $has_success_class;?>">
			 	<div class="col-sm-12">
			    	<input  class="form-control " placeholder="Имя" type="text" name="first-name" value="<?php echo $first_name; ?>">	
			    </div>
			</div>
		    <span class="result_of_query">
				<?php 
			    	if(isset($arrayErrors['first-name']) && !empty($arrayErrors['first-name'])) {
						echo $arrayErrors['first-name'];
						
					}
		    	?>
	    	</span>
	    	<?php 
				$has_error_class = isset($arrayErrors['last-name']) && !empty($arrayErrors['last-name']) ? 'has-error' : '';
				$has_success_class = isset($arrayErrors['last-name']) && empty($arrayErrors['last-name']) ? 'has-success' : '';
			?>
		   	<div class="form-element form-group <?php echo $has_error_class; echo $has_success_class; ?>">
			 	<div class="col-sm-12">
		    		<input class="form-control" placeholder="Фамилия" type="text" name="last-name" value="<?php echo $last_name; ?>">	
		    	</div>
			</div>
			<span class="result_of_query">
			    <?php 
			    	if(isset($arrayErrors['last-name']) && !empty($arrayErrors['last-name']) ){
						echo $arrayErrors['last-name'];
					}
		    	?>
	    	</span>
	    	<?php 
				$has_error_class = isset($arrayErrors['email']) && !empty($arrayErrors['email']) ? 'has-error' : '';
				$has_success_class = isset($arrayErrors['email']) && empty($arrayErrors['email']) ? 'has-success' : '';
			?>
		    <div class="form-element form-group <?php echo $has_error_class; echo $has_success_class;?>">
			 	<div class="col-sm-12">
		    		<input class="form-control" placeholder="Email" type="text" name="email" value="<?php echo $email; ?>">	
		    	</div>
			</div>
			<span class="result_of_query">
		    	<?php 
		    		if(isset($arrayErrors['email']) && !empty($arrayErrors['email']) ){
						echo $arrayErrors['email'];
						
					}
					if(isset($arrayErrors['wrong-email']) && !empty($arrayErrors['wrong-email']) ){
						echo $arrayErrors['wrong-email'];
						$has_errors = TRUE;
					}
					if(isset($arrayErrors['exists-email']) && !empty($arrayErrors['exists-email']) ){
						echo $arrayErrors['exists-email'];
						
					}
				?>
	    	</span>
	    	<?php 
				$has_error_class = isset($arrayErrors['password']) && !empty($arrayErrors['password']) ? 'has-error' : '';
				$has_success_class = isset($arrayErrors['password']) && empty($arrayErrors['password']) ? 'has-success' : '';
			?>
		    <div class="form-element form-group <?php echo $has_error_class; echo $has_success_class;?>">
			 	<div class="col-sm-12">
		    		<input class="form-control" placeholder="Пароль" type="password" name="password" value="<?php echo $password; ?>">
		    	</div>
			</div>
			<span class="result_of_query">
		    	<?php 
			    	if(isset($arrayErrors['password']) && !empty($arrayErrors['password']) ){
						echo $arrayErrors['password'];
						
					}
					if(isset($arrayErrors['min-password']) && !empty($arrayErrors['min-password']) ){
						echo $arrayErrors['min-password'];
						
					}
					if(isset($arrayErrors['max-password']) && !empty($arrayErrors['max-password']) ){
						echo $arrayErrors['max-password'];
						
					}
		    	?>
		    </span>
		    <?php 
				$has_error_class = isset($arrayErrors['second-password']) && !empty($arrayErrors['second-password']) ? 'has-error' : '';
				$has_success_class = isset($arrayErrors['second-password']) && empty($arrayErrors['second-password']) ? 'has-success' : '';
			?>
		    <div class="form-element form-group <?php echo $has_error_class; echo $has_success_class;?>">
			 	<div class="col-sm-12">
		    		<input class="form-control" placeholder="Повторный пароль" type="password" name="second-password" value="<?php echo $second_password; ?>">
		    	</div>
			</div>
			<span class="result_of_query">
		    	<?php 
			    	if(isset($arrayErrors['second-password']) && !empty($arrayErrors['second-password']) ) {
						echo $arrayErrors['second-password'];
						
					}
					if(isset($arrayErrors['wrong-password']) && !empty($arrayErrors['wrong-password']) ) {
						echo $arrayErrors['wrong-password'];
						
					}
				?>
			</span>
		    <div class="form-group form-element">
			 	<div class="col-sm-12">
		    		<button type="submit" name="submit" class="form-control button-form">Да</button>
		    	</div>
			</div>
		</form>
		<h4><a href="index.php">Назад</a></h4>
	</div>
</body>

</html>