# HelpDesk
Uma aplicação web feito em PHP para agendamento com intuito de praticar.

## <a name="indice">Índice</a>

1. [PHP](https://github.com/comicodarko/Lab-PHP)

2. [Desenvolvendo a primeira aplicação WEB com PHP](https://github.com/comicodarko/HelpDesk)
    - 2.1 [GET e POST](#parte02-1)
    - 2.2 [Autenticando usuário](#parte02-2)
    - 2.3 [Protegendo páginas restritas com SESSION](#parte02-3)
    - 2.4 [Incorporando scripts](#parte02-4)
    - 2.5 [logoff](#parte02-5)
    - 2.6 [Registrando chamados](#parte02-6)
    - 2.7 [Consultando chamados](#parte02-7)
****

## <a name="parte02-1">Desvendando os métodos GET e POST.</a>
São variáveis supeglobais, ou seja elas sempre estão disponíveis em todos os escopoas para todo o script.
****

O atributo **action** - será responsável por processar os dados do form antes de enviar para o servidor.
```html
<form action="valida_login.php">
```

Como não estamos definindo nenhum método, GET será usado, logo as informações serão enviadas pela própria URL.

> Após a ? na URL vão parâmetro que possam a vir ser tratados no script encaminhado em action.
> Vale lembrar que a resposta dada pelo servidor não é o script PHP e sim a resposta dada pelo.

```php
$_GET - [name]
```

**Post** - Anexa os dados dentro na própria requisição, retirando os dados da URL.
```html
<form action="valida_login.php" method="post">
```

> Dessa forma nada é informado na URL.

[Voltar ao índice](#indice)
****

## <a name="parte02-2">Autenticando usuário</a>

Vamos receber os dados do front-end, enviar para o back-end, para que ai sim, do lado do servidor, seja possível dizer se o usuário existe ou não a aplicação.

Como ainda não estamos trabalhando com banco de dados, iremos usar **Arrays**.

```php
$usuarios_app = [
    ['email' => 'adm@teste.com.br', 'senha' => '123456'],
    ['email' => 'user@teste.com.br', 'senha' => 'abcd'],
];
```

Agora é preciso uma lógica de autenticação, tendo base esse array:
```php
foreach ($usuarios_app as $user) {
    
    if($user['email'] == $_POST['email'] && $user['senha'] == $_POST['senha']){
    $usuario_autenticado = true;
    }
  }

  if($usuario_autenticado) {
  echo 'Usuário autenticado';
  } else {
  echo 'Erro na autenticação do usuário';
  }
```
### Função header

Usaremos a função header para forçar o redirecionamento para index.php e alguns parâmetros junto.

```php
if($usuario_autenticado) {
    echo 'Usuário autenticado';
} else {
    header('Location: index.php?login=erro');
}
```
> Agora através da superglobal **GET** podemos recuperar esse parâmetro

```php
$_GET['login'];
```

Porém isso retornará um erro, já que pela primeira vez que acessar a página 'login' não estará definido. Para arrumar isso basta usar a função **isset** que verifica se o indíce está setado.

```php
if($usuario_autenticado) {
    echo 'Usuário autenticado';
} else {
    header('Location: index.php?login=erro');
}
```
> Dependendo da lógica é necessário verificar se um determinado indíce existe ou não, afins de evitar erros.

### Exibindo erro no HTML

```php
?php
    if(isset($_GET['login']) && $_GET['login'] =='erro' ) {   
?>

    <div class="mb-2 text-center text-danger">
    Usuário Inválido
    </div>
                
<?php } ?> 
```
> No exemplo usado, caso login esteja setado e caso ele tenha o valor de error, a div descrita será exibida.

## <a name="parte02-3">Protegendo páginas restritas com SESSION</a>

Nesse momento todas as páginas podem ser acessadas livremente através de uma requisição HTTP, porém em algumas aplicações WEB é necessário proteger algumas páginas de acordo com o acesso.

### Sempre quer trabalhamos com sessão é fundamental utilizar a instrução session_start() sempre antes de qualquer instrução que emita ao navegador qualquer saída (output de dados). Por padrão geralmente é usado no início do script.

```php
$_SESSION
```
> Superglobal de sessão

É possível recuperar a mesma e atribuir valores.
```php
$_SESSION['autenticado'] = true;
```

Isso significa que essa informação estará disponível para todos os demais scripts.

> Vale lembrar que cada sessão no PHP por padrão dura por **3 horas**.

Redirecionando caso não autenticado:

```php
session_start();

  if(!($_SESSION['autenticado']) || !isset($_SESSION['autenticado'])) {
    header('Location: index.php?login=erro2');
  } 
```

## <a name="parte02-4">Incorporando scripts com include, include_once, require e require_once</a>

A ideia é evitar redundância de códigos dentro de nossas aplicações.

### Include

```php
include('menu.php');
```
> Isso facilita manutenções futuras.

### Require

A diferença entre os dois é bem sutil, e se dá quando não é possível localizar o arquivo.

O include irá gerar um warning - Apenas um alerta

O require um **fatal error** - Interrompe imediatamente o script.

```php
require 'menu.php';
```

### Include_once e Require_once

A diferença é que permite a inclusão de um script apenas uma única vez.

### Um exemplo na aplicação

Refatorando o código é possível notar a repetição do validador de acesso em 3 páginas, sendo assim, basta separar essa parte e incluir com **require_once** (afinal é uma parte **essencial**).

```php
<?php
  session_start();

  if(!($_SESSION['autenticado']) || !isset($_SESSION['autenticado'])) {
    header('Location: index.php?login=erro2');
  } 
?>
```

### <a name="parte02-5">Encerrando a sesssão </a>
```php
session_start();
session_destroy();
```

## <a name="parte02-6">Registrando chamados</a>

Como ainda não estamos trabalhando com banco de dados vamos fazer isso através de um arquivo TXT.

Vale a pena lembrar que se todos os names estiverem definidos todo formulário será enviado para a superglobal **$_POST**.

### Abrindo um arquivo

```php
$arquivo = fopen('arquivo.txt', 'a');
```
> Primeiro é passado o nome do arquivo e em seguida a ação, no caso a cima abre apenas para o modo de  escrita e coloca o ponteiro do arquivo no final do mesmo, caso o arquivo não exista ele tenta criá-lo.

### Escrevendo em um arquivo
```php
fwrite($arquivo, $texto);
```
> Espera uma variável com fopen e o que será escrito.

### Fechando um arquivo
```php
fclose($arquivo);
```
> Espera a referência de fopen

### Quebrando linhas de acordo com o Sistema Operacional
```php
PHP_EOL
```
> EOL = End Of Line

## <a name="parte02-7">Consultando chamados</a>

Nesse caso precisamos abrir o arquivo.txt, ler e depois fechar.

```php
$arquivo = fopen('arquivo.txt', 'r');
```
> Nesse caso abrimos os arquivo apenas para leitura.

Agora é necessário percorrer cada uma das linhas do nosso arquivo, para isso usaremos um laço de repetição.

```php
$arquivo = fopen('arquivo.txt', 'r');

  // Enquanto houver linhas
  while(!feof($arquivo)) {
    fgets($arquivo);
  }

  fclose($arquivo);

```
> **feof** testa pelo fim de um arquivo (END OF FILE) e espera a referencia de um arquivo aberto

> **fgets** recupera até a quebra de linha e espera a referência de um arquivo aberto

### Editando a view

```php
<?php foreach($chamados as $chamado) { 
                
  $chamado_dados = explode('#', $chamado);

  if(count($chamado_dados) < 3) {
    continue;
  }

?>

  <div class="card mb-3 bg-light">
    <div class="card-body">
      <h5 class="card-title"><?=$chamado_dados[0]?></h5>
      <h6 class="card-subtitle mb-2 text-muted"><?=$chamado_dados[1]?></h6>
      <p class="card-text"><?=$chamado_dados[2]?></p>
    </div>
  </div>

<?php } ?>
```
> Vale a pena lembrar que se deve pular quando a linha for vazia (continue)