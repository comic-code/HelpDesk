<?php

  // Teste de campo vazio
  if($_POST['titulo'] == '' || $_POST['categoria'] == '' || $_POST['descricao'] == '') {
    header('Location: abrir_chamado.php?vazio');
  } else {

  // Abrindo o arquivo
  $arquivo = fopen('arquivo.txt', 'a');

  // Montagem do texto
  $titulo = str_replace('#', '-', $_POST['titulo']);
  $categoria = str_replace('#', '-', $_POST['categoria']);
  $descricao = str_replace('#', '-', $_POST['descricao']);

  $texto = $titulo . '#' . $categoria . '#' . $descricao . PHP_EOL;

  // Escrevendo no arquivo
  fwrite($arquivo, $texto);

  // Fechando o arquivo
  fclose($arquivo);

  header('Location: abrir_chamado.php?sucesso');
}
?>