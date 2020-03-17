<?php
  // Variável que verifica se usuário foi autenticado
  $usuario_autenticado = false;

  // Usuários no sistema
  $usuarios_app = [
    ['email' => 'adm@teste.com.br', 'senha' => '123456'],
    ['email' => 'user@teste.com.br', 'senha' => 'abcd'],
    ['email' => 'teste@teste', 'senha' => 'senha']
  ];

  // Lógica de autenticação
  foreach ($usuarios_app as $user) {
    
    if($user['email'] == $_POST['email'] && $user['senha'] == $_POST['senha']) {
      $usuario_autenticado = true;
    }
  }

  if($usuario_autenticado) {
    echo 'Usuário autenticado';
  } else {
    header('Location: index.php?login=erro');
  }

?>