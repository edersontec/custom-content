<!-- CONTENT -->

<section>

    <!--<h1><?= esc($title) ?></h1>-->

    <?= validation_list_errors() ?>

    <?= form_open('templates/salvar') ?>
        
        <p>Nome: 
            <input type="text" name="nome" value="<?= set_value('nome', @$nome) ?>">
        </p>

        <p>Assunto: 
            <input type="text" name="assunto" value="<?= set_value('assunto', @$assunto) ?>">
        </p>
        
        <p>Mensagem: 
            <textarea name="mensagem" rows="4" cols="50"><?= set_value('mensagem', @$mensagem) ?></textarea>
        </p>
        
        <input type="hidden" name="id" value="<?= set_value('id', @$id) ?>">

        <p><input type="submit" name="" value="Confirmar"></p>
    
    <?= form_close() ?>

</section>