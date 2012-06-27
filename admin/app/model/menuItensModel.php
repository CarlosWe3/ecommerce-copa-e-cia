<?php
class menuItensModel extends model {
	public $tabela = "cec_menu_itens";
	public $cod_menu_item;
	public $nom_item;
	public $url_item;
	public $cod_menu;
	
	public function __construct() {
		parent::__construct();
	}
	
	function _set() {
		$res = $this->procura('unico');
		
		if($res) {
			$this->cod_menu_item = $this->id;
			$this->nom_item 	 = $res['nom_item'];
			$this->url_item 	 = $res['url_item'];
			$this->cod_menu 	 = $res['cod_menu'];
		}
	}
}