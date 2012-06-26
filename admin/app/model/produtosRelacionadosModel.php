<?php
class produtosRelacionadosModel extends model {
	public $tabela = "cec_produto_relacionados";

	public $cod_produto;
	public $cod_produto_relacionado;
	public $cod_relacionamento_tipo;
	
	public function __construct() {
		parent::__construct();
	}
	
	function _set() {
		$res = $this->procura('unico');
		
		if ($res) {
			$this->cod_produto = $this->id;
			$this->cod_produto_relacionado = $res['cod_produto_relacionado'];
			$this->cod_relacionamento_tipo = $res['cod_relacionamento_tipo'];
		}
	}
	
	function cadastrar() {
		$sql = "insert into ".$this->tabela." 
				(cod_produto, cod_produto_relacionado, cod_relacionamento_tipo) 
				values ('".$this->cod_produto."',
						'".$this->cod_produto_relacionado."',
						'".$this->cod_relacionamento_tipo."')";
		$prep = $this->conn->prepare($sql);
		$prep->execute();
		
		echo $this->conn->lastInsertId();
	}
	
	function excluir() {
		$sql = 'DELETE FROM '.$this->tabela.' 
				WHERE cod_relacionado IN ('.$this->id.')';
		$prep = $this->conn->prepare($sql);
		$prep->execute();
	}
	
	/*
	function codigoPorNome($nomeProduto) {
		
	}*/
}