<!-- CONTENT -->

<section>

    <div class="container-md">

        <?= validation_list_errors() ?>

        <?= form_open('templates/salvar') ?>
            
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" aria-describedby="nomeHelp" value="<?= set_value('nome', @$nome) ?>">
                <div id="nomeHelp" class="form-text">Digite nome do template</div>
            </div>

            <div class="mb-3">
                <label for="assunto" class="form-label">Assunto</label>
                <input type="text" class="form-control" id="assunto" name="assunto" aria-describedby="assuntoHelp" value="<?= set_value('assunto', @$assunto) ?>">
                <div id="assuntoHelp" class="form-text">Digite assunto do template (Este campo aceita tags de contato como {id}, {nome} e {email})</div>
            </div>

            <div class="mb-3">
                <label for="mensagem" class="form-label">Mensagem</label>
                <textarea class="form-control" id="mensagem" name="mensagem" rows="6" aria-describedby="mensagemHelp"><?= set_value('mensagem', @$mensagem) ?></textarea>
                <div id="mensagemHelp" class="form-text">Digite mensagem do template (Este campo aceita tags de contato como {id}, {nome} e {email})</div>
            </div>
            
            <input type="hidden" name="id" value="<?= set_value('id', @$id) ?>">

            <a href="<?= base_url('templates') ?>" class="btn btn-secondary">Voltar</a>
            <button type="submit" class="btn btn-primary">Salvar</button>
        
        <?= form_close() ?>

    </div>

</section>
