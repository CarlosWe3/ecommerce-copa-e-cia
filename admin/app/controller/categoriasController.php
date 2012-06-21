<?php
class categoriasController extends controller {
	public function __construct() {
		parent::__construct();
		$this->loadModel();
	}
	
	public function index() {
		$this->_view->script = html::script(array('toolTip.js', 'check.js', 'geraSlug.js'));
		$this->_view->titulo = "Categorias";
		
		if(isset($_POST['buscar'])) {
			$this->categorias->buscar_nom   = $_POST['buscar_nom'];
			$this->categorias->buscar_des   = $_POST['buscar_des'];
			$this->categorias->buscar_slug  = $_POST['buscar_slug'];
		}
		
		$this->_view->res = $this->categorias->getListagem();
	}
	
	public function visualizar($id = false) {
		$this->_view->titulo = "Categorias > Visualizar";
		$this->_view->script = html::script(array('toolTip.js'));
		
		if ($id) {
			 $this->categorias->id = $id;
			 $this->categorias->_set();
			 $this->_view->categorias = $this->categorias;
			 
			 $this->loadModel('status');
			 $this->status->id = $this->categorias->cod_status;
			 $this->status->_set();
			 $this->_view->status = $this->status;			  
		}
	}
	
	public function excluir() {	
		$this->_view->selecionado = $this->categorias->selectArray($_POST['check']);
		$this->_view->titulo = "Categorias > Excluir";
		
		//caso não selecione nenhum cliente
		if (count($_POST['check']) == 0) {
			session::setSession('_tipMsg', '');
			session::setSession("_msg", 'Selecione alguma categoria para excluir!');
			header("Location: ".BASE_URL."clientes");
			exit;
		} 	
		
		$this->_view->check = implode(',', $_POST['check']);
	
		if (isset($_POST['confirma'])) {
			$arrayCheck = explode(',', $_POST['check']); 
		
			$this->categorias->excluirArray($arrayCheck);
				
			session::setSession('_tipMsg', '');
			session::setSession("_msg", 'Categoria(s) excluidas(s) com sucesso!');
			header("Location: ".BASE_URL."categorias");
		}
		
		$this->_view->renderView('excluir');	
	}
	
	public function alterar($id = false) {
		$this->_view->titulo = "Categorias > Alterar";
		$this->_view->script = html::script(array('toolTip.js', 'geraSlug.js'));
		
		if ($id) {
			$this->categorias->id = $id;
			$this->categorias->_set();
			$this->_view->categorias = $this->categorias;
			 
			$this->loadModel('status');
			$this->_view->todosStatus = $this->status->procura('todos');
			
			if(isset($_POST['cadastrar'])) {
				$nom_categoria = $_POST['nom_categoria'];
				$des_categoria = $_POST['des_categoria'];
				$txt_categoria = $_POST['txt_categoria'];
				$url_slug	   = $_POST['url_slug'];
				$cod_status	   = $_POST['ind_status'];
				
				$campos = array($nom_categoria,$url_slug);
			    $diferenteZero = model::diferenteZero($campos); //verifica se todos os campos do array contem valor

				if($diferenteZero == false) { //erro de campos vazios
					$this->_view->_msg 	   = 'Os campos marcados com asterisco (*) devem ser preenchidos!'; 
					$this->_view->_tipoMsg = 'erro';
				} else {
					$this->categorias->cod_categoria = $id;
					$this->categorias->nom_categoria = $nom_categoria;
					$this->categorias->des_categoria = $des_categoria;
					$this->categorias->txt_categoria = $txt_categoria;
					$this->categorias->url_slug  	 = $url_slug;
					$this->categorias->cod_status  	 = $cod_status;
					$this->categorias->alterar();
						
					$this->_view->_msg 	   = 'Categoria alterada com sucesso!'; 
					$this->_view->_tipoMsg = 'sucesso';
				}
			}
		}
		$this->_view->renderView('form');
	}
	
	
	public function cadastrar() {
		$this->_view->titulo = "Categorias > Cadastrar";
		$this->_view->script = html::script(array('toolTip.js', 'geraSlug.js'));
		
		$this->loadModel('status');
		$this->_view->todosStatus = $this->status->procura('todos');
		
		if(isset($_POST['cadastrar'])) {
			$nom_categoria = $_POST['nom_categoria'];
			$des_categoria = $_POST['des_categoria'];
			$txt_categoria = $_POST['txt_categoria'];
			$url_slug	   = $_POST['url_slug'];
			$cod_status	   = $_POST['ind_status'];
			
			$campos = array($nom_categoria,$url_slug);
		    $diferenteZero = model::diferenteZero($campos); //verifica se todos os campos do array contem valor

			if($diferenteZero == false) { //erro de campos vazios
				$this->_view->_msg 	   = 'Os campos marcados com asterisco (*) devem ser preenchidos!'; 
				$this->_view->_tipoMsg = 'erro';
			} else {
				$this->categorias->cod_categoria = $id;
				$this->categorias->nom_categoria = $nom_categoria;
				$this->categorias->des_categoria = $des_categoria;
				$this->categorias->txt_categoria = $txt_categoria;
				$this->categorias->url_slug  	 = $url_slug;
				$this->categorias->cod_status  	 = $cod_status;
				$this->categorias->cadastrar();
					
				$this->_view->_msg 	   = 'Categoria cadastrada com sucesso!'; 
				$this->_view->_tipoMsg = 'sucesso';
			}
		}
		
		$this->_view->renderView('form');
	}
}