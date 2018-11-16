<?php

namespace app\componentes;

class DB{

	private $host = "127.0.0.1:3306";
	private $database = "app_php";
	private $usuario = "root";
	private $senha = "12345";
	private $conexao;

	/**
	 * Método construtor, retorna
	 * um objeto de conexao no momento em 
	 * que se instância a classe.
	 * @access public
	 */
		public function __construct(){
		$this->conectar();  
	}
	/**
	 * Método destrutor, distroi
	 * o objeto de conexao no momento em 
	 * que o script é finalizado, fechando
	 * a conexao aberta.
	 * @access public
	 */
	public function __destruct(){
		$this->conexao->close();
	}
	/**
	 * Retorna um objeto de conexão pronto
	 * para fazer novas consultas SQL.
	 * @access public
	 * @return Object do tipo mysqli Object
	 */
	private function conectar(){
		$this->conexao = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);
		if ( !$this->conexao ) {
			throw new \Exception('Não foi possível conectar ao mysql: ' . mysqli_connect_error());
		}else{
				$this->conexao->set_charset("utf8");           
			return $this->conexao;
		}
	}
	
	public function consultar($table,$campos=FALSE,$where=FALSE,$like=FALSE,$order=FALSE,$limit=FALSE){
			
		$sql = 'SELECT ';
		
		if( empty($campos) )
			$sql.= '*';
		else
		$sql.= $campos;
		$sql.= ' FROM ' .'`'.$table.'`';
		
		if( !empty($where) )
			$sql.= ' WHERE ' .$where;
		if( !empty($like) )
			$sql.= ' LIKE ' .$like;
		if( !empty($order) )
			$sql.= ' ORDER BY ' .$order;
		if( !empty($limit) )
			$sql.= ' LIMIT ' .$limit;
		
		$result = $this->conexao->query($sql);
							
		if ( !$result->num_rows ):
			throw new \Exception('Query não retornou nenhum registro: ' . 
				$this->conexao->error);
		elseif( $result->num_rows == 1 ):
			$data = mysqli_fetch_assoc($result);
		else:
			while( $row =  mysqli_fetch_assoc($result) ){
				$data[] = $row;
			}
		endif;

		// Free result set
		mysqli_free_result($result);
				
		return $data;
			
	}
	/**
	 * Executa uma consulta pronta
	 * SQL. Caso seja passado um insert
	 * retorna o último id.
	 * @access public
	 * @return String
	 */
	public function execute($sql){
													
		if (!$this->conexao->query($sql)):
			throw new \Exception(' Error: na consulta SQL ' 
			. $this->conexao->error );
		endif;
						
		$last_id = $this->conexao->insert_id;
										
		return $last_id;


	}

	public function insert($table, $datas=array()){
			
		foreach ($datas as $coluna => $valor) {
			$colunas[]= '`'.$coluna.'`';
			$valores[]= '\''.$valor.'\'';
		}


		$colunas = implode(', ' , $colunas);
		$valores = implode(', ', $valores);


		$sql ='INSERT INTO `'.$table.'` ('.$colunas.') VALUES ('.$valores.')'; 
		
		if (!$this->conexao->query($sql)):
			throw new \Exception(' Error: Não foi possível salvar os dados ' 
			. $this->conexao->error . ' Verifique os parametros de conexão. ');
		endif;
		
		$last_id = $this->conexao->insert_id;
						
		return $last_id;
			
	}
	
	public function update($table, $datas=array(), $condition){
			
		$sql = "UPDATE `$table` SET ";
		foreach ($datas as $coluna => $valor) {
			$dados[] = ' `'.$coluna.'` = \''.$valor.'\' ';
		}   
		
		$dados = implode(', ' , $dados);
		$sql .= $dados; 
		$sql .= 'WHERE '.$condition;
		if ($this->conexao->query($sql)) {
			$msg[0] = TRUE;
			$msg[1] = "<div class=\"alert alert-success\"> <h2 class=\"text-center\">Atualização feita com sucesso!</h2> </div>";
			return $msg;
		} else {
			$msg[0] = FALSE;
			$msg[1] = "<div class=\" alert alert-danger text-center\"> <h2 class=\"text-center\">Error: " . $sql . "
			" . $this->conexao->error . "</h2></div>";
			return $msg;
		}
			
	}
	
	public function deletar($tabela, $onde ) { 
		$sql = "DELETE FROM `$tabela`  WHERE $onde ";
		//Preparamos e executamos nossa query
		$this->conexao->query($sql);
	}
	
	
}