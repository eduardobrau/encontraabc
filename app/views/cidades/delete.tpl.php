<div class="container">
	<div class="row">

		<div class="col-md-12">

			<?php if($data):
				$DB->deletar('usuarios', "id='".$_GET['id']."'");
				//var_dump($result);
				header("Location: index.php");	
		  else:
		  	echo "<p class=\"bg-danger\">Não Existe Esse Dado!</p>";
			endif;
		  ?>

		</div>

	</div>
</div>