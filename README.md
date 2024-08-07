# APIContaAzul

APIContaAzul é uma biblioteca PHP simples para integração com a API da Conta Azul, fornecendo métodos para autenticação e requisições aos endpoints desejados.

## Descrição

Esta biblioteca facilita a integração com a API da Conta Azul, automatizando o processo de autenticação OAuth2 e fornecendo métodos convenientes para realizar requisições aos diversos endpoints disponíveis na API. Ideal para quem precisa acessar e manipular dados como clientes, produtos, serviços, contratos e vendas na plataforma Conta Azul.

## Instalação

APIContaAzul está disponível no [Packagist](https://packagist.org/packages/ae8/contaazul), e a instalação via [Composer](https://getcomposer.org) é a forma recomendada de instalá-la. Basta adicionar a seguinte linha ao seu arquivo `composer.json`:

```json
"ae8/contaazul": "^1.0"
```

Ou executar o seguinte comando no terminal:

```bash
composer require ae8/contaazul
```

Lembre-se que a pasta `vendor` e o script `vendor/autoload.php` são gerados pelo Composer; eles não fazem parte da biblioteca.

## Como Usar

### Criando a Aplicação

O primeiro passo é criar uma aplicação no portal de desenvolvedores da Conta Azul através do [link](https://portaldevs.contaazul.com/). Após criar a aplicação, você terá acesso ao `client_id` e `secret_id` da sua aplicação.

**Nota:** Preste atenção à URL de redirecionamento que você definir ao criar sua aplicação, pois ela será utilizada na autenticação OAuth2.

### Iniciando a Autenticação

Primeiro, você precisa iniciar o processo de autenticação acessando a seguinte URL:

[`https://api.contaazul.com/auth/authorize?redirect_uri={redirect_uri}&client_id={client_id}&scope=sales&state={state}`](https://api.contaazul.com/auth/authorize?redirect_uri={redirect_uri}&client_id={client_id}&scope=sales&state={state})

Onde:

*   `redirect_uri`: Mesma URL definida na aplicação.
*   `client_id`: O valor do `client_id` obtido ao criar a aplicação.
*   `scope`: Define o tipo de acesso que você terá à API (`Customer`, `Product`, `Service`, `Contract`, `Sale`).
*   `state`: Um valor definido por você que serve como chave de autenticidade do request.

### Usando a Biblioteca

#### Instanciando a Classe

No arquivo PHP indicado na URL de redirecionamento, você precisa instanciar a classe da biblioteca:

```php
$requireAutoload = __DIR__ . '/vendor/autoload.php';
require $requireAutoload;

use AE8\ContaAzul\ContaAzul;
use AE8\ContaAzul\Helpers\Helpers;

// Variáveis necessárias para inicialização
$client_id = "CLIENT_ID";
$client_secret = "SECRET_ID";
$redirect_uri = "URL_DE_REDIRECIONAMENTO";
$scope = "sales";
$state = Helpers::generateRandomString(16);

// Instanciando a classe
$apiContaazul = new ContaAzul($client_id, $client_secret, $redirect_uri, $scope, $state);
```

#### Negociando o Token

Agora, você deve capturar o código enviado pela Conta Azul no parâmetro `code` da URL de redirecionamento:

```php
if (isset($_REQUEST['code'])) {
    $getToken = $apiContaazul->requestToken($_REQUEST['code']);
}
```

O método `requestToken` retornará os seguintes parâmetros:

*   `access_token`
*   `refresh_token`
*   `expires_in`

Armazene esses valores em uma sessão para monitorar o tempo de expiração e renovar o token quando necessário.

### Renovando o Token

Quando o token expirar (após 60 minutos), você pode renová-lo facilmente com o método:

```php
$getToken = $apiContaazul->requestToken($refresh_token);
```

### Usando a API

Com o token em mãos, você pode fazer requisições à API da Conta Azul usando o método:

```php
$request = $apiContaazul->request($endpoint, $parametros, $token, $metodo);
```

*   `$endpoint`: O endpoint da API que você deseja acessar.
*   `$parametros`: Parâmetros enviados na requisição.
*   `$token`: O token de acesso gerado.
*   `$metodo`: O método HTTP a ser usado (`get`, `post`, `put`, `delete`, `postjson`, `putjson`).

## Desenvolvedor

* Arismário Neves (Mari05liM) <mariodev@outlook.com.br>
