<?php
  session_start();

  if(!($_SESSION['autenticado']) || !isset($_SESSION['autenticado'])) {
    header('Location: index.php?login=erro2');
  } 
?>