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
		$this->_view->script = html::script(array('masked_input.js', 'funcao_masked.js', 'verifica_pj.js', 'input_int.js', 'geraCidades.js'));
		
		$this->loadModel('cidades');
		$this->_view->todasCidades = $this->cidades->procura('todos');
		 
		$this->loadModel('estados');
		$this->_view->todosEstados = $this->estados->procura('todos');
		
		$this->loadModel('status');
		$this->_view->todosStatus = $this->status->procura('todos');
		
		if (isset($_POST['cadastrar'])) {
			$nom 			 = $_POST['nom'];
			$dat_nascimento  = data::dataMysql($_POST['dat_nascimento']);
			$num_tel 		 = $_POST['num_tel'];
			$num_cel 		 = $_POST['num_cel'];
			$des_email  	 = $_POST['des_email'];
			$des_senha  	 = criptografia::md5($_POST['des_senha']);
			$ind_genero 	 = $_POST['ind_genero'];
			$ind_oferta 	 = $_POST['ind_oferta'];
			$ind_status      = $_POST['ind_status'];
			$num_rg 		 = $_POST['num_rg'];
			$num_cpf 		 = $_POST['num_cpf'];
			$ind_genero  	 = $_POST['ind_genero'];
			$num_cnpj 		 = $_POST['num_cnpj'];
			//caso nao preencha cnpj, sempre será pessoa fisica (tipo = 1)
			if(!$_POST['num_cnpj']) {
				$ind_tipo = 1;
			} else {
				$ind_tipo 	 = $_POST['ind_tipo'];
			}
			$des_endereco 	 = $_POST['des_endereco'];
			$num_endereco 	 = (int)$_POST['num_endereco'];
			$nom_bairro 	 = $_POST['nom_bairro'];
			$des_complemento = $_POST['des_complemento'];
			$des_referencia  = $_POST['des_referencia'];
			$num_cep 		 = (int)str_replace('-', '', $_POST['num_cep']);
			$cod_cidade 	 = $_POST['cod_cidade'];
			$cod_estado 	 = $_POST['cod_estado'];
		
			$campos = array($nom,$dat_nascimento,$num_tel,$num_rg,$num_cpf,$des_endereco,$num_endereco,$nom_bairro,$num_cep);
		    $diferenteZero = model::diferenteZero($campos); //verifica se todos os campos do array contem valor
							
			if($_POST['des_senha']) {//so verifica tamanho da senha se houver senha
				$tamSenha = model::tam_string($_POST['des_senha'], 6, 20); //verifica tamanho da senha de min 6 e max 20
			} else {//então se não houver senha, ela automaticamente é true
				$tamSenha = true;
			}

			if($diferenteZero == false) { //erro de campos vazios
				$this->_view->_msg 	   = 'Os campos marcados com asterisco (*) devem ser preenchidos!'; 
				$this->_view->_tipoMsg = 'erro';
			} else if($tamSenha == false) { //erro de tamanho de senha
				$this->_view->_msg 	   = 'O tamanho da senha deve estar entre 6 e 20 caractéres.'; 
				$this->_view->_tipoMsg = 'erro';
			} else {	
				$this->clientes->nom_cliente  = $nom;
				$this->clientes->des_email    = $des_email;
				$this->clientes->des_senha    = $des_senha;
				$this->clientes->dat_cadastro = time();
				$this->clientes->cod_status   = $ind_status;
				$this->clientes->cadastrar();
				$this->clientes->ultimo_id    = $this->_clientes->conn->lastInsertId();
				
				$this->loadModel('clienteInformacoes');
				$this->clienteInformacoes->num_rg 				= $num_rg;
				$this->clienteInformacoes->num_cpf 				= $num_cpf;
				$this->clienteInformacoes->num_cnpj   			= $num_cnpj;
				$this->clienteInformacoes->dat_alteracao   		= time();
				$this->clienteInformacoes->ind_genero  			= $ind_genero;
				$this->clienteInformacoes->dat_nascimento 		= $dat_nascimento;
				$this->clienteInformacoes->num_telefone_fixo 	= $num_tel;
				$this->clienteInformacoes->num_telefone_celular = $num_cel;
				$this->clienteInformacoes->ind_recebe_oferta   	= $ind_oferta;
				$this->clienteInformacoes->cod_cliente_tipo 	= $ind_tipo;
				$this->clienteInformacoes->cod_cliente			= 8;
				//$this->clienteInformacoes->cadastrar();
				
				$this->loadModel('clienteEnderecos');	
				$this->clienteEnderecos->des_endereco 	 = $des_endereco;
				$this->clienteEnderecos->num_endereco 	 = $num_endereco;
				$this->clienteEnderecos->num_cep   		 = $num_cep;
				$this->clienteEnderecos->nom_bairro   	 = $nom_bairro;
				$this->clienteEnderecos->des_complemento = $des_complemento;
				$this->clienteEnderecos->des_referencia  = $des_referencia;
				$this->clienteEnderecos->cod_cliente	 = 8;
				$this->clienteEnderecos->cod_cidade      = $cod_cidade;
				//$this->clienteEnderecos->cadastrar();
				
				$this->_view->_msg 	   = 'Cliente cadastrado com sucesso!'; 
				$this->_view->_tipoMsg = 'sucesso';
				}
			}

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
			 $this->cidades->id = $this->clienteEnderecos->cod_cidade;
			 $this->cidades->_set();
			 $this->_view->cidades = $this->cidades;
			 
			 $this->loadModel('estados');
			 $this->estados->id = $this->cidades->cod_estado;
			 $this->estados->_set();
			 $this->_view->estados = $this->estados;
			 
			 $this->loadModel('status');
			 $this->status->id = $this->clientes->cod_status;
			 $this->status->_set();
			 $this->_view->status = $this->status;			  
		}
	}
	
	public function alterar($id = false) {
		$this->_view->titulo = "Clientes > Alterar";
		$this->_view->script = html::script(array('masked_input.js', 'funcao_masked.js', 'verifica_pj.js', 'input_int.js', 'geraCidades.js'));
		
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
			
			$this->loadModel('status');
			$this->_view->todosStatus = $this->status->procura('todos');
			
			$this->loadModel('cidades');
			$this->_view->todasCidades = $this->cidades->procura('todos');
			 
			$this->loadModel('estados');
			$this->_view->todosEstados = $this->estados->procura('todos');
			
			if(isset($_POST['cadastrar'])) {
				$nom 			 = $_POST['nom'];
				$dat_nascimento  = data::dataMysql($_POST['dat_nascimento']);
				$num_tel 		 = $_POST['num_tel'];
				$num_cel 		 = $_POST['num_cel'];
				$des_email  	 = $_POST['des_email'];
				$des_senha  	 = criptografia::md5($_POST['des_senha']);
				$ind_genero 	 = $_POST['ind_genero'];
				$ind_oferta 	 = $_POST['ind_oferta'];
				$ind_status      = $_POST['ind_status'];
				$num_rg 		 = $_POST['num_rg'];
				$num_cpf 		 = $_POST['num_cpf'];
				$ind_genero  	 = $_POST['ind_genero'];
				$ind_tipo 		 = $_POST['ind_tipo'];
				$num_cnpj 		 = $_POST['num_cnpj'];
				//caso nao preencha cnpj, sempre será pessoa fisica (tipo = 1)
				if(!$_POST['num_cnpj']) {
					$ind_tipo = 1;
				}
				$des_endereco 	 = $_POST['des_endereco'];
				$num_endereco 	 = (int)$_POST['num_endereco'];
				$nom_bairro 	 = $_POST['nom_bairro'];
				$des_complemento = $_POST['des_complemento'];
				$des_referencia  = $_POST['des_referencia'];
				$num_cep 		 = (int)str_replace('-', '', $_POST['num_cep']);
				$cod_cidade 	 = $_POST['cod_cidade'];
				$cod_estado 	 = $_POST['cod_estado'];
				
				$campos = array($nom,$dat_nascimento,$num_tel,$num_rg,$num_cpf,$des_endereco,$num_endereco,$nom_bairro,$num_cep);
			    $diferenteZero = model::diferenteZero($campos); //verifica se todos os campos do array contem valor
								
				if($_POST['des_senha']) {//so verifica tamanho da senha se houver senha
					$tamSenha = model::tam_string($_POST['des_senha'], 6, 20); //verifica tamanho da senha de min 6 e max 20
				} else {//então se não houver senha, ela automaticamente é true
					$tamSenha = true;
				}

				if($diferenteZero == false) { //erro de campos vazios
					$this->_view->_msg 	   = 'Os campos marcados com asterisco (*) devem ser preenchidos!'; 
					$this->_view->_tipoMsg = 'erro';
				} else if($tamSenha == false) { //erro de tamanho de senha
					$this->_view->_msg 	   = 'O tamanho da senha deve estar entre 6 e 20 caractéres.'; 
					$this->_view->_tipoMsg = 'erro';
				} else {
					$this->clientes->cod_cliente = $id;
					$this->clientes->nom_cliente = $nom;
					$this->clientes->des_email   = $des_email;
					$this->clientes->des_senha   = $des_senha;
					$this->clientes->cod_status  = $ind_status;
					$this->clientes->alterar();
					
					$this->clienteInformacoes->num_rg 				= $num_rg;
					$this->clienteInformacoes->num_cpf 				= $num_cpf;
					$this->clienteInformacoes->num_cnpj   			= $num_cnpj;
					$this->clienteInformacoes->dat_alteracao   		= time();
					$this->clienteInformacoes->ind_genero  			= $ind_genero;
					$this->clienteInformacoes->dat_nascimento 		= $dat_nascimento;
					$this->clienteInformacoes->num_telefone_fixo 	= $num_tel;
					$this->clienteInformacoes->num_telefone_celular = $num_cel;
					$this->clienteInformacoes->ind_recebe_oferta   	= $ind_oferta;
					$this->clienteInformacoes->cod_cliente_tipo 	= $ind_tipo;
					$this->clienteInformacoes->cod_cliente			= $id;
					$this->clienteInformacoes->alterar();
					
					$this->clienteEnderecos->cod_cliente 	 = $id;
					$this->clienteEnderecos->des_endereco 	 = $des_endereco;
					$this->clienteEnderecos->num_endereco 	 = $num_endereco;
					$this->clienteEnderecos->num_cep   		 = $num_cep;
					$this->clienteEnderecos->nom_bairro   	 = $nom_bairro;
					$this->clienteEnderecos->des_complemento = $des_complemento;
					$this->clienteEnderecos->des_referencia  = $des_referencia;
					$this->clienteEnderecos->cod_cliente	 = $id;
					$this->clienteEnderecos->cod_cidade      = $cod_cidade;
					$this->clienteEnderecos->alterar();
					
					$this->_view->_msg 	   = 'Cliente alterado com sucesso!'; 
					$this->_view->_tipoMsg = 'sucesso';
				}
			}
		}
		$this->_view->renderView('form');
	}
	
	public function excluir() {	
		$this->_view->selecionado = $this->clientes->selectArray($_POST['check']);
		$this->_view->titulo = "Clientes > Excluir";
		
		//caso não selecione nenhum cliente
		if (count($_POST['check']) == 0) {
			session::setSession('_tipMsg', '');
			session::setSession("_msg", 'Selecione algum cliente para excluir!');
			header("Location: ".BASE_URL."clientes");
			exit;
		} 	
		
		$this->_view->check = implode(',', $_POST['check']);
	
		if (isset($_POST['confirma'])) {
			$arrayCheck = explode(',', $_POST['check']); 
			
			$this->loadModel('clienteEnderecos');
			$this->clienteEnderecos->excluirArray($arrayCheck);
			
			$this->loadModel('clienteInformacoes');
			$this->clienteInformacoes->excluirArray($arrayCheck);
			
			$this->clientes->excluirArray($arrayCheck);
				
			session::setSession('_tipMsg', '');
			session::setSession("_msg", 'Clientes excluidos com sucesso!');
			header("Location: ".BASE_URL."clientes");
		}
		
		$this->_view->renderView('excluir');	
	}
}