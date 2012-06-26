<?php
class produtosRelacionadosController extends controller {
	public function __construct() {
		parent::__construct();
		$this->loadModel('produtosRelacionados');
	}
	
	public function cadastrar() {
		$this->_view->_layout = 'ajax';
		
		$this->produtosRelacionados->cod_produto = $_POST['cod_produto'];
		
		$this->loadModel('produtos');
		$res = $this->produtos->procura('unico',array('nom_produto'=>$_POST['nom_prod_relacionado']));
		$this->produtosRelacionados->cod_produto_relacionado = $res['cod_produto'];
				
		$this->produtosRelacionados->cod_relacionamento_tipo = $_POST['cod_relacionamento_tipo'];
				
		$this->produtosRelacionados->cadastrar();
	}
	
	public function excluir() {
		$this->_view->_layout = 'ajax';
		
		$this->produtosRelacionados->id = $_POST['cod_relacionado'];
		
		$this->produtosRelacionados->excluir();
	}
}
	