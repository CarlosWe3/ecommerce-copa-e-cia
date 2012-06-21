<?php
class categoriasModel extends model {
	
	public $tabela = "cec_categorias";
	
	public $cod_categoria;
	public $cod_produto;
	
	public function __construct() {
		parent::__construct();
	}
		
	function porProduto() {
		$sql = "insert into ".$this->tabela." 
				(cod_categoria, cod_produto) 
				values ('".$this->cod_categoria."',
						'".$this->cod_produto."')";
		$prep = $this->conn->prepare($sql);
		$prep->execute();
	}
}