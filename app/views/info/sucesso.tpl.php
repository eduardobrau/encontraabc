<?php 
$controller = core\Uri::retController(); 
if( empty($_SESSION['idSaved']) ){
  $_SESSION['idSaved'] = $data['id'];
}
?>
<section class="error" style="min-height:500px;">  
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="success-template" style="text-align: center;">
          <div class="alert alert-primary title" role="alert">  
            <h1 class="title">Operação realizada com sucesso!</h1>
          </div>
          <div class="success-details">
              <?php 
                if(isset($data)):
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
                else:
                  echo "<p class=\"bg-danger\">Não Existe Esse Dado!</p>";
                endif;
              ?>
          </div>
          <div class="error-actions" style="margin-top:15px;margin-bottom:15px;">
              <a href="/" class="btn btn-primary btn-lg" 
                style="margin-right:10px;">
                <span class="fa fa-home"></span>
                Pagina Inicial 
              </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>