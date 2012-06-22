<?php
class produtosModel extends model {
	
	public $tabela = "cec_produtos";
	
	public $num_produto;
	public $num_estoque_alerta;
	public $vlr_preco;
	public $url_slug;
	public $des_descricao;
	public $des_informacao;
	public $cod_status;
	
	public function __construct() {
		parent::__construct();
	}
		
	public function getListagem() {
		/*$busca = '';
		if($this->buscar_nom) {
			$busca .= " AND C.nom_cliente LIKE '%".$this->buscar_nom."%' ";
		}
		
		if($this->buscar_email) {
			$busca .= " AND C.des_email LIKE '%".$this->buscar_email."%' ";
		}
		
		if($this->buscar_rg) {
			$busca .= " AND I.num_rg = '".$this->buscar_rg."' ";
		}
		
		if($this->buscar_cpf) {
			$busca .= " AND I.num_cpf = '".$this->buscar_cpf."' ";
		}
		
		if($this->buscar_cnpj) {
			$busca .= " AND I.num_cnpj = '".$this->buscar_cnpj."' ";
		}*/
		
		$sql = "SELECT P.cod_produto, 
		               P.nom_produto,
		               P.num_produto,
		               P.vlr_preco,
		               S.nom_status
		        FROM ".$this->tabela." as P,
	                   cec_status as S
		        WHERE P.cod_status = S.cod_status
		        ORDER BY P.cod_produto DESC";
		$prep = $this->conn->prepare($sql);
		$prep->execute();
		return $prep->fetchAll();
	}
	
	function _set() {
		$res = $this->procura('unico');
		
		if($res) {
			$this->cod_produto  	  = $this->id;
			$this->nom_produto  	  = $res['nom_produto'];
			$this->num_produto  	  = $res['num_produto'];
			$this->num_estoque_alerta = $res['num_estoque_alerta'];
			$this->vlr_preco 		  = $res['vlr_preco'];
			$this->url_slug   		  = $res['url_slug'];
			$this->des_descricao      = $res['des_descricao'];
			$this->des_informacao     = $res['des_informacao'];
			$this->cod_status   	  = $res['cod_status'];
		}
	}

	function cadastrar() {
		$sql = "insert into ".$this->tabela." 
				(nom_produto, num_produto, num_estoque_alerta, vlr_preco, url_slug, des_descricao, des_informacao, cod_status) 
				values ('".$this->nom_produto."',
						'".$this->num_produto."',
						'".$this->num_estoque_alerta."',
						'".$this->vlr_preco."',
						'".$this->url_slug."',
						'".$this->des_descricao."',
						'".$this->des_informacao."',
						'".$this->cod_status."')";
		$prep = $this->conn->prepare($sql);
		$prep->execute();
		var_dump($prep->errorInfo());
	}
	
	function selectArray($array) {
		$cod = '';
		foreach($array as $ln) {
			 $cod .= ",'$ln'"; 
		} 
		$cod = substr($cod, 1);
		
		$sql = 'SELECT cod_produto, 
		               nom_produto
		        FROM '.$this->tabela.'
		        WHERE cod_produto IN ('.$cod.')';
		$prep = $this->conn->prepare($sql);
		$prep->execute();
		return $prep->fetchAll();
	}
	
	
	function alterar() {
		$sql = "UPDATE ".$this->tabela." 
				SET nom_produto 	   = ?
				   ,num_produto 	   = ? 
				   ,num_estoque_alerta = ?
				   ,vlr_preco    	   = ?
				   ,url_slug    	   = ?
				   ,des_descricao      = ?
				   ,des_informacao     = ?
				   ,cod_status    	   = ?
				WHERE cod_produto 	   = ?";
		$prep = $this->conn->prepare($sql);
		$valores = array($this->nom_produto, $this->num_produto, $this->num_estoque_alerta, $this->vlr_preco, $this->url_slug, $this->des_descricao, $this->des_informacao, $this->cod_status, $this->id);
		$prep->execute($valores);	
	}
	
	function excluirArray($array) {
		$cod = '';
		foreach($array as $ln) {
			 $cod .= ",'$ln'"; 
		} 
		$cod = substr($cod, 1);
		
		$sql = 'DELETE FROM '.$this->tabela.' 
				WHERE cod_produto IN ('.$cod.')';
		$prep = $this->conn->prepare($sql);
		$prep->execute();
	}
}