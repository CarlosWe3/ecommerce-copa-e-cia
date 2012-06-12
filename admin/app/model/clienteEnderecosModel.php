<?php
class clienteEnderecosModel extends model {
	
	public $tabela = "cec_cliente_enderecos";
	
	public $cod_cliente_endereco;
	public $des_endereco;
	public $num_endereco;
	public $num_cep;
	public $nom_bairro;
	public $des_complemento;
	public $des_referencia;
	public $cod_cliente;
	public $cod_cidade;
	
	public function __construct() {
		parent::__construct();
	}
	
	function _set() {
		$res = $this->procura('unico');
		
		if ($res) {
			$this->cod_cliente_endereco = $this->id;
			$this->des_endereco 		= $res['des_endereco'];
			$this->num_endereco   		= $res['num_endereco'];
			$this->num_cep   			= $res['num_cep'];
			$this->nom_bairro   		= $res['nom_bairro'];
			$this->des_complemento 		= $res['des_complemento'];
			$this->des_referencia   	= $res['des_referencia'];
			$this->cod_cliente   		= $res['cod_cliente'];
			$this->cod_cidade   		= $res['cod_cidade'];
		}
	}
	
	function setPeloCliente() {
		$res = $this->procura('unico',array('cod_cliente'=>$this->cod_cliente));
		
		if ($res) {
			$this->cod_cliente_endereco = $res['cod_cliente_endereco'];
			$this->des_endereco 		= $res['des_endereco'];
			$this->num_endereco   		= $res['num_endereco'];
			$this->num_cep   			= $res['num_cep'];
			$this->nom_bairro   		= $res['nom_bairro'];
			$this->des_complemento 		= $res['des_complemento'];
			$this->des_referencia   	= $res['des_referencia'];
			$this->cod_cidade   		= $res['cod_cidade'];
		}
	}
}