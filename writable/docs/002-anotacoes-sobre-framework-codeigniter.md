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

## SQLite e FOREIGN KEY constraint failed

Ao rodar testes unitários em um banco de dados SQLite me deparei com o seguinte erro ao tentar deletar um 'contato' avulso: FOREIGN KEY constraint failed
Ao pesquisar, descobrir se tratar de 'restrições de chave estrangeira'
     https://www.sqlite.org/pragma.html#pragma_foreign_keys
     https://www.sqlite.org/foreignkeys.html
          "Restrições de chave estrangeira SQL são usadas para impor relacionamentos "exists" entre tabelas".

Sua função é garantir a integridade do banco de dados. Com este PRAGMA habilitado, crie-se um relacionamento mais rigoroso entre chaves estrangeiras. Assim só posso setar chaves estrangeiras numa tabela que realmente existam na outra tabela, bem como não posso deletar linhas os quais tenham chaves estrangeiras atribuidas em outra tabela (como em tabelas N:N).
No meu caso, com este PRAGMA habilitado, não posso excluir uma linha na tabela 'contato' que esteja atribuido na tabela 'campanhas_contatos_templates' (tabela N:N). Neste caso exigiria resolver/deletar os relacionamentos na tabela 'campanhas_contatos_templates' para depois deletar a linha na tabela 'contato'

Algumas alternativas são:
- Atualizar/Deletar chaves estrangeiras em outras tabelas
- Incluir ON DELETE CASCADE na sua definição de chave estrangeira para que seja deletado automaticamente
- Desabilitar esta restrição. Este PRAGMA vem desabilitado por padrão no SQLite, porém está habilitado nas configurações de banco de dados de teste do CodeIgniter (app/Config/Database.php). Para habilitar ou desabilitar use a seguinte linha no .env
     database.tests.foreignKeys = false|true

## Usar a mesma view e form para criar e editar

Exemplo: <input type="text" name="nome" value="<?= set_value('nome', @$nome) ?>">
     https://codeigniter.com/user_guide/helpers/form_helper.html#set_value
Explicação: o valor setado OU será o que está no retorno 'withInput()' dos dados submetidos que falharam durante a validação dos dados no controller (função old que está incluso em set_value) OU será setado o segundo parâmetro de set_value, que no caso é o que veio do controller normalmente. Está suprimido erro com @ pois este valor só será enviado para a view apenas se for para edição (para criação não virá valor)

## Reflexões sobre rodar uma mesma aplicação no SQLite e no MySQL

A aplicação está sendo desenvolvida e testada utilizando banco de dados SQLite.
Ao tentar fazer o deploy da aplicação utilizando banco de dados MySQL, alguns testes unitários começaram a falhar

### Diferenças entre queries de SQLite e MySQL

Usando os bancos de dados "no padrão de fábrica", vejo que MySQL é mais rigoroso quanto as queries do que SQLite. Veja algumas queries e como cada banco de comportou:

```sql
SELECT camp.id, camp.nome, camp.data_criacao, stat.nome as status_nome FROM campanhas as camp, campanhas_status as stat WHERE camp.campanhas_status_id == stat.id
```
SQLite aceitou esta query. MySQL não aceitou por causa do ==:
*You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '= stat.id' at line 1*

A solução que usei aqui foi padronizar a query no padrão MySQL

```sql
INSERT INTO "campanhas_contatos_templates" ("id", "campanhas_id", "contatos_id", "templates_id") VALUES (NULL, 1, 1, 1)
```
SQLite aceitou esta query. MySQL não aceitou por causa das aspas duplas:
*You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '"campanhas_contatos_templates" ("id", "campanhas_id", "contatos_id", "templat...' at line 1*

A solução foi padronizar a query no padrão MySQL, colocando ` ao invés de "

### Diferenças no retorno das consultas entre SQLite e MySQL

Ainda usando os bancos de dados "no padrão de fábrica", vejo que cada pode retornar tipos diferentes, o que pode quebrar alguns testes unitários:

```
--- Expected
+++ Actual
@@ @@
 Array &0 (
-    'id' => 1
+    'id' => '1'
     'nome' => 'Laura Marta Cordeiro Sobrinho'
     'email' => 'reinaldo77@example.com'
 )
```
SQLite retornou id como tipo inteiro: teste ok.
Já MySQL retornou id como tipo string: teste falhou.

Neste caso, o teste usava 'assertSame' (que faz uma verificação incluindo o tipo, estilo ===) e a solução aqui foi trocar para 'assertEquals' (que faz uma verificação ==)

```
--- Expected
+++ Actual
@@ @@
 Array (
     0 => 'id'
     1 => 'nome'
-    2 => 'mensagem'
-    3 => 'assunto'
+    2 => 'assunto'
+    3 => 'mensagem'
 )
```

Aqui temos um array igual porém fora de ordem esperada. Isso ocorreu pois uma Migration no CodeIgniter para fazer 'alter table' possui o parâmetro 'after' (que funciona apenas no MySQL) para determinar a ordem que a coluna será incluida na tabela. Assim, se o teste rodar contra o banco de dados SQLite ele será ok, mas falhará caso rode contra o banco MySQL.

Neste caso, o teste usava 'assertEquals' para comparar os arrays, a solução aqui foi trocar para 'assertEqualsCanonicalizing' que [faz um sort nos arrays antes da comparação](https://docs.phpunit.de/en/10.5/assertions.html#assertequalscanonicalizing)

### Então fica os aprendizados

1. Crie testes para sua aplicação, no mínimo o "caminho feliz". É muito bom saber que não há nenhuma funcionalidade quebrada na sua aplicação.

2. Vários fatores podem contribuir para que sua aplicação se comporte de maneira diferente: o ambiente operacional que está, o contexto, as dependências que usa, as tecnologias integradas, etc. 

3. É importante entender como funcionam queries SQL cruas, porém no fim das contas é importante usar alguma camada de abstração de banco de dados, como Data Abstraction Layer, ORM, etc. Estas camadas cuidam destas particularidades que cada banco de dados possui.