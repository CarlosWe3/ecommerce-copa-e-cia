<?php
class clienteCidadesModel extends model {
	
	public $tabela = "cec_cidades";
	
	public $cod_cidade;
	public $nom_cidade;
	public $cod_estado;
	
	public function __construct() {
		parent::__construct();
	}
	
	function _set() {
		$res = $this->procura('unico');
		
		if ($res) {
			$this->cod_cidade = $this->id;
			$this->nom_cidade = $res['nom_cidade'];
			$this->cod_estado = $res['cod_estado'];
		}
	}
}