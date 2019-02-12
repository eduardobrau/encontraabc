<?php 
$controller = core\Uri::retController();  
//echo "<pre>"; print_r($uri); echo "</pre>";
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
						<h1 class="text-center">Lista de <?=strtolower($controller)?></h1>
					</div>

					<a class="btn btn-success" href="/<?=strtolower($controller)?>/create">Nova Cidade</a>
					<!-- .TABLE-RESPONSIVE -->
					<div class="table-responsive">
						<?php
						$table = "<table class=\"data-list table table-sm table-striped\">";
						$table .= "<thead>";
						$table .= "<tr>";
						$table .= "<th>#</th><th>ID</th><th>Cidade</th><th>Slug</th><th>Ações</th>";
						$table .= "</tr>";
						$table .= "</thead>";
						if( $data['cidades'] ):
							$i=1;
							foreach( $data['cidades'] as $cidade) {
								$table .= "<tr>"; 
								$table .= "<td>" .$i. "</td>";
								$table .= "<td>" .$cidade['id']. "</td>";
								$table .= "<td>" .$cidade['cidade']. "</td>";
								$table .= "<td>" .$cidade['slug']. "</td>";
								$table .= "<td>";
								$table .= "<a class=\"btn btn-xs btn-success\" href='/" .strtolower($controller). "/view/?id=".$cidade['id']."'><span class='fa fa-eye'></span></a>";
								$table .= "<a class=\"btn btn-xs btn-warning\" href='/" .strtolower($controller). "/edit/?id=".$cidade['id']."'><span class='fa fa-pencil'></span></a>";
								$table .= "<button class=\"btn btn-xs btn-danger delete\" href='#' data-id=\"".$cidade['id']."\" data-url=\"/".strtolower($controller)."/delete\" data-title=\"".$cidade['cidade']."\"><span class='fa fa-trash'></span></button>";
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