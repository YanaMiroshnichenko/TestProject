<?php 

session_start();

  unset($_SESSION); // разрегистрировали переменную

  // echo 'выход';

header("Location: index.php");
	
  /* теперь имя пользователя уже не выводится */

  session_destroy(); // разрушаем сессию





?>