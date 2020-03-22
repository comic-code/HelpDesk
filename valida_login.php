<?php
  session_start();
  // Variável que verifica se usuário foi autenticado
  $usuario_autenticado = false;
  $usuarios_id = null;
  $usuarios_perfil_id = null;

  $perfis = [1 => 'Administrativo', 2 => 'Usuário'];

  // Usuários no sistema
  $usuarios_app = [
    ['id' => 1,'email' => 'adm@teste', 'senha' => 'senha', 'perfil_id' => 1],
    ['id' => 2,'email' => 'jose@teste', 'senha' => 'senha', 'perfil_id' => 2],
    ['id' => 3,'email' => 'maria@teste', 'senha' => 'senha', 'perfil_id' => 2],
    ['id' => 4,'email' => 'teste@teste', 'senha' => 'senha', 'perfil_id' => 1]
  ];

  // Lógica de autenticação
  foreach ($usuarios_app as $user) {
    
    if($user['email'] == $_POST['email'] && $user['senha'] == $_POST['senha']) {
      $usuario_autenticado = true;
      $usuarios_id = $user[id];
      $usuarios_perfil_id = $user['perfil_id'];
    }
  }

  if($usuario_autenticado) {
    $_SESSION['autenticado'] = true;
    $_SESSION['id'] = $usuarios_id;
    $_SESSION['perfil_id'] = $usuarios_perfil_id;
    header('Location: home.php');
  } else {
    $_SESSION['autenticado'] = false;
    header('Location: index.php?login=erro');
  }

?>