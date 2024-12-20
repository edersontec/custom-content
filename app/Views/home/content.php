<!-- CONTENT -->

<section>

    <div class="container-md">

        <?= $conteudo ?>

        <div class="card-group">
            
            <div class="card text-center">
                <a href="<?= base_url('contatos') ?>" class="text-decoration-none">
                    <div class="card-body">
                        <i class="bi bi-people-fill" style="font-size: 3rem; color: #3d90e3;"></i>
                        <h3 class="card-title mb-2 text-body-secondary"><?= $total_registros['contatos'] ?></h3>
                    </div>
                </a>
                <div class="card-footer text-body-secondary">Contatos</div>
            </div>

            <div class="card text-center">
                <a href="<?= base_url('templates') ?>" class="text-decoration-none">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-text-fill" style="font-size: 3rem; color: #3d90e3;"></i>
                        <h3 class="card-title mb-2 text-body-secondary"><?= $total_registros['templates'] ?></h3>
                    </div>
                </a>
                <div class="card-footer text-body-secondary">Templates</div>
            </div>

            <div class="card text-center">
                <a href="<?= base_url('campanhas') ?>" class="text-decoration-none">
                    <div class="card-body">
                        <i class="bi bi-send-fill" style="font-size: 3rem; color: #3d90e3;"></i>
                        <h3 class="card-title mb-2 text-body-secondary"><?= $total_registros['campanhas'] ?></h3>
                    </div>
                </a>
                <div class="card-footer text-body-secondary">Campanhas</div>
            </div>

        </div>

    </div>

</section>
