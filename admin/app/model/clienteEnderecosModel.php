<?php
/**
 * Classe model de enderecos de clientes
 * @author Guilherme Lessa 22/06/12 - 14:30
 */
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
	
   /**
	* Método que seta o endereço selecionado por id
    * @param int $this->id - chave primaria do endereço
	* @author Guilherme Lessa 22/06/12 - 14:30
	*/
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
	
   /**
	* Método que seta o endereco do cliente pelo id
    * @param int $this->id - chave primaria do cliente
	* @author Guilherme Lessa 22/06/12 - 14:30
	*/
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
	
   /**
	* Método que cadastra o endereco do cliente pelo id
    * @param int $this->id - chave primaria do cliente
	* @author Guilherme Lessa 22/06/12 - 14:30
	*/	
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
	
   /**
	* Método que altera o endereco do cliente pelo id
    * @param int $this->id - chave primaria do endereço do cliente
	* @author Guilherme Lessa 22/06/12 - 14:30
	*/
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
	
	
   /**
	* Método que exclui endereço dos clientes de acordo com array de codigo de clientes
    * @param int $this->id - chave primaria dos clientes
	* @author Guilherme Lessa 22/06/12 - 14:40
	*/
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