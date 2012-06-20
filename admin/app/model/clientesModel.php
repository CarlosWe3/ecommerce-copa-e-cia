<?php
class clientesModel extends model {
	
	public $tabela = "cec_clientes";
	
	public $cod_cliente;
	public $nom_cliente;
	public $des_email;
	public $des_senha;
	public $dat_cadastro;
	public $cod_status;
	public $ultimo_id; 	
	
	public $buscar_nom;
	public $buscar_email;
	public $buscar_rg;
	public $buscar_cpf;
	public $buscar_cnpj;
	
	public function __construct() {
		parent::__construct();
	}
		
	public function getListagem() {
		$busca = '';
		if($this->buscar_nom) {
			$busca .= " AND C.nom_cliente = '".$this->buscar_nom."' ";
		}
		
		if($this->buscar_email) {
			$busca .= " AND C.des_email = '".$this->buscar_email."' ";
		}
		
		if($this->buscar_rg) {
			$busca .= " AND I.num_rg = '".$this->buscar_rg."' ";
		}
		
		if($this->buscar_cpf) {
			$busca .= " AND I.num_cpf = '".$this->buscar_cpf."' ";
		}
		
		if($this->buscar_cnpj) {
			$busca .= " AND I.num_cnpj = '".$this->buscar_cnpj."' ";
		}
		
		$sql = "SELECT C.cod_cliente, 
		               C.nom_cliente, 
		               C.des_email, 
		               T.des_cliente_tipo,
		               I.num_telefone_fixo, 
		               I.num_telefone_celular,
		               S.nom_status
		        FROM ".$this->tabela." as C, 
					   cec_cliente_informacoes as I, 
	                   cec_cliente_tipos as T,
	                   cec_status as S
		        WHERE I.cod_cliente = C.cod_cliente
		        ".$busca."
		        AND C.cod_status = S.cod_status
		        AND I.cod_cliente_tipo = T.cod_cliente_tipo
		        ORDER BY C.cod_cliente DESC";
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
		
	function cadastrar() {
		$sql = "insert into ".$this->tabela." 
				(nom_cliente, des_email, des_senha, dat_cadastro, cod_status) 
				values ('".$this->nom_cliente."',
						'".$this->des_email."',
						'".$this->des_senha."',
						'".$this->dat_cadastro."',
						'".$this->cod_status."')";
		$prep = $this->conn->prepare($sql);
		$prep->execute();
	}
	
	function selectArray($array) {
		$cod = '';
		foreach($array as $ln) {
			 $cod .= ",'$ln'"; 
		} 
		$cod = substr($cod, 1);
		
		$sql = 'SELECT cod_cliente, 
		               nom_cliente
		        FROM '.$this->tabela.'
		        WHERE cod_cliente IN ('.$cod.')';
		$prep = $this->conn->prepare($sql);
		$prep->execute();
		return $prep->fetchAll();
	}
	
	function alterar() {
		$sql = "UPDATE ".$this->tabela." 
				SET nom_cliente   = ?
				   ,des_email     = ? 
				   ,cod_status    = ?
				WHERE cod_cliente = ? ";
		$prep = $this->conn->prepare($sql);
		$valores = array($this->nom_cliente, $this->des_email, $this->cod_status, $this->cod_cliente);
		$prep->execute($valores);
		
		if($this->des_senha) {
	   		$sql = "UPDATE ".$this->tabela." 
	   				SET des_senha     = ?
				    WHERE cod_cliente = ? ";
			$prep = $this->conn->prepare($sql);
			$valores = array($this->des_senha, $this->cod_cliente);
			$prep->execute($valores);
		}
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