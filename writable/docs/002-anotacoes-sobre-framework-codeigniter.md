# 002 - Anotações sobre framework CodeIgniter

## Sobre o recurso 'Model'

Model no CodeIgniter 4 pode ser considerado uma espécie de DAO (Data Access Object). Tem como principal responsabilidade fornecer uma camada de acesso aos dados.

## Sobre o recurso 'Entity'

Entity no CodeIgniter 4 pode ser considerado uma espécie de ORM (Object-Relational Mapping), mas com um foco mais simplificado.

## Database migrate: explicação dos comandos

migrate - monta banco de dados apenas, acionando método up() das migrations. Se criar uma nova migration, use esta opção
migrate:rollback - desmonta banco de dados apenas, acionando método down() das migrations
     php spark migrate:rollback -b 1 : exemplo de rolllback que volta para o batch 1
migrate:refresh - desmonta e monta: faz o 'migrate:rollback' e depois faz o 'migrate'
migrate:status - gera um relatório dos estados da migrations

## Sobre arquivo .env

Arquivo em texto com as variáveis de ambiente. Todas as variáveis definidas neste arquivo serão mescladas/sobrescritas nos arquivos de configurações (arquivos na pasta /App/Config/)
- Exemplo: como setar configurações de mail https://forum.codeigniter.com/showthread.php?tid=81816

## Como apontar o banco de dados sqlite no arquivo .env

Use o caminho relativo até o arquivo .sqlite
- Exemplo: database.default.database = '../writable/db/data.sqlite'
