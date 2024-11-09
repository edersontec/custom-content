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
                            name="contatosSelecionados[]"
                            value="<?= $item['id'] ?>"
                            <?php echo( isset($arrayIdsContatosSelecionados) && in_array($item['id'], $arrayIdsContatosSelecionados) ? "checked" : "" ) ?>
                        />
                        <?php echo implode(", ", $item) ?>  
                    </li>
                <?php endforeach ?>

            </ul>
            <!-- <pre><?php print_r($contatos); ?></pre> -->
        </fieldset>



        <fieldset>
            <legend>Selecione Templates:</legend>
            <select name="templatesSelecionados[]" size="<?php echo count($templates) ?>">
                
                <?php foreach ($templates as $item): ?>
                    <option
                        value="<?= $item['id'] ?>"
                        <?php echo( isset($arrayIdsTemplatesSelecionados) && in_array($item['id'], $arrayIdsTemplatesSelecionados) ? "selected" : "" ) ?>
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

        <p><input type="submit" name="" value="Confirmar"></p>
    </form>

</section>