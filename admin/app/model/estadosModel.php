<?php
class estadosModel extends model {
	
	public $tabela = "cec_estados";
	
	public $cod_estado;
	public $nom_estado;
	public $sig_estado;
	
	public function __construct() {
		parent::__construct();
	}
	
	function _set() {
		$res = $this->procura('unico');
		
		if ($res) {
			$this->cod_estado = $this->id;
			$this->nom_estado = $res['nom_estado'];
			$this->sig_estado = $res['sig_estado'];
		}
	}
}