<?php

namespace app\componentes;

class DB{

	private $host = "127.0.0.1:3306";
	private $database = "app_php";
	private $usuario = "root";
	private $senha = "12345";
	private $conexao;

	public function __construct(){

		$this->conectar();	

	}

	public function __destruct(){

		//mysqli_close($this->conexao);

	}

	private function conectar(){

		$this->conexao = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);

		if ( !$this->conexao ) {
			die('<div class="alert alert-danger" role="alert">
				Não foi possível conectar ao mysql: ' 
				. mysqli_connect_error() . '</div>'
			);
			exit();
		}else{
			return $this->conexao;
		}

	}

	public function consultar($table,$campos=FALSE,$where=FALSE,$like=FALSE,$order=FALSE,$limit=FALSE){

		$query = 'SELECT ';

		if( empty($campos) )
			$query.= '*';
		else
		 $query.= $campos;

		$query.= ' FROM ' .'`'.$table.'`';

		if( !empty($where) )
		 $query.= ' WHERE ' .$where;

		if( !empty($like) )
		 $query.= ' LIKE ' .$like;
		
		if( !empty($order) )
		 $query.= ' ORDER BY ' .$order;

		if( !empty($limit) )
		 $query.= ' LIMIT ' .$limit;

		//die($query);

		$result = mysqli_query($this->conexao,$query);

		//var_dump($result->num_rows);die();
		if ( !$result ) {
			die('Query invalida: ' . mysqli_error($this->conexao));
		}else if($result->num_rows >= 1){
			//return var_dump( mysqli_fetch_assoc($result) );
			//$row = mysqli_fetch_assoc($result);
			while( $row =  mysqli_fetch_assoc($result) ){
				$data[] = $row;
			}
			return $data;
		}

		// Free result set
		mysqli_free_result($result);
		

	}

	public function insert($table, $datas=array()){
		
		foreach ($datas as $coluna => $valor) {
			$colunas[]= '`'.$coluna.'`';
			$valores[]= '\''.$valor.'\'';
		}

		$colunas = implode(', ' , $colunas);
		$valores = implode(', ', $valores);

		$sql ='INSERT INTO `'.$table.'` ('.$colunas.') VALUES ('.$valores.')'; 

		//echo $sql;

		if (mysqli_query($this->conexao, $sql)) {
		  echo "<p class=\"bg-success\"> Valores Inserido com Sucesso! </p>";
		  return TRUE;
		} else {
		  echo "<p class=\"bg-danger\"> Error: " . $sql . "<br>" . mysqli_error($this->conexao) . "</p>";
		  return FALSE;
		}

	}

	public function update($table, $datas=array(), $condition){
		
		$sql = "UPDATE `$table` SET ";

		foreach ($datas as $coluna => $valor) {
			$dados[] = ' `'.$coluna.'` = \''.$valor.'\' ';
		}	
		
		$dados = implode(', ' , $dados);

		$sql .= $dados; 
		$sql .= 'WHERE '.$condition;

		if (mysqli_query($this->conexao, $sql)) {
			$msg[0] = TRUE;
			$msg[1] = "<div class=\"alert alert-success\"> <h2 class=\"text-center\">Atualização feita com sucesso!</h2> </div>";
			return $msg;
		} else {
			$msg[0] = FALSE;
			$msg[1] = "<div class=\" alert alert-danger text-center\"> <h2 class=\"text-center\">Error: " . $sql . "<br>" . mysqli_error($this->conexao) . "</h2></div>";
		  return $msg;
		}

	}

	public function deletar($tabela, $onde ) { //verficar com professor
		// Montamos nossa query SQL
		$query = "DELETE FROM `$tabela`";
		// Caso tenhamos um valor de onde deletar dados, adicionamos a cláusula WHERE
		if($onde) {  //(!empty($onde))
			$query .= " WHERE $onde ";
		}
		die($query);
		//Preparamos e executamos nossa query
		mysqli_query($this->conexao, $query);
	}

	public function numPages($tabela, $campos=FALSE, $where=FALSE) {

		$query = 'SELECT ';

		if( empty($campos) )
			$query.= '*';
		else
		 $query.= $campos;

		$query.= ' FROM ' .'`'.$tabela.'`';

		if( !empty($where) )
		 $query.= ' WHERE ' .$where;

		$result = mysqli_query($this->conexao,$query);

		$numObjetos = $result->num_rows;

		if ( !$numObjetos ) {
			die('Query invalida: ' . mysqli_error($this->conexao));
		}else{	
			//var_dump($numObjetos);die;
			return $numObjetos;
		}
	}

}


// $_POST['cliente'] = array
// (
// 	'cpf' => '930202933', 
//   'rg' => '23.098.233-12', 
//   'dt_Nasc' => '1979-02-20', 
//   'cnh' => '393493332', 
//   'nome' => 'Eduardo', 
//   'endereco' => 'Rua jdks da liem'
// );

//var_dump($_POST['cliente']);
//$DataBase->insert('cliente', $_POST['cliente']);
