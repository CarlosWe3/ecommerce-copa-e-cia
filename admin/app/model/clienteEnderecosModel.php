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
	
	function cadastrar() {
		$sql = "insert into ".$this->tabela." 
				(des_endereco, num_endereco, num_cep, nom_bairro, des_complemento, 
				des_referencia, cod_cliente, cod_cidade) 
				values ('".$this->des_endereco."',
						'".$this->num_endereco."',
						'".$this->num_cep."',
						'".$this->nom_bairro."',
						'".$this->des_complemento."',
						'".$this->des_referencia."',
						'".$this->cod_cliente."',
						'".$this->cod_cidade."')";
		$prep = $this->conn->prepare($sql);
		$prep->execute();
	}
	
	function alterar() {
		$sql = "UPDATE ".$this->tabela."
				SET des_endereco   	= ?
				   ,num_endereco    = ? 
				   ,num_cep         = ?
				   ,nom_bairro      = ?
				   ,des_complemento = ?
				   ,des_referencia  = ?
				   ,cod_cidade 		= ?
				WHERE cod_cliente 	= ?";
		$prep = $this->conn->prepare($sql);
		$valores = array($this->des_endereco,$this->num_endereco,$this->num_cep,$this->nom_bairro,$this->des_complemento,$this->des_referencia,$this->cod_cidade,$this->cod_cliente);
		$prep->execute($valores);
	}
	
	function excluirArray($array) {
		$cod = '';
		foreach($array as $ln) {
			 $cod .= ",'$ln'"; 
		} 
		$cod = substr($cod, 1);
		
		$sql = 'DELETE FROM '.$this->tabela.' 
				WHERE cod_cliente IN ('.$cod.')';
		$prep = $this->conn->prepare($sql);
		$prep->execute();
	}
}