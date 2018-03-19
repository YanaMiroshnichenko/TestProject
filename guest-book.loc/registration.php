<?php
	require_once('./bd.php');
	$arrayName = [];
	$first_name =  '';
	$last_name = '';
	$email = '';
	$password = '';
	$second_password = '';
	
	if (isset($_POST) && !empty($_POST)) {
		$first_name = preg_replace("/\s{2,}/",' ',trim($_POST['first-name']));
		$last_name = preg_replace("/\s{2,}/",' ',trim($_POST['last-name']));
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$second_password = trim($_POST['second-password']);
		$arrayName['first-name'] = '';
		if (empty($first_name) ) {
			$arrayName['first-name'] = 'Введите имя!'; 
		}

		if (empty($last_name) ) { 
			$arrayName['last-name'] = 'Введите фамилию!'; 
		}

		if (empty($email) ) {
			$arrayName['email'] = 'Введите e-mail адрес!'; 
		}
		if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$arrayName['wrong-email'] = 'Введите корректный e-mail адрес!'; 
		}

		if (empty($password) ) {
			$arrayName['password'] = 'Введите пароль!'; 
		}

		if (empty($second_password) ) {
			$arrayName['second-password'] = 'Введите пароль ещё раз!';
		}
		if (!empty($second_password) && $password!=$second_password) {
			$arrayName['wrong-password'] = 'Пароли не совпадают!';
		}
		if (!empty($password) && strlen($password) < 5) {
			$arrayName['min-password'] = 'Введите не менее 5-ти символов!';
		}
		if (strlen($password) > 10) {
			$arrayName['max-password'] = 'Максимальное количество символов - 10!';
		}
		$query = "SELECT `email` FROM users WHERE email=`$email`";
		$result = mysqli_query($link, $query);

		if (!empty($result) && !empty($email)) {
			$arrayName['exists-email'] = 'Такой e-mail адрес уже зарегистрирован!';
		}
		if ($password==$second_password && empty($arrayName) ) {
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
				$has_error_class = isset($arrayName['first-name']) && !empty($arrayName['first-name']) ? 'has-error' : '';
				$has_success_class = isset($arrayName['first-name']) && empty($arrayName['first-name']) ? 'has-success' : '';
			?>
			<div class="form-element form-group <?php echo $has_error_class; echo $has_success_class;?>">
			 	<div class="col-sm-12">
			    	<input  class="form-control " placeholder="Имя" type="text" name="first-name" value="<?php echo $first_name; ?>">	
			    </div>
			</div>
		    <span class="result_of_query">
				<?php 
			    	if(isset($arrayName['first-name']) && !empty($arrayName['first-name'])   ) {
						echo $arrayName['first-name'];
					}
		    	?>
	    	</span>
	    	<?php 
				$has_error_class = isset($arrayName['last-name']) && !empty($arrayName['last-name']) ? 'has-error' : '';
				$has_success_class = isset($arrayName['last-name']) && empty($arrayName['last-name']) ? 'has-success' : '';
			?>
		   	<div class="form-element form-group <?php echo $has_error_class; echo $has_success_class;?>">
			 	<div class="col-sm-12">
		    		<input class="form-control" placeholder="Фамилия" type="text" name="last-name" value="<?php echo $last_name; ?>">	
		    	</div>
			</div>
			<span class="result_of_query">
			    <?php 
			    	if(isset($arrayName['last-name']) && !empty($arrayName['last-name']) ){
						echo $arrayName['last-name'];
					}
		    	?>
	    	</span>
	    	<?php 
				$has_error_class = isset($arrayName['email']) && !empty($arrayName['email']) ? 'has-error' : '';
				$has_success_class = isset($arrayName['email']) && empty($arrayName['email']) ? 'has-success' : '';
			?>
		    <div class="form-element form-group <?php echo $has_error_class; echo $has_success_class;?>">
			 	<div class="col-sm-12">
		    		<input class="form-control" placeholder="Email" type="text" name="email" value="<?php echo $email; ?>">	
		    	</div>
			</div>
			<span class="result_of_query">
		    	<?php 
		    		if(isset($arrayName['email']) && !empty($arrayName['email']) ){
						echo $arrayName['email'];
					}
					if(isset($arrayName['wrong-email']) && !empty($arrayName['wrong-email']) ){
						echo $arrayName['wrong-email'];
					}
					if(isset($arrayName['exists-email']) && !empty($arrayName['exists-email']) ){
						echo $arrayName['exists-email'];
					}
				?>
	    	</span>
	    	<?php 
				$has_error_class = isset($arrayName['password']) && !empty($arrayName['password']) ? 'has-error' : '';
				$has_success_class = isset($arrayName['password']) && empty($arrayName['password']) ? 'has-success' : '';
			?>
		    <div class="form-element form-group <?php echo $has_error_class; echo $has_success_class;?>">
			 	<div class="col-sm-12">
		    		<input class="form-control" placeholder="Пароль" type="password" name="password" value="<?php echo $password; ?>">
		    	</div>
			</div>
			<span class="result_of_query">
		    	<?php 
			    	if(isset($arrayName['password']) && !empty($arrayName['password']) ){
						echo $arrayName['password'];
					}
					if(isset($arrayName['min-password']) && !empty($arrayName['min-password']) ){
						echo $arrayName['min-password'];
					}
					if(isset($arrayName['max-password']) && !empty($arrayName['max-password']) ){
						echo $arrayName['max-password'];
					}
		    	?>
		    </span>
		    <?php 
				$has_error_class = isset($arrayName['second-password']) && !empty($arrayName['second-password']) ? 'has-error' : '';
				$has_success_class = isset($arrayName['second-password']) && empty($arrayName['second-password']) ? 'has-success' : '';
			?>
		    <div class="form-element form-group <?php echo $has_error_class; echo $has_success_class;?>">
			 	<div class="col-sm-12">
		    		<input class="form-control" placeholder="Повторный пароль" type="password" name="second-password" value="<?php echo $second_password; ?>">
		    	</div>
			</div>
			<span class="result_of_query">
		    	<?php 
			    	if(isset($arrayName['second-password']) && !empty($arrayName['second-password']) ) {
						echo $arrayName['second-password'];
					}
					if(isset($arrayName['wrong-password']) && !empty($arrayName['wrong-password']) ) {
						echo $arrayName['wrong-password'];
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