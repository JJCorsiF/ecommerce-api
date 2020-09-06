# E-commerce API

Esta é uma API RESTful de exemplo para um sistema de E-commerce. Foi desenvolvida e testada usando o PHP 7.3.19, utilizando o framework Laravel versão 7.24.

## Setup
Para instalar a aplicação, acesse o diretório onde a aplicação rodará e clone a aplicação:

```bash
$ git clone git@github.com:JJCorsiF/ecommerce-api.git
```

## Configurando a aplicação
Para que a aplicação possa funcionar corretamente, é necessário ter instalado no servidor o PHP com uma versão igual ou superior a 7.2.5. Além disso, o servidor deve ter as seguintes extensões PHP habilitadas para que o Laravel 7 possa funcionar corretamente: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer e XML. É necessário ter também um banco de dados MySQL criado e rodando e um usuário com acesso a esse banco.

Para configurar a aplicação, copie o arquivo **.env.testing** e renomeie-o para **.env**. Em seguida, substitua o trecho onde aparece as constantes abaixo com as informações do banco de dados e do servidor de email de sua máquina/servidor.

```
(...)

DB_CONNECTION=mysql
DB_HOST=<HOST DO BANCO DE DADOS>
DB_PORT=<PORTA DO BANCO DE DADOS>
DB_DATABASE=<NOME DO BANCO DE DADOS DA APLICACAO>
DB_USERNAME=<NOME DO USUÁRIO COM ACESSO AO BANCO>
DB_PASSWORD=<SENHA DO USUARIO DO BANCO DE DADOS>

(...)

MAIL_MAILER=smtp
MAIL_HOST=<HOST DO SERVIDOR DE EMAIL>
MAIL_PORT=<PORTA DO SERVIDOR DE EMAIL>
MAIL_USERNAME=<USERNAME DO SERVIDOR DE EMAIL>
MAIL_PASSWORD=<SENHA DO SERVIDOR DE EMAIL>
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```

## Instalando as dependências
Para instalar as dependências da aplicação, será necessário ter o Composer instalado. Para instalar as dependências, digite na linha de comando:

```bash
$ composer install
```

Agora falta apenas a criação das tabelas no banco de dados criado. Para que as tabelas necessárias sejam criadas no banco de dados, é necessário executar o seguinte comando:

```bash
$ php artisan migrate
```

## Testando a aplicação
Para realizar os testes na aplicação, basta executar o seguinte comando:

```bash
$ php artisan test --env=testing
```

Recomendo utilizar outro banco de dados para os testes, para não afetar os dados do banco de produção. As configurações do banco de testes podem ser definidas no arquivo **.env.testing**. Caso não se importe em sobrescrever o banco de produção, basta executar o comando sem o parâmetro --env=testing.

## Acessando a aplicação
Para iniciar a aplicação, execute o comando:

```bash
$ php artisan serve
```

A aplicação iniciará e a API estará disponível em http://127.0.0.1:8000/. Para acessar a rota de clientes, por exemplo, basta acessar http://127.0.0.1:8000/clientes.

O arquivo *E-Commerce API.postman_collection.json* contém uma Collection para ser usada com o Postman.

As seguintes rotas estão disponíveis:
- *Listar todos os clientes*: GET​ /clientes
- *Listar um cliente por ID*: GET​ /clientes/{id}
- *Adicionar um cliente*: POST​ /clientes
- *Atualizar os dados de um cliente*: PUT​ /clientes/{id}
- *Remover os dados de um cliente*: DELETE ​/clientes/{id}
- *Listar todos os produtos*: GET​ /produtos
- *Listar um produto por ID*: GET​ /produtos/{id}
- *Adicionar um produto*: POST​ /produtos
- *Atualizar os dados de um produto*: PUT​ /produtos/{id}
- *Remover os dados de um produto*: DELETE​ /produtos/{id}
- *Listar todos os pedidos*: GET​ /pedidos
- *Listar um pedido por ID*: GET​ /pedidos/{id}
- *Adicionar um pedido*: POST​ /pedidos
- *Atualizar os dados de um pedido*: PUT​ /pedidos/{id}
- *Remover os dados de um pedido*: DELETE​ /pedidos/{id}
- *Enviar pedido por Email*: POST​ /pedidos/{id}/sendmail
- *Gerar Pedido em PDF*: POST​ /pedidos/{id}/report