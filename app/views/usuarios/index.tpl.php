<!-- CONTAINER -->
<div class="container">
  <!-- ROW -->
	<div class="row">
    <!-- COL -->
		<div class="col">

      <!-- <div class="alert alert-primary" role="alert"> -->
			<div class="alert" role="alert">
				<h1 class="text-center">Lista de Usuários</h1>
			</div>

		  <a class="btn btn-success" href="/app_php/usuarios/create.php">Novo Usuário</a>
			<!-- .TABLE-RESPONSIVE -->
			<div class="table-responsive">
				<?php
				$table = "<table class=\"data-list table table-sm table-striped\">";
				$table .= "<thead>";
				$table .= "<tr>";
				$table .= "<th>#</th><th>ID</th><th>Usuário</th><th>Senha</th><th>Email</th><th>Ações</th>";
				$table .= "</tr>";
				$table .= "</thead>";
				if( $data ):
					$i=1;
					foreach( $data as $usuario) {
						$table .= "<tr>"; 
						$table .= "<td>" .$i. "</td>";
						$table .= "<td>" .$usuario['id']. "</td>";
						$table .= "<td>" .$usuario['usuario']. "</td>";
						//$table .= "<td>" .$data[$i]['description']. "</td>";
						$table .= "<td>" .$usuario['senha']. "</td>";
						$table .= "<td>" .$usuario['email']. "</td>";
						$table .= "<td>";
						$table .= "<a class=\"btn btn-xs btn-success\" href='/usuarios/view/?id=".$usuario['id']."'><span class='fa fa-eye'></span></a>";
						$table .= "<a class=\"btn btn-xs btn-warning\" href='/usuarios/edit/edit.exe?id=".$usuario['id']."'><span class='fa fa-pencil'></span></a>";
						$table .= "<a class=\"btn btn-xs btn-danger delete\" href='#' data-id=\"".$usuario['id']."\" data-title=\"".$usuario['usuario']."\"><span class='fa fa-trash'></span></a>";
						$table .="</td>";
						$table .= "</tr>";
						$i++;
					}
				endif;
				$table .= "</table>";
				echo $table;
				?>
		  </div>
			<!--./ TABLE-RESPONSIVE -->
			
		</div>
    <!--./ COL -->
	</div>
  <!--./ ROW -->
</div>
<!--./ CONTAINER -->