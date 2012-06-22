<?php
/**
 * Classe model de produtos
 * @author Guilherme Lessa 22/06/12 - 14:20
 */
class produtosDimensoesModel extends model {
	public $tabela = "cec_produtos_dimensoes";
	public $num_altura;
	public $num_largura;
	public $num_circunferencia;
	public $num_peso;
	
	public function __construct() {
		parent::__construct();
	}
		
	function cadastrar() {
		$sql = "insert into ".$this->tabela." 
				(num_altura, num_largura, num_circunferencia, num_peso, cod_produto) 
				values ('".$this->num_altura."',
						'".$this->num_largura."',
						'".$this->num_circunferencia."',
						'".$this->num_peso."',
						'".$this->cod_produto."')";
		$prep = $this->conn->prepare($sql);
		$prep->execute();	
	}
}