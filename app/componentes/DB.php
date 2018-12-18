<?php

namespace app\componentes;

class DB{

	private $host = "127.0.0.1:3306";
	private $database = "encontra_abc";
	private $usuario = "root";
	private $senha = "";
	private $conexao;
	public $numRows;
	private $lastID;

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
			throw new \Exception('Não foi possível conectar ao mysql:1000: ' . mysqli_connect_error());
		}else{
			$this->conexao->set_charset("utf8");           
			return $this->conexao;
		}
	}

	public function consultar($table,$campos=FALSE,$where=FALSE,$like=FALSE,$order=FALSE,$limit=FALSE){
			
		$this->sql = 'SELECT ';
		
		if( empty($campos) )
			$this->sql.= '*';
		else
		$this->sql.= $campos;
		
		$this->sql.= ' FROM ' .'`'.$table.'`';
		
		if( !empty($where) )
			$this->sql.= ' WHERE ' .$where;
		if( !empty($like) )
			$this->sql.= ' LIKE ' .$like;
		if( !empty($order) )
			$this->sql.= ' ORDER BY ' .$order;
		if( !empty($limit) )
			$this->sql.= ' LIMIT ' .$limit;
		//echo "<pre>"; print_r($this->sql); echo "</pre>";die;
		
		$result = $this->conexao->query($this->sql);
									
		if ( $this->conexao->error ) {
			throw new \Exception('Query inválida:1001: ' . $this->conexao->error);
		}
		
		// Seta o número de registros da consulta atual
		$this->numRows = $result->num_rows;


		if ( !$this->numRows ):
			return FALSE;
		elseif( $this->numRows == 1 ):
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
			$colVal []= '`'.$coluna.'` = ' . '\''.$valor.'\'';
		}

		$colunas = implode(', ' , $colunas);
		$valores = implode(', ', $valores);
		$colVal = implode(', ', $colVal);

		$sql ='INSERT INTO `'.$table.'` ('.$colunas.') VALUES ('.$valores.')' .
		' ON DUPLICATE KEY UPDATE ' . $colVal; 
		//echo "<pre>"; print_r($sql); echo "</pre>";die;
		
		if (!$this->conexao->query($sql)):
			throw new \Exception(' Não foi possível salvar os dados:1002: ' 
			. $this->conexao->error);
		endif;

		$this->lastID = $datas['id'];
					
		return $this->lastID;
		
	}

	public function update($table, $datas=array(), $condition){
			
		$sql = "UPDATE `$table` SET ";
		
		foreach($datas as $coluna => $valor){
			$dados[] = ' `'.$coluna.'` = \''.$valor.'\' ';
		}   
		
		$dados = implode(', ' , $dados);
		$sql .= $dados; 
		$sql .= 'WHERE '.$condition;
					
		if( !$this->conexao->query($sql) ):
			throw new \Exception(' Não foi possível atualizar os dados:1003: ' 
				. $this->conexao->error);
		endif; 

		return TRUE;
			
	}

	public function delete($tabela, $onde ) { 

		$this->sql = "DELETE FROM `$tabela` WHERE $onde ";
			
		//Preparamos e executamos nossa query
		if ( !$this->conexao->query($this->sql) ) {
			throw new \Exception('Registro inválido:1004: ' . $this->conexao->error);
		}

		return TRUE;

	}
	// Retorna o total de linhas da última consulta
	public function getNumRows(){
		return $this->numRows;
	}
	// Retorna a última consulta SQL
	public function getSql(){
		return $this->sql;
	}
	// Retorna o último id inserido pela função insere()
	public function getLastID(){
		return $this->lastID;
	}
	
}