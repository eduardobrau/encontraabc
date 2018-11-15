<h2>Carrinho de compras</h2>
<?php
if(isset($data)) {
	$total = 0;
?>
<form action="" method="POST">
	<table cellspacing="2" cellpadding="5" border="1">
<?php
	
	foreach($data as $produto) {
		$total += $produto['preco'] * $produto['quantidade'];
		?>
		<tr>
		<td><strong><?php echo $produto['titulo'] ?></strong><input type="hidden" name="produto[]" value="<?php echo $produto['id'] ?>" /></td>
		<td><input type="text" name="quantidade[]" value="<?php echo $produto['quantidade'] ?>" /></td>
		<td><input type="checkbox" name="remover[]" value="<?php echo $produto['id'] ?>" /></td>
		</tr>
		<?php
	}
	
	?>
	<tr>
		<td colspan="3" align="right"><strong>Total:</strong> R$ <?php echo $total ?></td>
		<tr>
			<td colspan="3" align="right">
				<input type="submit" name="compra" value="Finalizar compra" />
				<input type="submit" name="esvaziar" value="Esvaziar carrinho" />
				<input type="submit" name="atualizar" value="Atualizar carrinho" />
			</td>
		</tr>
	</tr>
	</table>
</form>
<?php
} else {
	echo "<p>Não há nada no carrinho.</p>";
}
?>
