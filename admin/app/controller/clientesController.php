<?php
class clientesController extends controller {
	public function __construct() {
		parent::__construct();
		$this->loadModel();
		$this->loaderLib('data');
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
			 
			 $this->loadModel('cidades');
			 $this->cidades->id = $this->clienteInformacoes->cod_cidade;
			 $this->cidades->_set();
			 $this->_view->cidades = $this->cidades;
			 
			 $this->loadModel('estados');
			 $this->estados->id = $this->cidades->cod_estado;
			 $this->estados->_set();
			 $this->_view->estados = $this->estados;			  
		}
	}
	
	public function alterar($id = false) {
		$this->_view->titulo = "Clientes > Alterar";
		$this->_view->script = html::script(array('masked_input.js', 'funcao_masked.js', 'verifica_pj.js', 'input_int.js'));
		
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
			
			$this->loadModel('cidades');
			$this->_view->todasCidades = $this->cidades->procura('todos');
			 
			$this->loadModel('estados');
			$this->_view->todosEstados = $this->estados->procura('todos');
			
			if($_POST) {
				$nom 			 = $_POST['nom'];
				$dat_nascimento  = $_POST['dat_nascimento'];
				$num_tel 		 = $_POST['num_tel'];
				$num_cel 		 = $_POST['num_cel'];
				$des_email  	 = $_POST['des_email'];
				$des_senha  	 = $_POST['des_senha'];
				$ind_genero 	 = $_POST['ind_genero'];
				$ind_oferta 	 = $_POST['ind_oferta'];
				$num_rg 		 = $_POST['num_rg'];
				$num_cpf 		 = $_POST['num_cpf'];
				$ind_tipo 		 = $_POST['ind_tipo'];
				$num_cnpj 		 = $_POST['num_cnpj'];
				$des_endereco 	 = $_POST['des_endereco'];
				$num_endereco 	 = (int)$_POST['num_endereco'];
				$nom_bairro 	 = $_POST['nom_bairro'];
				$des_complemento = $_POST['des_complemento'];
				$des_referencia  = $_POST['des_referencia'];
				$num_cep 		 = $_POST['num_cep'];
				$cod_cidade 	 = $_POST['cod_cidade'];
				$cod_estado 	 = $_POST['cod_estado'];
				
				$campos = array($nom,$dat_nascimento,$num_tel,$num_rg,$num_cpf,$des_endereco,$num_endereco,$nom_bairro,$num_cep);
				$msg    = 'Os campos marcados com asterisco (*) devem ser preenchidos!';
				$tipo   = 'erro';
			    $diferenteZero = model::requerido($campos, $msg, $tipo);
				
				if($diferenteZero == true) {
					
					$this->cliente->alterar();
					
							
				
					$this->clienteInformacoes->alterar();
					$this->clienteEnderecos->alterar();
			    	$this->clienteTipos->alterar();
					
					$this->_view->_msg = "Cliente alterado com sucesso!"; 
					$this->_view->_tipoMsg = "sucesso";
				}
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