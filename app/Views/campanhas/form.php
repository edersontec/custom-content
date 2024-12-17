<!-- CONTENT -->

<section>

    <!--<h1><?= esc($title) ?></h1>-->

    <?= validation_list_errors() ?>

    <?= form_open('campanhas/salvar') ?>
        
        <p>Nome: 
            <input type="text" name="nome" value="<?= set_value('nome', @$nome) ?>">
        </p>

        <fieldset>
            <legend>Selecione Contatos:</legend>
            <ul>
                
                <?php foreach ($contatos as $item): ?>
                    <li>
                        <input
                            type="checkbox"
                            name="idsContatosSelecionados[]"
                            value="<?= $item['id'] ?>"
                            <?php
                                $idsContatosSelecionados = set_value('idsContatosSelecionados', @$idsContatosSelecionados) ?? [];
                                echo( in_array($item['id'], $idsContatosSelecionados) ? "checked" : "" );
                            ?>
                        />
                        <?php echo implode(", ", $item) ?>  
                    </li>
                <?php endforeach ?>

            </ul>

        </fieldset>

        <fieldset>
            <legend>Selecione Templates:</legend>
            <select name="idsTemplatesSelecionados[]" size="<?php echo count($templates) ?>">
                
                <?php foreach ($templates as $item): ?>
                    <option
                        value="<?= $item['id'] ?>"
                        <?php
                            $idsTemplatesSelecionados = set_value('idsTemplatesSelecionados', @$idsTemplatesSelecionados) ?? [];
                            echo( in_array($item['id'], $idsTemplatesSelecionados) ? "selected" : "" );
                        ?>
                    >
                        <?php echo implode(", ", $item) ?>
                    </option>
                <?php endforeach ?>

            </select>

        </fieldset>

        <input type="hidden" name="data_criacao" value="<?= set_value('data_criacao', @$data_criacao) ?>">
        <input type="hidden" name="id" value="<?= set_value('id', @$id) ?>">
        <input type="hidden" name="campanhas_status_id" value="<?= set_value('campanhas_status_id', @$campanhas_status_id) ?>">

        <p><input type="submit" name="" value="Confirmar"></p>

    <?= form_close() ?>

</section>