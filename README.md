# Carlexis

## Sobre a aplicação

a aplicação busca carros em um site e salva os no banco de dados, listagem de carros, excluir carro

## Ferramentas usadas

-   laravel 8.x
-   bootstrap 4.6
-   jquery 3.5
-   sweetalert 2

## Requisitos

-   php 7.4
-   composer 2.0
-   mysql
-   node
-   npm

## Configuração

copie e renomei o .env.example para .env

verifique as configurações do banco de dados, edite se necessário

DB_CONNECTION=mysql

DB_DATABASE=uplexis

## Instalação

instalando dependencias do composer

```bash
    $ composer install
```

instalando dependencias do npm

```bash
    $ npm install
```

## Inicialização

Compiling laravel mix

```bash
    $ npm run dev
```

criar tabelas no banco de dados

```bash
    $ php artisan migrate:install
    $ php artisan migrate:refresh
```

criar usuario padrao

```bash
    $ php artisan db:seed --class=UserSeeder
```

-   email: admin@admin.com
-   nome: admin
-   senha: admin

### Iniciar servidor

```bash
    $ php artisan serve
```

ip e porta padrão

-   localhost:8000
