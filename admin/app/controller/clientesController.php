<?php
class clientesController extends controller {
	public function __construct() {
		parent::__construct();
		$this->loadModel();
	}
	
	public function index() {
		$this->_view->res = $this->clientes->getListagem();
		$this->_view->titulo = "Clientes";
		$this->_view->script = html::script(array('masked_input.js', 'funcao_masked.js', 'check.js'));
	}
	
	public function cadastrar() {
		$this->_view->titulo = "Clientes > Cadastrar";
		
		if ($_POST) {
			$this->clientes->nom_cliente = $_POST['nom_cliente'];
		}

		$this->_view->script = html::script(array('masked_input.js', 'funcao_masked.js', 'verifica_pj.js'));
		$this->_view->renderView('form');
	}	
	
	public function visualizar($id = false) {
		$this->_view->titulo = "Clientes > Visualizar";
		$this->_view->script = html::script(array('masked_input.js', 'funcao_masked.js'));
		
		if ($id) {
			 $this->clientes->id = $id;
			 $this->clientes->_set();
			 $this->_view->clientes = $this->clientes;
			 
			 $this->loadModel('clienteEnderecos');
			 $this->clienteEnderecos->cod_cliente = $this->clientes->id;
			 $this->clienteEnderecos->setPeloCliente();
			 $this->_view->enderecos = $this->clienteEnderecos;
			 
			 $this->loadModel('clienteInformacoes');
			 $this->clienteInformacoes->cod_cliente = $this->clientes->id;
			 $this->clienteInformacoes->setPeloCliente();
			 $this->_view->informacoes = $this->clienteInformacoes;
			 
			 $this->loadModel('clienteTipos');
			 $this->clienteTipos->id = $this->clienteInformacoes->cod_cliente_tipo;
			 $this->clienteTipos->_set();
			 $this->_view->tipos = $this->clienteTipos;
			 
			 $this->loadModel('clienteCidades');
			 $this->clienteCidades->id = $this->clienteEnderecos->cod_cidade;
			 $this->clienteCidades->_set();
			 $this->_view->cidades = $this->clienteCidades;
			 
			 $this->loadModel('clienteEstados');
			 $this->clienteEstados->id = $this->clienteCidades->cod_estado;
			 $this->clienteEstados->_set();
			 $this->_view->estados = $this->clienteEstados;
		}
	}
	
	public function alterar($id = false) {
		$this->_view->titulo = "Clientes > Alterar";
		$this->_view->script = html::script(array('masked_input.js', 'funcao_masked.js', 'verifica_pj.js'));
		
		if ($id) {
			$this->clientes->id = $id;
			$this->clientes->_set();
			$this->_view->clientes = $this->clientes;
			
			$this->loadModel('clienteEnderecos');
			$this->clienteEnderecos->cod_cliente = $this->clientes->id;
			$this->clienteEnderecos->setPeloCliente();
			$this->_view->enderecos = $this->clienteEnderecos;
			
			$this->loadModel('clienteInformacoes');
			$this->clienteInformacoes->cod_cliente = $this->clientes->id;
			$this->clienteInformacoes->setPeloCliente();
			$this->_view->informacoes = $this->clienteInformacoes;
			
			$this->loadModel('clienteTipos');
			$this->clienteTipos->id = $this->clienteInformacoes->cod_cliente_tipo;
			$this->clienteTipos->_set();
			$this->_view->tipos = $this->clienteTipos;
			
			$this->loadModel('clienteCidades');
			$this->clienteCidades->id = $this->clienteEnderecos->cod_cidade;
			$this->clienteCidades->_set();
			$this->_view->cidades = $this->clienteCidades;
			
			$this->loadModel('clienteEstados');
			$this->clienteEstados->id = $this->clienteCidades->cod_estado;
			$this->clienteEstados->_set();
			$this->_view->estados = $this->clienteEstados;
			
			if($_POST) {
			   $this->clienteEnderecos->alterar();
			   $this->clienteInformacoes->alterar();
			   $this->clienteTipos->alterar();
			   $this->clienteCidades->alterar();
			   $this->clienteEstados->alterar();
			}			 
		}
		
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