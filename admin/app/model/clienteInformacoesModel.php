<?php
class clienteInformacoesModel extends model {
	
	public $tabela = "cec_cliente_informacoes";
	
	public $cod_cliente_informacao;
	public $num_rg;
	public $num_cpf;
	public $num_cnpj;
	public $dat_alteracao;
	public $ind_genero;
	public $dat_nascimento;
	public $num_telefone_fixo;
	public $num_telefone_celular;
	public $ind_recebe_oferta;
	public $cod_cliente_tipo;
	public $cod_cliente;
	
	public function __construct() {
		parent::__construct();
	}
	
	function _set() {
		$res = $this->procura('unico');
		
		if ($res) {
			$this->cod_cliente_informacao = $this->id;
			$this->num_rg 				  = $res['num_rg'];
			$this->num_cpf   			  = $res['num_cpf'];
			$this->num_cnpj   			  = $res['num_cnpj'];
			$this->ind_genero   		  = $res['ind_genero'];
			$this->dat_nascimento 		  = $res['dat_nascimento'];
			$this->num_telefone_fixo      = $res['num_telefone_fixo'];
			$this->num_telefone_celular   = $res['num_telefone_celular'];
			$this->ind_recebe_oferta 	  = $res['ind_recebe_oferta'];
			$this->cod_cliente_tipo 	  = $res['cod_cliente_tipo'];
			$this->cod_cliente 			  = $res['cod_cliente'];
		}
	}
	
	function setPeloCliente() {
		$res = $this->procura('unico',array('cod_cliente'=>$this->cod_cliente));
		
		if ($res) {
			$this->cod_cliente_informacao = $res['cod_cliente_informacao'];
			$this->num_rg 				  = $res['num_rg'];
			$this->num_cpf   			  = $res['num_cpf'];
			$this->num_cnpj   			  = $res['num_cnpj'];
			$this->ind_genero   		  = $res['ind_genero'];
			$this->dat_nascimento 		  = $res['dat_nascimento'];
			$this->num_telefone_fixo      = $res['num_telefone_fixo'];
			$this->num_telefone_celular   = $res['num_telefone_celular'];
			$this->ind_recebe_oferta 	  = $res['ind_recebe_oferta'];
			$this->cod_cliente_tipo 	  = $res['cod_cliente_tipo'];
			$this->cod_cliente 			  = $res['cod_cliente'];
		}
	}
}