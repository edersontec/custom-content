<!-- CONTENT -->

<section>

    <!--<h1><?= esc($title) ?></h1>-->

    <form action="/contatos/salvar" method="POST">
        
        <p>nome: <input type="text" name="nome" value="<?php if (isset($nome)) echo $nome; ?>"></p>
        <p>email: <input type="text" name="email" value="<?php if (isset($email)) echo $email; ?>"></p>
        
        <?php if (isset($id))
            echo '<input type="hidden" name="id" value="'.$id.'">';
        ?>

        <p><input type="submit" name="" value="Confirmar"></p>
    </form>

</section>