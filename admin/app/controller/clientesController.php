<?php
class clientesController extends controller {
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$this->_view->titulo = "Clientes";
		$this->_view->script = html::script(array('masked_input.js', 'funcao_masked.js', 'check.js'));
	}
	
	public function cadastrar() {
		$this->_view->titulo = "Clientes > Cadastrar";
		$this->_view->script = html::script(array('masked_input.js', 'funcao_masked.js', 'verifica_pj.js'));
		$this->_view->renderView('form');
	}	
	
	public function visualizar() {
		$this->_view->titulo = "Clientes > Visualizar";
	}
	
	public function alterar() {
		$this->_view->titulo = "Clientes > Alterar";
		$this->_view->script = html::script(array('masked_input.js', 'funcao_masked.js', 'verifica_pj.js'));
		$this->_view->renderView('form');
	}
	
	public function excluir() {
		//$_POST['confirma_excluir']) {
		//session::setSession('_msg', 'Clientes excluidos com sucesso!');
		//session::setSession('_tipMsg', '');
		/*
		if ($_POST['confirma_excluir']) {
			session::setSession('_msg', 'Clientes excluidos com sucesso!');
			header("Location: ".BASE_URL."clientes");
		}
		*/
				
		$this->_view->titulo = "Clientes > Excluir";
		$this->_view->renderView('excluir');	
	}
}	