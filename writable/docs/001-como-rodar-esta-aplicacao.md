# 001 - Como rodar esta aplicação

## instale php

confirme com php -v

para usar sqlite habilite as extensoes no php (arquivo .ini), descomente linhas do php.ini: devem ficar assim
	extension=pdo_sqlite
	extension=sqlite3

## git clone

TODO

## composer init

TODO

## crie banco de dados 

### sqlite

php spark db:create data --ext sqlite

### mysql

TODO

## configure parâmetros do banco de dados

arquivo app/Config/Database.php
ou
.env

## rode migrations

TODO

## rode seeds

TODO

## rode o ambiente

php spark serve

