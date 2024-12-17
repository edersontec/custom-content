<!-- CONTENT -->

<div class="container-md">

    <section>

        <?= validation_list_errors() ?>

        <?= form_open('campanhas/salvar') ?>
            
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" aria-describedby="nomeHelp" value="<?= set_value('nome', @$nome) ?>">
                <div id="nomeHelp" class="form-text">Digite nome da campanha</div>
            </div>

            <div class="mb-3">
                <label for="idsContatosSelecionados[]" class="form-label">Selecione contatos para esta campanha</label>
                <?php foreach ($contatos as $item): ?>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="idsContatosSelecionados[]"
                            value="<?= $item['id'] ?>"
                            id="flexCheckDefault<?= $item['id'] ?>"
                            <?php
                                $idsContatosSelecionados = set_value('idsContatosSelecionados', @$idsContatosSelecionados) ?? [];
                                echo( in_array($item['id'], $idsContatosSelecionados) ? "checked" : "" );
                            ?>
                        />
                        <label class="form-check-label" for="flexCheckDefault<?= $item['id'] ?>">
                        <?php echo $item['nome'] . " (" . $item['email'] . ")" ?>
                        </label>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="mb-3">
                <label for="idsTemplatesSelecionados[]" class="form-label">Selecione template para esta campanha</label>
                <select class="form-select" name="idsTemplatesSelecionados[]" size="<?php echo count($templates) ?>" aria-label="Size 3 select example">
                    <?php foreach ($templates as $item): ?>
                        <option
                            value="<?= $item['id'] ?>"
                            <?php
                                $idsTemplatesSelecionados = set_value('idsTemplatesSelecionados', @$idsTemplatesSelecionados) ?? [];
                                echo( in_array($item['id'], $idsTemplatesSelecionados) ? "selected" : "" );
                            ?>
                        >
                            <?php echo $item['id'] . " - " . $item['nome'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <input type="hidden" name="data_criacao" value="<?= set_value('data_criacao', @$data_criacao) ?>">
            <input type="hidden" name="id" value="<?= set_value('id', @$id) ?>">
            <input type="hidden" name="campanhas_status_id" value="<?= set_value('campanhas_status_id', @$campanhas_status_id) ?>">

            <a href="/campanhas" class="btn btn-secondary">Voltar</a>
            <button type="submit" class="btn btn-primary">Salvar</button>

        <?= form_close() ?>

    </section>

</div>