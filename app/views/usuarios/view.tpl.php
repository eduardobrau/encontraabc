<?php 
$controller = core\Uri::retController(); 
//echo "<pre>"; print_r($data); echo "</pre>";
?>
<section class="wrapper-content <?=strtolower($controller)?>">
	<div class="main"> 
    <div class="container">
      <div class="row">

        <div class="col">
        
          <div class="alert title alert-primary" role="alert">
            <h1 class="text-center">Visualizar <?=ucfirst($controller)?></h1>
          </div>
          <?php 
          
          //( isset($_POST) ) ? var_dump($_POST['USUARIOS']) : '';

          if(!empty($data)):
            $table = '<table class="table table-striped table-bordered">';
            $table .= '<tbody>';
            foreach ($data as $key => $valueArray) {
              $table .= '<tr>';
              $table .= '<td>' .$key. '</td>';
              $table .= '<td>' .$valueArray. '</td>';
              $table .= '</tr>';
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
  </div>
</section>
