<!-- CONTENT -->

<section>

    <!--<h1><?= esc($title) ?></h1>-->

    <?= validation_list_errors() ?>

    <?= form_open('contatos/salvar') ?>
        
        <p>Nome: 
            <input type="text" name="nome" value="<?= set_value('nome', @$nome) ?>">
        </p>

        <p>Email: 
            <input type="text" name="email" value="<?= set_value('email', @$email) ?>">
        </p>
        
        <input type="hidden" name="id" value="<?= set_value('id', @$id) ?>">

        <p><input type="submit" name="" value="Confirmar"></p>
    
    <?= form_close() ?>

</section>