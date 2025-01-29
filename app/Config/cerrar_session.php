<?php
  
  session_start();  // iniciando la sesión...
  session_unset();//Esto elimina todas las variables de sesión.
  session_destroy(); // Esto eliminará la sesión por completo.
  header("Location: index.php");
  exit();
