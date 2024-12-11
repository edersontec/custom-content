<!-- CONTENT -->

<section>

    <!--<h1><?= esc($title) ?></h1>-->



    <form action="/campanhas/salvar" method="POST">
        
        <p>nome: 
            <input type="text" name="nome" value="<?php if (isset($nome)) echo $nome; ?>">
        </p>

        <p>data_criacao: 
            <input type="text" name="data_criacao" value="<?php if (isset($data_criacao)) echo $data_criacao; ?>">
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
                            <?php echo( isset($idsContatosSelecionados) && in_array($item['id'], $idsContatosSelecionados) ? "checked" : "" ) ?>
                        />
                        <?php echo implode(", ", $item) ?>  
                    </li>
                <?php endforeach ?>

            </ul>
            <!-- <pre><?php print_r($contatos); ?></pre> -->
        </fieldset>



        <fieldset>
            <legend>Selecione Templates:</legend>
            <select name="idsTemplatesSelecionados[]" size="<?php echo count($templates) ?>">
                
                <?php foreach ($templates as $item): ?>
                    <option
                        value="<?= $item['id'] ?>"
                        <?php echo( isset($idsTemplatesSelecionados) && in_array($item['id'], $idsTemplatesSelecionados) ? "selected" : "" ) ?>
                    >
                        <?php echo implode(", ", $item) ?>
                    </option>
                <?php endforeach ?>

            </select>
            <!-- <pre><?php print_r($templates); ?></pre> -->
        </fieldset>

        
        <?php if (isset($id))
            echo '<input type="hidden" name="id" value="'.$id.'">';
        ?>

        <?php if (isset($campanhas_status_id))
            echo '<input type="hidden" name="campanhas_status_id" value="'.$campanhas_status_id.'">';
        ?>

        <p><input type="submit" name="" value="Confirmar"></p>
    </form>

</section>