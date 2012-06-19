<?php
class statusModel extends model {
	
	public $tabela = "cec_status";
	
	public $cod_status;
	public $nom_status;
	public $des_status;
	public $ind_tipo;
	
	public function __construct() {
		parent::__construct();
	}
	
	function _set() {
		$res = $this->procura('unico');
		
		if ($res) {
			$this->cod_status = $this->id;
			$this->nom_status = $res['nom_status'];
			$this->des_status = $res['des_status'];
			$this->ind_tipo   = $res['ind_tipo'];
		}
	}	
}