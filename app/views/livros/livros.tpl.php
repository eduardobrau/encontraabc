    <ul>
<?php foreach($data as $livro) { ?>
        <li><?php echo $livro['titulo'] ?> (<a href="index.php?module=compras&action=adicionar&id=<?php echo $livro['id'] ?>">Comprar</a>)</li>
<?php } ?>
    </ul>
