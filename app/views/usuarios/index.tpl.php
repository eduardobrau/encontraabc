<?php 
$controller = core\Uri::retController(); 
//echo "<pre>"; print_r($data); echo "</pre>";
?>

<section class="wrapper-content <?=strtolower($controller)?>">
	<div class="main">	
		<!-- CONTAINER -->
		<div class="container">
			<!-- ROW -->
			<div class="row">
				<!-- COL -->
				<div class="col">

					<div class="alert title alert-primary" role="alert">
						<h1 class="text-center">Lista de <?=$controller;?></h1>
					</div>

					<a class="btn btn-success" href="/<?=strtolower($controller)?>/create">Novo Usuário</a>
					<!-- .TABLE-RESPONSIVE -->
					<div class="table-responsive">
						<?php
						$table = "<table class=\"data-list table table-sm table-striped\">";
						$table .= "<thead>";
						$table .= "<tr>";
						$table .= "<th>#</th><th>ID</th><th>Usuário</th><th>Email</th><th>Ativo</th><th>Ações</th>";
						$table .= "</tr>";
						$table .= "</thead>";
						if( $data['usuarios'] ):
							$i=1;
							foreach( $data['usuarios'] as $usuario) {
								$table .= "<tr>"; 
								$table .= "<td>" .$i. "</td>";
								$table .= "<td>" .$usuario['id']. "</td>";
								$table .= "<td>" .$usuario['usuario']. "</td>";
								$table .= "<td>" .$usuario['email']. "</td>";
								$table .= "<td>" .$usuario['ativo']. "</td>";
								$table .= "<td>";
								$table .= "<a class=\"btn btn-xs btn-success\" href='/" .strtolower($controller). "/view/?id=".$usuario['id']."'><span class='fa fa-eye'></span></a>";
								$table .= "<a class=\"btn btn-xs btn-warning\" href='/" .strtolower($controller). "/edit/?id=".$usuario['id']."'><span class='fa fa-pencil'></span></a>";
								$table .= "<button class=\"btn btn-xs btn-danger delete\" href='#' data-id=\"".$usuario['id']."\" data-title=\"".$usuario['usuario']."\"><span class='fa fa-trash'></span></button>";
								$table .="</td>";
								$table .= "</tr>";
								$i++;
							}
						endif;
						$table .= "</table>";
						echo $table;
						echo $data['nav'];
						?>
					</div>
					<!--./ TABLE-RESPONSIVE -->
					
				</div>
				<!--./ COL -->
			</div>
			<!--./ ROW -->
		</div>
		<!--./ CONTAINER -->
	</div>
</section>