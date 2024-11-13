# 002 - Anotações sobre framework CodeIgniter

## Sobre o recurso 'Model'

Model no CodeIgniter 4 pode ser considerado uma espécie de DAO (Data Access Object). Tem como principal responsabilidade fornecer uma camada de acesso aos dados.

## Sobre o recurso 'Entity'

Entity no CodeIgniter 4 pode ser considerado uma espécie de ORM (Object-Relational Mapping), mas com um foco mais simplificado.

## Database migrate: explicação dos comandos

migrate - monta banco de dados apenas, acionando método up() das migrations
migrate:rollback - desmonta banco de dados apenas, acionando método down() das migrations
migrate:refresh - desmonta e monta: faz o 'migrate:rollback' e depois faz o 'migrate'
migrate:status - gera um relatório dos estados da migrations
