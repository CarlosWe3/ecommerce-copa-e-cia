<?php
/**
 * Classe model de tipos de cliente
 * @author Guilherme Lessa 22/06/12 - 14:10
 */
class clienteTiposModel extends model {
	public $tabela = "cec_cliente_tipos";
	public $cod_cliente_tipo;
	public $des_cliente_tipo;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	* Método que seta o tipo selecionado no select option
    * @param int $this->id - chave primaria do tipo
	* @author Guilherme Lessa 22/06/12 - 14:10
	*/
	function _set() {
		$res = $this->procura('unico');
		
		if ($res) {
			$this->cod_cliente_tipo  = $this->id;
			$this->des_cliente_tipo  = $res['des_cliente_tipo'];
		}
	}
	
	/**
	* Método que captura todos os tipos de clientes para exibir
    * @param int $this->id - chave primaria do tipo
	* @author Guilherme Lessa 22/06/12 - 14:10
	*/
	function setTodos() {
		$res = $this->procura('unico',array('cod_cliente'=>$this->cod_cliente));
		
		if ($res) {
			$this->cod_cliente_tipo = $res['cod_cliente_tipo'];
			$this->des_cliente_tipo = $res['des_cliente_tipo'];
		}
	}
}