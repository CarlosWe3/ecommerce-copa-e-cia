<?php
class clientesModel extends model {
	
	public $tabela = "cec_clientes";
	
	public $cod_cliente;
	public $nom_cliente;
	public $des_email;
	public $des_senha;
	public $dat_cadastro;
	public $cod_status;
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getListagem() {
		$sql = "SELECT C.cod_cliente, 
		               C.nom_cliente, 
		               C.des_email, 
		               T.des_cliente_tipo,
		               I.num_telefone_fixo, 
		               I.num_telefone_celular
		        FROM {$this->tabela} as C, 
					   cec_cliente_informacoes as I, 
	                   cec_cliente_tipos as T
		        WHERE I.cod_cliente = C.cod_cliente
		        AND I.cod_cliente_tipo = T.cod_cliente_tipo";
		$prep = $this->conn->prepare($sql);
		$prep->execute();
		return $prep->fetchAll();
	}
	
	function _set() {
		$res = $this->procura('unico');
		
		if($res) {
			$this->cod_cliente  = $this->id;
			$this->nom_cliente  = $res['nom_cliente'];
			$this->des_email    = $res['des_email'];
			$this->des_senha    = $res['des_senha'];
			$this->dat_cadastro = $res['dat_cadastro'];
			$this->cod_status   = $res['cod_status'];
		}
	}
	
	/*
	function cadastrar() {
		$sql = "insert into {$this->tabela} values ($this->nom_cliente,$thi)";
	}*/
}