<?php
class clientesController extends controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$this->_view->titulo = "Clientes";
		
		html::css(array(''));
		$this->_view->script = html::script(array('masked_input.js', 'funcao_masked.js'));
	}
	
	public function cadastrar() {
		$this->_view->titulo = "Clientes";
		
		html::css(array(''));
		$this->_view->script = html::script(array('masked_input.js', 'funcao_masked.js'));
	}	
}	