# Testes Pest Laravel para CRUD de Produtos
Este repositório contém testes automatizados desenvolvidos com o Pest para garantir o correto funcionamento de um CRUD (Create, Read, Update, Delete) para entidades de produtos em um aplicativo Laravel.

## Pré-requisitos
Certifique-se de ter o ambiente de desenvolvimento configurado com o Laravel e o Pest. Para instalar as dependências, execute:
```bash
composer install
```

Para executar os testes em uma instância de banco de dados isolada do ambiente de desenvolvimento/produção:
```bash
# Criação do usuário 'root_testing' com senha 'root_testing'
CREATE USER 'root_testing'@'localhost' IDENTIFIED BY 'root_testing';

# Criação do banco de dados 'laravel_pest_api_testing'
CREATE DATABASE laravel_pest_api_testing;

# Concessão de todas as permissões para o usuário 'root_testing' no banco de dados 'laravel_pest_api_testing'
GRANT ALL ON laravel_pest_api_testing.* TO 'root_testing'@'localhost';

# Crie o arquivo de variáveis de ambiente de testing
cp .env.example .env.testing
```

Edite o arquivo .env.testing com as credenciais que foram criadas:
```bash
APP_ENV=testing

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_pest_api_testing
DB_USERNAME=root_testing
DB_PASSWORD=root_testing
```

## Execução
Execute o comando para inicializar os testes:
```bash
php artisan test
```
<img src="https://i.ibb.co/jJjG1qB/pest.png">
