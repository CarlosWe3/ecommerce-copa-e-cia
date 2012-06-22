<?php
/**
 * Classe model de produtos
 * @author Guilherme Lessa 22/06/12 - 14:20
 */
class categoriasModel extends model {
	public $tabela = "cec_categorias";
	public $cod_categoria;
	public $cod_produto;
	
	public function __construct() {
		parent::__construct();
	}
	
	function porProduto($array) {
		foreach($array as $categoria) {
			$sql = "insert into ".$this->tabela." 
					(cod_categoria, cod_produto) 
					values ('".$categoria['categorias']."',
							'".$this->cod_produto."')";
			$prep = $this->conn->prepare($sql);
			$prep->execute();
		}
	}
}