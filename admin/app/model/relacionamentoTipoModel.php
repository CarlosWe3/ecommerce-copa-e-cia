<?php
class relacionamentoTipoModel extends model {
	public $tabela = "cec_relacionamento_tipo";
	
	public $cod_relacionamento_tipo;
	public $des_relacionamento_tipo;
	
	public function __construct() {
		parent::__construct();
	}
	
	function _set() {
		$res = $this->procura('unico');
		
		if ($res) {
			$this->cod_relacionamento_tipo = $this->id;
			$this->des_relacionamento_tipo = $res['des_relacionamento_tipo'];
		}
	}
}