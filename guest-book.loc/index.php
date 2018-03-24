<?php
	require_once('./bd.php');
	$email = '';
	$password = '';
	$arrayErrors = array();
	$result_of_query_good = false;
	$has_errors = FALSE;
	$reg_not_finish = '';

	if(isset($_POST) && !empty($_POST)) {
		$arrayErrors['email'] = '';
		$arrayErrors['password'] = '';
		$email = $_POST['email'];
		$password = $_POST['password'];
		if (empty($_POST['email']) ) { 
			$arrayErrors['email'] = 'Введите e-mail адрес!'; 
			$has_errors = TRUE;
		}
		if (empty($_POST['password']) ) {
			$arrayErrors['password'] = 'Введите пароль!'; 
			$has_errors = TRUE;
		}

		if (!empty($email) && !empty($password)) {
			$hash_password = md5($password);
			$query = "SELECT * FROM users WHERE email = '$email' AND password = '$hash_password'";
			$result = mysqli_query($link, $query); 
			mysqli_close($link);
			$row = mysqli_fetch_assoc($result);

			if (isset($row['email']) && $has_errors==FALSE && $row['activated']==1) {
				session_start();
				$_SESSION['user_id'] = $row['id'];
				header("Location: comments.php");
			}

			elseif (isset($row['activated']) && $row['activated']==0) {
				$arrayErrors['reg_not_finish'] = 'Вы не закончили процесс регистрации!'; 
				$has_errors = TRUE;
			}
			else {
				$arrayErrors['wrong_data'] = 'Неверный ввод!';
				$has_errors = TRUE;
			}
		}
	}
	require_once('./head.php');
?>
	<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-3 col-xs-offset-1 col-lg-4 col-md-4 col-sm-6 col-xs-10 main-blok">
		
		<h2>Авторизация</h2>
		<form class="form form-horizontal form-group " method="post">
			<?php 
				$has_error_class = isset($arrayErrors['email']) && !empty($arrayErrors['email']) || isset($arrayErrors['wrong_data']) && !empty($arrayErrors['wrong_data']) || isset($arrayErrors['reg_not_finish']) && !empty($arrayErrors['reg_not_finish']) ? ' has-error ' : '';
				$has_success_class = isset($arrayErrors['email']) && empty($arrayErrors['email']) ? ' has-success ' : '';
				//$wrong_data = isset($arrayErrors['wrong_data']) && !empty($arrayErrors['wrong_data']) ? 'has-error' : '';
			?>
		    <div class="form-element form-group <?php echo $has_error_class; echo $has_success_class; echo $wrong_data; ?>">
			 	<div class="col-sm-12">
		    		<input class="form-control" placeholder="Email" type="text" name="email">	
		    	</div>
			</div>
			<span class="result_of_query">
				<?php 
			    	if(isset($arrayErrors['email']) && !empty($arrayErrors['email']) ) {
						echo $arrayErrors['email'];
					}
		    	?>
		    </span>
			<?php 
				$has_error_class = isset($arrayErrors['password']) && !empty($arrayErrors['password']) || isset($arrayErrors['wrong_data']) && !empty($arrayErrors['wrong_data']) || isset($arrayErrors['reg_not_finish']) && !empty($arrayErrors['reg_not_finish']) ? ' has-error ' : '';
				$has_success_class = isset($arrayErrors['password']) && empty($arrayErrors['password']) ? ' has-success ' : '';
				//$wrong_data = isset($arrayErrors['wrong_data']) && !empty($arrayErrors['wrong_data']) ? ' has-error ' : '';
			?>
		    <div class="form-element form-group <?php echo $has_error_class; echo $has_success_class; echo $wrong_data; ?>">
			 	<div class="col-sm-12">
		    		<input class="form-control" placeholder="Пароль" type="password" name="password">
		    	</div>
			</div>
			<span class="result_of_query">
				<?php
			    	if(isset($arrayErrors['password']) && !empty($arrayErrors['password']) ) {
						echo $arrayErrors['password'];
					}
		    	?>
		    </span>
		    <div class="form-group form-element">
			 	<div class="col-sm-12">
		    		<button type="submit" name="submit" class="form-control button-form">Вход</button>
		    	</div>
			</div>
		</form>
		<h4 class="result_of_query">
			<?php
			    if(isset($arrayErrors['reg_not_finish']) && !empty($arrayErrors['reg_not_finish']) ) {
					echo $arrayErrors['reg_not_finish'];
				}
		    ?>
		</h4>
		<h4 class="result_of_query">
			<?php
				if(isset($arrayErrors['wrong_data']) && !empty($arrayErrors['wrong_data']) ) {
					echo $arrayErrors['wrong_data'];
				}
			?>
		</h4>
		<h4><a href="registration.php">Регистрация</a></h4>
	</div>
</html>