<?php
session_start();
unset($_SESSION); // разрегистрировали переменную
session_destroy(); // разрушаем сессию
header("Location: index.php");
?>