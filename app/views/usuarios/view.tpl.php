<div class="container">
	<div class="row">

		<div class="col">
		
			<div class="alert alert-primary" role="alert">
				<h1 class="text-center">Visualizar Usuário</h1>
			</div>
			<?php 
			
			//( isset($_POST) ) ? var_dump($_POST['USUARIOS']) : '';

			if(isset($data)):
        $table = '<table class="table table-striped table-bordered">';
        $table .= '<tbody>';
        foreach ($data as $key => $valueArray) {
          foreach ($valueArray as $field => $data) {
            $table .= '<tr>';
            $table .= '<td>' .$field. '</td>';
            $table .= '<td>' .$data. '</td>';
            $table .= '</tr>';
          }
          
        }
        $table .= '</tbody>';
        $table .= '</table>';
        echo $table;
        echo '<a class="btn btn-md btn-success" href="../index/"> Voltar</a> ';
      else:
		  	echo "<p class=\"bg-danger\">Não Existe Esse Dado!</p>";
      endif;
      ?>
		</div>

	</div>
</div>