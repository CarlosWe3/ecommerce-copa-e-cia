<?php
class menusModel extends model {
	public $tabela = "cec_menus";
	public $cod_menu;
	public $nom_menu;
	public $cod_status;
	
	public $buscar_nom;
	public $buscar_item;
	public $buscar_url;
	public $buscar_status;
	
	public function __construct() {
		parent::__construct();
	}
	
	function _set() {
		$res = $this->procura('unico');
		
		if($res) {
			$this->cod_menu   = $this->id;
			$this->nom_menu   = $res['nom_menu'];
			$this->cod_status = $res['cod_status'];
		}
	}

	public function getListagem() {
		$busca = '';
		if($this->buscar_nom) {
			$busca .= " AND M.nom_menu LIKE '%".$this->buscar_nom."%' ";
		}
		
		if($this->buscar_item) {
			$sql = "SELECT cod_menu,
			        FROM cec_menu_itens, 
			        WHERE nom_item LIKE '%".$this->buscar_nom."%' ";
			$prep = $this->conn->prepare($sql);
			$prep->execute();
			$codPorItem = $prep->fetchAll();
						
			$busca .= " AND M.cod_menu IN(".implode(',', $codPorItem).") ";
		}
		
		if($this->buscar_url) {
			$sql = "SELECT cod_menu,
			        FROM cec_menu_itens, 
			        WHERE url_item LIKE '%".$this->buscar_url."%' ";
			$prep = $this->conn->prepare($sql);
			$prep->execute();
			$codPorUrl = $prep->fetchAll();
						
			$busca .= " AND M.cod_menu IN(".implode(',', $codPorUrl).") ";
		}
		
		if($this->buscar_status) {
			$busca .= " AND M.cod_status = ".$this->buscar_status." ";
		}
		
		$sql = "SELECT M.cod_menu,
					   M.nom_menu, 
		               S.nom_status
		        FROM ".$this->tabela." as M, 
	                   cec_status as S
		        WHERE M.cod_status = S.cod_status
		        ".$busca."
		        ORDER BY M.cod_menu DESC";
		$prep = $this->conn->prepare($sql);
		$res = $prep->execute();
		var_dump($prep->errorInfo());



		
		return $res;
	}
}