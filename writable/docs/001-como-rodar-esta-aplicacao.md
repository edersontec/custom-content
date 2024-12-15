# 001 - Como rodar esta aplicação

## instale php

confirme com php -v

para usar sqlite habilite as extensoes no php (arquivo .ini), descomente linhas do php.ini: devem ficar assim
	extension=pdo_sqlite
	extension=sqlite3


## git clone

TODO


## composer install

TODO


## configure variáveis de ambiente no arquivo .env

### configurações iniciais

CI_ENVIRONMENT
app.baseURL

### configure o banco de dados 

#### sqlite

php spark db:create data --ext sqlite
coloque na pasta /writable/db/data.sqlite

php spark db:create tests --ext sqlite
coloque na pasta /writable/db/tests.sqlite
ou defina o banco de dados sqlite como ':memory:'

### mysql

instale mysql, rode o serviço, crie uma database
no arquivo .env, descomente as linhas e adicione as configurações do seu banco de dados mysql

### configure serviço de envio de emails SMTP

TODO

#### teste serviço de envio de emails SMTP

php public\index.php testarenvioemail


## rode migrations

php spark migrate


## rode seed obrigatória (dados predefinidos essenciais para o funcionamento da aplicação)

php spark db:seed AppDataSeeder


## rode seed opcional (caso queira popular o banco com dados de exemplo)

php spark db:seed TestSeeder


## rode o ambiente

php spark serve

