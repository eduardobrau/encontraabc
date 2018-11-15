<?php
/*https://www.youtube.com/watch?v=j2vYuZcgYGU
http://rberaldo.com.br/pdo-mysql/*/
class PDODB{

	// private $host = "127.0.0.1:3306";
	// private $database = "appedusitesbr";
	// private $usuario = "root";
	// private $senha = "";
	private $conexao;

	private const PARAMS = array(
		'DRIVER'			=> 'mysql:host=127.0.0.1:3306',
		'DATABASE' 	=> 'appedusitesbr',
		'USER'			=> 'root',
		'PASSWORD'	=> '',
	);

	/*
	Adicionado para receber uma única instancia
	uma unica vez e retornar a mesma instancia
	toda vez que for chamado garantido assim
	o pattern singleton. Como é um atributo
	static do tipo private só poderá ser acessado
	dentro da classe através de seu operador self::$instance
	que representa a própria classe.
	*/
	private static $instance;

	/*
	Aqui a idéia que está classe não possa ser instanciada
	diretamente por isso ela recebe o ecapsulamento mais
	restrito private. para que está classe seja instanciada
	devemos criar um método publico que a instancie e este
	método é o getInstance
	*/
	private function __construct(){

		$this->conectar();	

	}

	public function __destruct(){

		//mysqli_close($this->conexao);

	}
	/*
	Este método permite uma instancia dessa classe uma
	unica vez através de uma verificação da propriedade
	static $instance que caso não esteja setada retorna
	uma instancia dessa classe uma única vez e caso já
	haja uma intância dessa classe em memória ela retorna
	sempre a mesma instância já carregada na memória
	*/
	public static function getInstance(){

		if (!isset(self::$instance)) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	private function conectar(){

		/*$this->conexao = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);

		if ( !$this->conexao ) {
			die('Não foi possível conectar ao mysql: ' . mysqli_connect_error());
			exit();
		}else{
			return $this->conexao;
		}*/
		// Salva uma instancia de conexão do objeto PDO
		try{
			$this->conexao = new PDO(self::PARAMS['DRIVER'].";dbname=".self::PARAMS['DATABASE'], self::PARAMS['USER'], self::PARAMS['PASSWORD']);
			$this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			//var_dump($e);
			echo "Error: " . $e->getMessage();
		}

	}

	private function executar($sql, $dados = null) {
		// preparo uma query a ser executada
		$statement = $this->conexao->prepare($sql);
		// executo a query
		$statement->execute($dados); 
		var_dump($statement);die();
		/* 
		* A partir daqui eu tenho um array com todo o resultado
		* de minha query obs: $dados=null então execute() poderia
		* ser executado desta forma falta agora varrer esse array 
		*/
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

		//$result = mysqli_query($this->conexao,$query);

		$stmt = $this->conexao->prepare($query); 
	
    $stmt->execute();

		// set the resulting array to associative
  	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  	//var_dump($result);
  	return $result;
		
	}

	public function inserir($table, $datas=array()){
		
		foreach ($datas as $coluna => $valor) {
			/*
			Como não estou usando MySQL direto não preciso
			preparar os array para o padrão de inserção MySQL
			$colunas[]= '`'.$coluna.'`';
			$valores[]= '\''.$valor.'\'';
			*/
			$colunas[] = $coluna;
			//Preparando os valores com pseudo valores
			$binds[] = ':'.$coluna;
		}

		$colunas = implode(', ' , $colunas);
		$binds = implode(', ', $binds);

		//Prepare sql and bind parameters
		/*
		* Uma das grandes vantagens em se usar o PDO é exatamente
		* preparar nossas consultas antes de executar como o método
		* prepare, assim adiciona uma camada extra de segurança contra
		* SQL injection
		*/
		$sql = 'INSERT INTO '.$table.' ('.$colunas.') VALUES ('.$binds.')';
		//echo $sql; die();

		$statement = $this->conexao->prepare($sql);

		$statement->execute($datas);

		//var_dump($statement); die();


	}

	public function insert($table, $datas=array()){
		
		foreach ($datas as $coluna => $valor) {
			/*
			Como não estou usando MySQL direto não preciso
			preparar os array para o padrão de inserção MySQL
			$colunas[]= '`'.$coluna.'`';
			$valores[]= '\''.$valor.'\'';
			*/
			$colunas[] = $coluna;
			//Preparando os valores com pseudo valores
			$binds[] = '?';
			$valores[] = $valor;
		}

		//Prepare sql and bind parameters
		/*
		* Uma das grandes vantagens em se usar o PDO é exatamente
		* preparar nossas consultas antes de executar como o método
		* prepare, assim adiciona uma camada extra de segurança contra
		* SQL injection
		*/

		$colunas = implode(', ' , $colunas);
		$binds = implode(', ', $binds);

		$sql = 'INSERT INTO '.$table.' ('.$colunas.') VALUES ('.$binds.')';

		//var_dump($sql); die();

		self::$instance->executar($sql, $valores);


	}

	public function deletar($tabela, $onde ) { //verficar com professor
		// Montamos nossa query SQL
		$query = "DELETE FROM `$tabela`";
		// Caso tenhamos um valor de onde deletar dados, adicionamos a cláusula WHERE
		if($onde) {  //(!empty($onde))
			$query .= " WHERE $onde ";
		}
		//die($query);

		// use exec() because no results are returned
    $this->conexao->exec($query);

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
