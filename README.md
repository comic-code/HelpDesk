# HelpDesk
Uma aplicação web feito em PHP para agendamento com intuíto de praticar.

## <a name="indice">Índice</a>

1. [PHP](https://github.com/comicodarko/Lab-PHP)

2. [Desenvolvendo a primeira aplicação WEB com PHP](https://github.com/comicodarko/HelpDesk)
    - 2.1 [GET e POST](#parte02-1)
    - 2.2 [Autenticando usuário](#parte02-2)
****

## Desvendando os métodos GET e POST.
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

## <a name="parte02-1">Autenticando usuário</a>

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