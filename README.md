# Titan OS — Sistema de Controle de Serviços

O Titan OS é uma aplicação web criada para registrar e acompanhar serviços realizados por funcionários, incluindo o cálculo automático de comissão.

O projeto foi desenvolvido como desafio técnico utilizando **PHP puro**, sem framework, Composer ou bibliotecas externas. A proposta foi trabalhar diretamente com os principais recursos da linguagem e organizar a aplicação de forma simples, usando roteamento próprio, PDO, sessões, autenticação e separação das responsabilidades do sistema.

## Funcionalidades

O sistema permite:

* cadastrar funcionários;
* realizar login e logout;
* registrar novos serviços;
* calcular automaticamente a comissão de cada serviço;
* visualizar serviços em um dashboard;
* filtrar serviços por descrição, funcionário e período;
* finalizar serviços diretamente pela tabela;
* calcular o total de comissão acumulada;
* preparar uma notificação por e-mail quando um serviço é finalizado.

As senhas dos usuários são armazenadas usando `password_hash()` e validadas com `password_verify()`.

## Comissão

A comissão do funcionário é definida de acordo com o valor do serviço:

| Valor do serviço   | Comissão |
| ------------------ | -------: |
| Acima de R$ 10.000 |      20% |
| Acima de R$ 1.000  |      10% |
| Até R$ 1.000       |       5% |

A comissão é calculada no momento do cadastro do serviço e armazenada no banco.

No dashboard, o total considera somente os serviços que já estão com status **Finalizado**.

Esse cálculo é feito diretamente no banco e não depende dos filtros aplicados na listagem.

## Estrutura do projeto

O projeto foi organizado seguindo uma estrutura baseada em MVC:

```text
titansoftwareerp/
├── BD/
│   ├── connect.php
│   └── schema.sql
├── app/
│   ├── Config/
│   │   ├── Config.php
│   │   ├── Router.php
│   │   └── View.php
│   ├── Controllers/
│   │   ├── LoginController.php
│   │   ├── UserController.php
│   │   └── ServiceController.php
│   ├── Model/
│   │   ├── User.php
│   │   └── Service.php
│   ├── Services/
│   │   └── EmailService.php
│   └── Views/
│       ├── layouts/
│       │   └── main.php
│       ├── login.php
│       ├── register.php
│       ├── service-create.php
│       └── dashboard.php
└── public/
    ├── index.php
    ├── .htaccess
    └── assets/
```

### `BD`

Contém a configuração de acesso ao banco e o script SQL utilizado para criar as tabelas e os dados iniciais.

### `Config`

Reúne algumas configurações da aplicação.

O `Router.php` é responsável pelo roteamento das requisições, enquanto o `View.php` faz o carregamento das telas dentro do layout principal.

### `Controllers`

Os controllers recebem as requisições e chamam as classes responsáveis pelas operações necessárias.

Foram separados em:

* `LoginController`
* `UserController`
* `ServiceController`

### `Model`

Contém as classes que fazem as consultas ao banco utilizando PDO.

O `User.php` concentra as operações relacionadas aos usuários e o `Service.php` trabalha com os serviços e comissões.

### `Services`

Foi criada uma classe separada para a parte de envio de e-mails.

### `Views`

Contém as páginas exibidas ao usuário.

### `public`

É o ponto de entrada da aplicação.

O arquivo `index.php` registra as rotas, enquanto o `.htaccess` redireciona as requisições para esse arquivo.

## Roteamento

O projeto possui um roteador simples feito para a própria aplicação.

As rotas são registradas no `public/index.php` informando:

* método HTTP;
* caminho;
* controller;
* método que deve ser executado.

O roteador identifica a URI da requisição e procura uma rota correspondente.

Caso nenhuma rota seja encontrada, a aplicação retorna `404`.

Para esse projeto, essa solução foi suficiente e evitou a necessidade de uma biblioteca externa somente para roteamento.

## Banco de dados e PDO

Todas as consultas ao MySQL são feitas através do **PDO**.

Também foram utilizados prepared statements para os valores recebidos pela aplicação.

Nos filtros do dashboard, por exemplo, a consulta SQL é montada de acordo com os campos preenchidos pelo usuário.

Se apenas o funcionário for informado, somente essa condição entra na consulta. Se forem informadas datas ou descrição, as condições correspondentes também são adicionadas.

Mesmo sendo uma consulta dinâmica, os valores continuam sendo enviados por parâmetros, sem concatenar diretamente os dados digitados pelo usuário na query.

## Autenticação

No cadastro, a senha é convertida para hash usando:

```php
password_hash()
```

No login, a validação é feita com:

```php
password_verify()
```

Depois da autenticação, os dados necessários do usuário são armazenados na sessão.

A senha não é mantida dentro do array salvo na sessão.

As páginas que precisam de autenticação também verificam se existe um usuário logado antes de executar a ação.

## Finalização dos serviços

Os serviços são cadastrados inicialmente com o status:

```text
Pendente
```

Na tabela do dashboard existe um botão para finalizar o serviço.

Antes de executar a ação, o JavaScript pede confirmação ao usuário.

Depois disso, é feito um `fetch` utilizando `POST` para a rota responsável pela finalização.

O controller atualiza o serviço no banco e retorna uma resposta JSON.

Exemplo:

```json
{
    "success": true,
    "message": "Serviço resolvido com sucesso.",
    "redirect": "/titansoftwareerp/public/dashboard"
}
```

Se a operação for concluída, o JavaScript utiliza a URL recebida para voltar ao dashboard.

Existe também no código uma versão mais simples dessa ação através de link, que ficou comentada como alternativa.

## Envio de e-mail

Foi criada a classe:

```text
app/Services/EmailService.php
```

Ela utiliza a função `mail()` do PHP para enviar uma mensagem ao funcionário quando o serviço é finalizado.

O envio real está desativado por padrão.

Como o projeto foi desenvolvido para rodar localmente no XAMPP, seria necessário configurar um servidor SMTP ou outro serviço de envio para que a função funcionasse corretamente.

Por isso, durante os testes, a chamada foi substituída por uma simulação de sucesso.

A classe ficou separada do controller para que seja possível ativar o envio posteriormente sem alterar a lógica principal de finalização do serviço.

## Banco de dados

A aplicação possui duas tabelas principais.

### `users`

Armazena os funcionários.

Entre os campos estão:

* nome;
* e-mail;
* senha;
* data de criação;
* data da última atualização.

O e-mail possui restrição `UNIQUE`.

### `services`

Armazena os serviços realizados.

Possui informações como:

* descrição;
* preço;
* comissão;
* funcionário responsável;
* status;
* data de criação;
* data de atualização;
* data de finalização.

Cada serviço possui uma chave estrangeira para um usuário.

```text
services.user_id_user -> users.id_user
```

Foi utilizado `ON DELETE CASCADE`, portanto, se um usuário for removido, os serviços vinculados a ele também são removidos.

## Como executar

O projeto foi desenvolvido e testado usando **XAMPP**, com Apache e MySQL.

### 1. Copie o projeto

Coloque a pasta:

```text
titansoftwareerp
```

dentro do diretório:

```text
xampp/htdocs/
```

### 2. Crie o banco

Importe o arquivo:

```text
BD/schema.sql
```

pelo phpMyAdmin ou pelo próprio MySQL.

O script cria o banco:

```text
titan_os_db
```

e também cria as tabelas `users` e `services`.

Alguns usuários de teste também são inseridos automaticamente.

### 3. Verifique a conexão

O arquivo:

```text
BD/connect.php
```

está configurado inicialmente para:

```text
Host: localhost
Usuário: root
Senha: vazia
Porta: 3306
Banco: titan_os_db
```

Caso sua instalação do MySQL utilize outra porta ou senha, altere esses valores.

### 4. Abra o sistema

Com Apache e MySQL iniciados no XAMPP, acesse:

```text
http://localhost/titansoftwareerp/public
```

## Usuários de teste

O banco já possui algumas contas para facilitar os testes.

| E-mail                                      | Senha      |
| ------------------------------------------- | ---------- |
| [caneta@email.com](mailto:caneta@email.com) | `senha123` |
| [vini@email.com](mailto:vini@email.com)     | `senha123` |
| [luva@email.com](mailto:luva@email.com)     | `senha123` |

Também é possível cadastrar outro usuário pela própria aplicação.

Na tela de login, basta acessar a opção **Cadastrar usuário**.

## Alteração do caminho do projeto

Atualmente a aplicação considera que está sendo executada em:

```text
/titansoftwareerp/public
```

Se o nome da pasta ou o caminho for alterado, também é  modificar:

```text
app/Config/Config.php
```

e:

```text
app/Config/Router.php
```

No primeiro arquivo fica a constante `BASE_URL`.

No segundo fica o `basePath` utilizado pelo roteador.

## Tecnologias utilizadas

* PHP
* MySQL
* PDO
* HTML
* CSS
* JavaScript
* Apache
* `.htaccess`

Todo o projeto foi feito sem framework PHP, sem Composer e sem dependências externas.
