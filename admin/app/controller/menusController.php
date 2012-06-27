<?php
class menusController extends controller {
	public function __construct() {
		parent::__construct();
		$this->loadModel();
	}
	
	public function index() {
		$this->_view->script = html::script(array('check.js'));
		$this->_view->titulo = "Menus";
	
		if(isset($_POST['buscar'])) {
			/*
			 * se foi executado uma busca de menus, 
			 * então seta váriaveis de busca, filtrando resultados do getListagem()
			 */
			$this->menus->buscar_nom  	 = $_POST['buscar_nom'];
			$this->menus->buscar_item 	 = $_POST['buscar_item'];
			$this->menus->buscar_url  	 = $_POST['buscar_url'];
			$this->menus->buscar_status  = $_POST['buscar_status'];
		}
		
		$this->loadModel('status');
		$this->_view->todosStatus = $this->status->procura('todos');
		
		$this->_view->res = $this->menus->getListagem();
	}
	
	public function visualizar($id = false) {
		if ($id) {
			 $this->menus->id = $id;
			 $this->menus->_set();
			 $this->_view->menus = $this->menus;
			 
			 $this->loadModel('status');
			 $this->status->id = $this->menus->cod_status;
			 $this->status->_set();
			 $this->_view->status = $this->status;		
			 
			 $this->loadModel('menuItens');
			 $this->_view->menuItens = $this->menuItens->procura('todos', array('cod_menu'=>$id));  	  
			 
			 $this->_view->titulo = "Menus > Visualizar > #".$this->menus->cod_menu.' '.$this->menus->nom_menu;
		}
	}
}