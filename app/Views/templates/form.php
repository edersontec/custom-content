<!-- CONTENT -->

<section>

    <!--<h1><?= esc($title) ?></h1>-->

    <form action="/templates/salvar" method="POST">
        
        <p>nome: 
            <input type="text" name="nome" value="<?php if (isset($nome)) echo $nome; ?>">
        </p>
        
        <p>mensagem: 
            <textarea name="mensagem" rows="4" cols="50"><?php if (isset($mensagem)) echo $mensagem; ?></textarea>
        </p>
        
        <?php if (isset($id))
            echo '<input type="hidden" name="id" value="'.$id.'">';
        ?>

        <p><input type="submit" name="" value="Confirmar"></p>
    </form>

</section>