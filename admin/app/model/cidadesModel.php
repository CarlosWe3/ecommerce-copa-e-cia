<?php
/**
 * Classe model de cidades
 * @author Guilherme Lessa 22/06/12 - 14:40
 */
class cidadesModel extends model {
	public $tabela = "cec_cidades";
	public $nom_cidade;
	public $cod_estado;
	
	public function __construct() {
		parent::__construct();
	}
	
   /**
	* Método que set a cidade selecionado por id
    * @param int $this->id - chave primaria da cidade
	* @author Guilherme Lessa 22/06/12 - 14:40
	*/
	function _set() {
		$res = $this->procura('unico');
		
		if ($res) {
			$this->cod_cidade = $this->id;
			$this->nom_cidade = $res['nom_cidade'];
			$this->cod_estado = $res['cod_estado'];
		}
	}
}