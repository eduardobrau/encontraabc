<?php

namespace app\componentes;

use app\componentes\DB;

class Paginacao{

  // A quantidade de itens por página a ser exibida
  private $itensPorPagina;
  //verifica a página atual caso seja informada na URL, senão atribui como 1ª página 
  private $pagina; 
  //variavel para calcular o início da visualização com base na página atual
  private $inicio;
  // Um array com os dados que desejamos fazer a paginação
  private $dados;
  /***    SEGUNDA PARTE DA PAGINAÇÃO      ****/
  //armazena o total de itens
  private $totalIntens;
  private $numPaginas;
  private $anterior;
  private $posterior;

  public function __construct($itensPorPagina){

    $this->itensPorPagina = $itensPorPagina;

    try{
      $this->DB = new DB;
    }catch(Exception $e){
      $error = $e->getMessage() . ' ' . 
        ' do arquivo ' . $e->getFile() . ' ' . 
        ' na linha ' . $e->getLine();
      die($error);
    }

  }
  //Retorna o total de itens a ser paginado.
  public function totalItens($table,$id){
    $total = $this->DB->consultar($table,'id');
    $this->totalItens = $this->DB->numRows;    
    return $this->totalItens;
  }
  //O calculo do Total de página a ser exibido
  public function numPages(){
    $this->numPaginas = ceil($this->totalItens/$this->itensPorPagina);  
    return $this->numPaginas;
  }
  //verifica a página atual caso seja informada na URL, senão atribui como 1ª página
  public function getPage(){
    $this->pagina = ( isset($_GET['pagina']) ) ? (int)$_GET['pagina'] : 1;
    return $this->pagina;
  }
  /**
   * Aqui montará o link que voltará uma pagina
   * Caso o valor seja zero, por padrão ficará o valor 1
   */
  public function getPrev(){
    $this->anterior  = ( ($this->pagina - 1) == 0 ) ? 1 : $this->pagina - 1;
        
    return $this->anterior;
  }
  /** 
   * Aqui montará o link que ir para proxima pagina
   * Caso pagina +1 for maior ou igual ao total, ele terá o valor do total
   * caso contrario, ele pegar o valor da página + 1
   */
  public function getNext(){
    $this->posterior = ( ($this->pagina+1) >= $this->numPaginas ) 
      ? $this->numPaginas 
      : $this->pagina+1;
    return $this->posterior;
  }
  public function showDatas($table,$fields,$conditions=NULL,$like=NULL,$order=NULL){
  
    $this->pagina = $this->getPage();
    
    //variavel para calcular o início da visualização com base na página atual 
    $this->inicio = ( $this->itensPorPagina*$this->pagina ) - $this->itensPorPagina;
            
    $limit = "$this->inicio, $this->itensPorPagina";     
    
    try{
      $this->dados = $this->DB->consultar(
        $table,$fields,$conditions,
        $like,$order,$limit
      );
    }catch(\Exception $e){
      $error = $e->getMessage() . ' ' . 
        ' do arquivo ' . $e->getFile() . ' ' . 
        ' na linha ' . $e->getLine();
      die($error);
    }
            
    return $this->dados;

  }


  public function renderNav(){
    
    $nav = '<nav aria-label="Page navigation example" class="text-center">';        
      $nav .= '<ul class="pagination justify-content-center">';
        $nav .= '<li class="page-item '.( ($this->pagina == 1) ? 'disabled' : "" ).'">';
          $nav .= '<a class="page-link" href="?pagina='.$this->getPrev().'" aria-label="Anterior">';
            $nav .= '<span aria-hidden="true">&laquo;</span>';
            $nav .= '<span class="sr-only">Anterior</span>';
          $nav .= '</a>';
        $nav .= '</li>';
                          
        for($i = 1; $i <= $this->numPages(); $i++){
          $nav .= '<li class="page-item '.(($this->pagina == $i) ? " active" : "").' "><a class="page-link" href="?pagina='.$i.'"> '.$i.' </a></li>';
        } 
          
        $nav .= '<li class="page-item '.( ($this->pagina == $this->numPages()) ? 'disabled' : '' ).'">';
        $nav .= '<a class="page-link" href="?pagina='.$this->getNext().'" aria-label="Próximo">';
          $nav .= '<span aria-hidden="true">&raquo;</span>';
          $nav .= '<span class="sr-only">Próximo</span>';
        $nav .= '</a>';
        $nav .= '</li>';
      $nav .= '</ul>';
    $nav .= '</nav>';
    
    return $nav;

  }


}