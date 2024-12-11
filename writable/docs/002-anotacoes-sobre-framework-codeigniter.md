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

## Reflexões sobre criar um campo 'assunto' na entidade 'template'

- Qual a melhor forma de atualizar o aplicativo criando um novo campo?
     1. Migration: Qual a melhor forma de fazer isso?
          - Opção A: Devo atualizar a migration CREATE TABLE apenas adicionando um novo campo 'assunto'? Penso que se a 'Opção A' (mais simples) seria mais indicada caso o App não fosse lançado, pois bastaria atualizar a migration, usar um migrate:refresh (deletaria dados de teste no banco de dados) e pronto.
          - Opção B: Devo criar uma nova migration com ALTER TABLE adicionando um novo campo 'assunto'? A 'Opção B' (mais complexa) seria mais indicada caso o App esteja em produção. Neste caso necessitaria adicionar o campo 'assunto' e replicar os mesmos dados do campo 'nome' para não 'quebrar o App'. O envio de email usa o campo 'nome' da campanha, agora vai usar o campo 'assunto' do template e, portanto, este não pode estar vazio.
          - Penso que a 'opção B' é a melhor alternativa, pois abrange tanto o App em desenvolvimento quanto em produção.
     2. Um passo-a-passo
          - criar migration
          - atualizar seeds
          - atualizar as etapas do CRUD no controller
          - atualizar as etapas do CRUD no view
          - atualizar as etapas do CRUD no model
          - atualizar as etapas dos objetos relacionados (como CampanhaModel.php)
          - rodar migration criada
          - rodar seed de teste
          - fazer testes