<?php
  
  session_start();  //Esto inicia la sesión.
  session_unset();//Esto elimina todas las variables de sesión.
  session_destroy(); // Esto eliminará la sesión por completo, lo que no es lo mismo que desconfigurar las variables.
  header("Location: index.php");
  exit();
