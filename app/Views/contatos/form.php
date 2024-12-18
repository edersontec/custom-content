<!-- CONTENT -->

<section>
    
    <div class="container-md">

        <?= validation_list_errors() ?>

        <?= form_open('contatos/salvar') ?>

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" aria-describedby="nomeHelp" value="<?= set_value('nome', @$nome) ?>">
                <div id="nomeHelp" class="form-text">Digite nome do contato</div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="<?= set_value('email', @$email) ?>">
                <div id="emailHelp" class="form-text">Digite email do contato</div>
            </div>
            
            <input type="hidden" name="id" value="<?= set_value('id', @$id) ?>">

            <a href="/contatos" class="btn btn-secondary">Voltar</a>
            <button type="submit" class="btn btn-primary">Salvar</button>

        
        <?= form_close() ?>

    </div>
    
</section>
