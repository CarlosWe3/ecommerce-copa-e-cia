<?php
/**
 * Classe model de estados
 * @author Guilherme Lessa 22/06/12 - 14:00
 */
class estadosModel extends model {
	public $tabela = "cec_estados";
	public $cod_estado;
	public $nom_estado;
	public $sig_estado;
	
	public function __construct() {
		parent::__construct();
	}
	
   /**
	* Método que seta o estado selecionado por id
    * @param int $this->id - chave primaria do estado
	* @author Guilherme Lessa 22/06/12 - 14:05
	*/
	function _set() {
		$res = $this->procura('unico');
		
		if ($res) {
			$this->cod_estado = $this->id;
			$this->nom_estado = $res['nom_estado'];
			$this->sig_estado = $res['sig_estado'];
		}
	}
}