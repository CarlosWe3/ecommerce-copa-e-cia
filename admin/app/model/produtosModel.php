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
	
	public $buscar_nom;
	public $buscar_val;
	public $buscar_des;
	public $buscar_dat_inicio_promo;
	public $buscar_dat_fim_promo;
	
	public function __construct() {
		parent::__construct();
	}
		
	public function getListagem() {
		
	
		/*
		$busca = '';
		if($this->buscar_nom) {
			$busca .= " AND P.nom_produto LIKE '%".$this->buscar_nom."%' ";
		}
		
		if($this->buscar_val) {
			$busca .= " AND P.vlr_preco = '%".$this->buscar_val."%' ";
		}
		
		if($this->buscar_des) {
			$busca .= " AND P.des_descricao LIKE '".$this->buscar_des."' ";
		}
		
		if($this->buscar_dat_inicio_promo) {
			$busca .= " AND PP.dat_inicio = '".$this->buscar_dat_inicio_promo."' ";
		}
		
		if($this->buscar_dat_fim_promo) {
			$busca .= " AND PP.dat_fim = '".$this->buscar_dat_fim_promo."' ";
		}
		 
		if($this->buscar_status) {
			$busca .= " AND S.cod_status = '".$this->buscar_status."' ";
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
				// "/*cec_produto_promocoes as PP*/"
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
	
	function arrayNomProdutos() {
		$sql = 'SELECT nom_produto
		        FROM '.$this->tabela.'';
		$prep = $this->conn->prepare($sql);
		$prep->execute();
		
		$arrayNomProdutos = '';
		foreach($prep->fetchAll() as $ln) {
			 $arrayNomProdutos .= ',"'.$ln['nom_produto'].'"'; 
		} 
		
		return substr($arrayNomProdutos, 1);
	}
	
	function validaNomeDiferente(){
		$sql = 'SELECT nom_produto
		        FROM '.$this->tabela.'
		        WHERE nom_produto = ';
		$prep = $this->conn->prepare($sql);
		$prep->execute();
	}
}