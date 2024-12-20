<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Custom Content</title>
    <meta name="description" content="Solução para envio de mensagens personalizadas">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="shortcut icon" type="image/png" href="<?= base_url('imgs/favicon.png') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <?php if (isset($hasIcones) && $hasIcones): ?>
        <!-- inclusão de CSS de icones -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <?php endif; ?>

    <?php if (isset($hasTabelas) && $hasTabelas): ?>
        <!-- inclusão de CSS de tabelas -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css">
    <?php endif; ?>

    <link href="<?= base_url('css/main.css') ?>" rel="stylesheet">

</head>
<body>

<!-- HEADER: MENU + HEROE SECTION -->
<header>

    <div class="menu">
        <ul>
            <li class="logo">
                <a href="<?= base_url() ?>">
                    <img src="<?= base_url('imgs/logo-200x150.png') ?>" alt="Logotipo Custom Content" width="100" height="75">
                </a>
            </li>
            <li class="menu-toggle">
                <button id="menuToggle">&#9776;</button>
            </li>
            <li class="menu-item hidden"><a href="<?= base_url() ?>">Home</a></li>
            <li class="menu-item hidden"><a href="<?= base_url('contatos') ?>">Contatos</a></li>
            <li class="menu-item hidden"><a href="<?= base_url('templates') ?>">Templates</a></li>
            <li class="menu-item hidden"><a href="<?= base_url('campanhas') ?>">Campanhas</a></li>
            </li>
        </ul>
    </div>

    <div class="heroe">

        <h1><?php if(isset($titulo)) echo esc($titulo) ?></h1>

        <p class="text-body-secondary"><em><?php if(isset($subtitulo)) echo esc($subtitulo) ?></em></p>

    </div>

</header>
