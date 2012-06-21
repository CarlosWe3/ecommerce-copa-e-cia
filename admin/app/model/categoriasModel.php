<?php
class categoriasModel extends model {
	
	public $tabela = "cec_categorias";
	
	public $cod_categoria;
	public $nom_categoria;
	public $des_categoria;
	public $txt_categoria;
	public $url_slug;
	public $cod_status;
	
	public $buscar_nom;
	public $buscar_des;
	public $buscar_slug;
	
	public function __construct() {
		parent::__construct();
	}
		
	public function getListagem() {
		$busca = '';
		if($this->buscar_nom) {
			$busca .= " AND C.nom_categoria LIKE '%".$this->buscar_nom."%' ";
		}
		
		if($this->buscar_des) {
			$busca .= " AND C.des_categoria LIKE '%".$this->buscar_des."%' ";
		}
		
		if($this->buscar_slug) {
			$busca .= " AND C.url_slug LIKE '%".$this->buscar_slug."%' ";
		}
		
		$sql = "SELECT C.cod_categoria,
					   C.nom_categoria, 
		               C.des_categoria, 
		               C.txt_categoria,
		               C.url_slug,
		               S.nom_status
		        FROM ".$this->tabela." as C, 
	                   cec_status as S
		        WHERE C.cod_status = S.cod_status
		  		".$busca."     
		        ORDER BY C.cod_categoria DESC";
		$prep = $this->conn->prepare($sql);
		$prep->execute();
		$res = $prep->fetchAll();
		return $res;
	}
	
	function _set() {
		$res = $this->procura('unico');
		
		if($res) {
			$this->cod_categoria = $this->id;
			$this->nom_categoria = $res['nom_categoria'];
			$this->des_categoria = $res['des_categoria'];
			$this->txt_categoria = $res['txt_categoria'];
			$this->url_slug 	 = $res['url_slug'];
			$this->cod_status    = $res['cod_status'];
		}
	}
	
	function cadastrar() {
		$sql = "insert into ".$this->tabela." 
				(nom_categoria, des_categoria, txt_categoria, url_slug, cod_status) 
				values ('".$this->nom_categoria."',
						'".$this->des_categoria."',
						'".$this->txt_categoria."',
						'".$this->url_slug."',
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
		
		$sql = 'SELECT cod_categoria, 
		               nom_categoria
		        FROM '.$this->tabela.'
		        WHERE cod_categoria IN ('.$cod.')';
		$prep = $this->conn->prepare($sql);
		$prep->execute();
		return $prep->fetchAll();
	}
	
	function excluirArray($array) {
		$cod = '';
		foreach($array as $ln) {
			 $cod .= ",'$ln'"; 
		} 
		$cod = substr($cod, 1);
		
		$sql = 'DELETE FROM '.$this->tabela.' 
				WHERE cod_categoria IN ('.$cod.')';
		$prep = $this->conn->prepare($sql);
		$prep->execute();
	}
	
	function alterar() {
		$sql = "UPDATE ".$this->tabela." 
				SET nom_categoria = ?
				   ,des_categoria = ? 
				   ,txt_categoria = ?
				   ,url_slug	  = ?		
				   ,cod_status    = ?
				WHERE cod_categoria = ? ";
		$prep = $this->conn->prepare($sql);
		$valores = array($this->nom_categoria, $this->des_categoria, $this->txt_categoria, $this->url_slug, $this->cod_status, $this->cod_categoria);
		$prep->execute($valores);
	}
	
	function ativas(){
		$sql = 'SELECT cod_categoria, 
		               nom_categoria
		        FROM '.$this->tabela.' as C,
		        	 cec_status as S
		        WHERE S.COD_STATUS = 1 
		        AND C.COD_STATUS = S.COD_STATUS ';
		$prep = $this->conn->prepare($sql);
		$prep->execute();
		return $prep->fetchAll();
	}
}