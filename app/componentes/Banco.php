<?php

class Banco {
	public static $instancia;
	protected $conexao;
	
	public static function instanciar() {
		if(!self::$instancia) {
			self::$instancia = new Banco;
			self::$instancia->conectar();
		}
		
		return self::$instancia;
	}
	
	protected function conectar() {
		global $config;
		
		$this->conexao = new PDO("{$config['driver']}:host={$config['host']};dbname={$config['database']}", $config['user'], $config['pass']);
		$this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	
	public function executar($sql, $dados = null) {
		$statement = $this->conexao->prepare($sql);
		$statement->execute($dados);
	}
	
	public function consultar($sql, $dados = null) {
		$statement = $this->conexao->prepare($sql);
		$statement->execute($dados);
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function inserir($tabela, $dados) {
		foreach($dados as $coluna => $valor) {
			$colunas[] = "`$coluna`";
			$substitutos[] = "?";
			$valores[] = $valor;
		}

		$colunas = implode(", ", $colunas);
		$substitutos = implode(", ", $substitutos);

		$query = "INSERT INTO `$tabela` ($colunas) VALUES ($substitutos)";

		$this->executar($query, $valores);
	}

	public function alterar($tabela, $id, $dados) {
		foreach($dados as $coluna => $valor) {
			$set[] = "`$coluna` = ?";
			$valores[] = $valor;
		}
		
		$valores[] = $id;

		$set = implode(", ", $set);

		$query = "UPDATE `$tabela` SET $set WHERE id = ?";
		
		$this->executar($query, $valores);
	}

	public function remover($tabela, $id) {
		$query = "DELETE FROM `$tabela`";

		if(!empty($id)) {
			$query .= " WHERE id = ?";
		}

		$this->executar($query, array($id));
	}

	public function listar($tabela, $campos = '*', $onde = null, $filtro = null, $ordem = null, $limite = null) {
		$query = "SELECT $campos FROM `$tabela`";

		if(!empty($onde)) {
			$query .= " WHERE $onde";
		}

		if(!empty($filtro)) {
			$query .= " LIKE $filtro";
		}

		if(!empty($ordem)) {
			$query .= " ORDER BY $ordem";
		}

		if(!empty($limite)) {
			$query .= " LIMIT $limite";
		}

		return $this->consultar($query);
	}

	public function ver($tabela, $campos, $onde) {
		$query = "SELECT $campos FROM `$tabela`";

		if(!empty($onde)) {
			$query .= " WHERE $onde";
		}
		
		return $this->consultar($query);
	}

}
