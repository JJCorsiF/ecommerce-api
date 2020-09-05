# E-commerce API

Esta é uma API RESTful de exemplo para um sistema de E-commerce. Foi desenvolvida e testada usando o PHP 7.3, utilizando o framework Laravel.

## Setup
Para instalar a aplicação, acesse o diretório onde a aplicação rodará e clone a aplicação:

```bash
$ git clone git@github.com:JJCorsiF/ecommerce-api.git
```

## Configurando a aplicação
Para que a aplicação possa funcionar corretamente, é necessário ter um banco de dados MySQL criado e rodando e um usuário com acesso a ele.

Para configurar a aplicação, copie o arquivo **.env.testing** e renomeie-o para **.env**. Em seguida, substitua o trecho abaixo com as informações do banco de dados e do servidor de email.

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
Para instalar as dependências da aplicação, será necessário ter o Composer instalado. Para instalar as dependências, digite:

```bash
$ composer install
$ php artisan key:generate
$ php artisan migrate
```

## Acessando a aplicação
Para iniciar a aplicação, execute o comando:

```bash
$ php artisan serve
```

A aplicação iniciará e a API estará disponível em http://127.0.0.1:8000/. Para acessar a rota de clientes, poe exemplo, basta acessar http://127.0.0.1:8000/clientes.

As seguintes rotas estão disponíveis:

GET​ /clientes

GET​ /clientes/{id}

POST​ /clientes

PUT​ /clientes/{id}

DELETE ​/clientes/{id}

GET​ /produtos

GET​ /produtos/{id}

POST​ /produtos

PUT​ /produtos/{id}

DELETE​ /produtos/{id}

GET​ /pedidos

GET​ /pedidos/{id}

POST​ /pedidos

PUT​ /pedidos/{id}

DELETE​ /pedidos/{id}

POST​ /pedidos/{id}/sendmail

POST​/pedidos/{id}/report