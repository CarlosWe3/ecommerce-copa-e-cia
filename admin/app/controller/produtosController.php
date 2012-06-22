<?php
class produtosController extends controller {
	public function __construct() {
		parent::__construct();
		$this->loadModel();
	}
	
	public function index() {
		$this->_view->titulo = "Produtos";
		$this->_view->script = html::script(array('check.js'));
			
		$this->_view->res = $this->produtos->getListagem();
	}
		
	public function cadastrar() {
		$this->_view->titulo = "Produtos > Cadastrar";
		$this->_view->css = html::css(array('ui/jquery.ui.all.css', 'ui/demos.css'));
		$this->_view->script = html::script(array('geraSlug.js', 'toolTip.js', 'ui/jquery.ui.core.js', 'ui/jquery.ui.widget.js', 'ui/jquery.ui.tabs.js', 'ui/funcaoTab.js', 'ckeditor.js', 'masked_input.js', 'funcao_masked.js'));
		
		$this->loadModel('categorias');
		$this->_view->todasCategorias = $this->categorias->ativas();
		 
		 /*
		$this->loadModel('estados');
		$this->_view->todosEstados = $this->estados->procura('todos');
		*/
		
		$this->loadModel('status');
		$this->_view->todosStatus = $this->status->procura('todos');
		
		if (isset($_POST['cadastrar'])) {
			$nom_produto    = $_POST['nom_produto'];
			$num_produto    = $_POST['num_produto'];
			$num_alerta     = $_POST['num_alerta'];
			$num_valor      = $_POST['num_valor'];
			$des_desc 	    = $_POST['editor1'];
			$des_info 	    = $_POST['des_info'];
			$url_slug  	    = $_POST['url_slug'];
			$ind_status     = $_POST['ind_status'];
			$cod_categorias = $_POST['categorias'];
			
			$num_altura 		= $_POST['num_altura'];
			$num_largura 		= $_POST['num_largura'];
			$num_circunferencia = $_POST['num_circunferência'];
			$num_peso 			= $_POST['num_peso'];
			
			$campos = array($nom_produto,$num_valor,$url_slug);
		    $diferenteZero = model::diferenteZero($campos); //verifica se todos os campos do array contem valor
							
			if($diferenteZero == false) { //erro de campos vazios
				$this->_view->_msg 	   = 'Os campos marcados com asterisco (*) devem ser preenchidos!'; 
				$this->_view->_tipoMsg = 'erro';
			} else {	
				$this->produtos->nom_produto 		= $nom_produto;
				$this->produtos->num_produto 		= $num_produto;
				$this->produtos->num_estoque_alerta = $num_alerta;
				$this->produtos->vlr_preco   		= $num_valor;
				$this->produtos->url_slug   		= $url_slug;
				$this->produtos->des_descricao  	= $des_desc;
				$this->produtos->des_informacao  	= $des_info;
				$this->produtos->cod_status  		= $ind_status;
				$this->produtos->cadastrar();
				
				//captura ultimo id inserido
				$this->produtos->ultimo_id = $this->produtos->conn->lastInsertId();
								
				$this->loadModel('produtosDimensoes');			
				$this->produtosDimensoes->num_altura 		 = (int)$num_altura;
				$this->produtosDimensoes->num_largura 	     = (int)$num_largura;
				$this->produtosDimensoes->num_circunferencia = (int)$num_circunferencia;
				$this->produtosDimensoes->num_peso 		     = (int)$num_peso;
				$this->produtosDimensoes->cod_produto    	 = $this->produtos->ultimo_id;	 
				$this->produtosDimensoes->cadastrar();
				
				$this->loadModel('categoriasProdutos');
				$this->categoriasProdutos->cod_produto   = $this->clientes->conn->lastInsertId();
				$this->categoriasProdutos->porProduto($cod_categorias);
								
				//=============================================================
				 /*$this->loadModel('clienteInformacoes');
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
				$this->clienteInformacoes->cod_cliente			= $this->clientes->ultimo_id;
				$this->clienteInformacoes->cadastrar();
				
				$this->loadModel('clienteEnderecos');	
				$this->clienteEnderecos->des_endereco 	 = $des_endereco;
				$this->clienteEnderecos->num_endereco 	 = $num_endereco;
				$this->clienteEnderecos->num_cep   		 = $num_cep;
				$this->clienteEnderecos->nom_bairro   	 = $nom_bairro;
				$this->clienteEnderecos->des_complemento = $des_complemento;
				$this->clienteEnderecos->des_referencia  = $des_referencia;
				$this->clienteEnderecos->cod_cliente	 = $this->clientes->ultimo_id;
				$this->clienteEnderecos->cod_cidade      = $cod_cidade;
				$this->clienteEnderecos->cadastrar();
				*/
				
				$this->_view->_msg 	   = 'Produto cadastrado com sucesso!'; 
				$this->_view->_tipoMsg = 'sucesso';
				}
			}

		$this->_view->renderView('form');
	}
	
	public function visualizar($id = false) {
		$this->_view->titulo = "Produtos > Visualizar";
		$this->_view->script = html::script(array('toolTip.js'));
		
		if ($id) {
			 $this->produtos->id = $id;
			 $this->produtos->_set();
			 $this->_view->produtos = $this->produtos;
			 
			 $this->loadModel('status');
			 $this->status->id = $this->produtos->cod_status;
			 $this->status->_set();
			 $this->_view->status = $this->status;
			 
			 /*
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
			 $this->_view->status = $this->status;	*/		  
		}
	}
	
	public function alterar($id = false) {
		$this->_view->titulo = "Produtos > Alterar";
		$this->_view->css = html::css(array('ui/jquery.ui.all.css', 'ui/demos.css'));
		$this->_view->script = html::script(array('geraSlug.js', 'toolTip.js', 'ui/jquery.ui.core.js', 'ui/jquery.ui.widget.js', 'ui/jquery.ui.tabs.js', 'ui/funcaoTab.js'));
		
		$this->loadModel('categorias');
		$this->_view->todasCategorias = $this->categorias->ativas();
		
		if ($id) {
			$this->produtos->id = $id;
			$this->produtos->_set();
			$this->_view->produtos = $this->produtos;
			
			/*
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
			*/
			
			$this->loadModel('status');
			$this->_view->todosStatus = $this->status->procura('todos');
			
			if(isset($_POST['cadastrar'])) {
				$nom_produto = $_POST['nom_produto'];
				$num_produto = $_POST['num_produto'];
				$num_alerta  = $_POST['num_alerta'];
				$num_valor   = $_POST['num_valor'];
				$des_desc 	 = $_POST['des_desc'];
				$des_info 	 = $_POST['des_info'];
				$url_slug  	 = $_POST['url_slug'];
				$ind_status  = $_POST['ind_status'];
				
				$campos = array($nom_produto,$num_valor,$url_slug);
			    $diferenteZero = model::diferenteZero($campos); //verifica se todos os campos do array contem valor
							
				if($diferenteZero == false) { //erro de campos vazios
					$this->_view->_msg 	   = 'Os campos marcados com asterisco (*) devem ser preenchidos!'; 
					$this->_view->_tipoMsg = 'erro';
				} else {
					$this->produtos->id = $id;
					$this->produtos->nom_produto 		= $nom_produto;
					$this->produtos->num_produto 		= $num_produto;
					$this->produtos->num_estoque_alerta = $num_alerta;
					$this->produtos->vlr_preco   		= $num_valor;
					$this->produtos->url_slug   		= $url_slug;
					$this->produtos->des_descricao  	= $des_desc;
					$this->produtos->des_informacao  	= $des_info;
					$this->produtos->cod_status  		= $ind_status;
					$this->produtos->alterar();
					
					/*
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
					*/
					
					$this->_view->_msg 	   = 'Produto alterado com sucesso!'; 
					$this->_view->_tipoMsg = 'sucesso';
				}
			}
		}
		$this->_view->renderView('form');
	}
	
	public function excluir() {	
		$this->_view->selecionado = $this->produtos->selectArray($_POST['check']);
		$this->_view->titulo = "Produtos > Excluir";
		
		//caso não selecione nenhum produto
		if (count($_POST['check']) == 0) {
			session::setSession('_tipMsg', '');
			session::setSession("_msg", 'Selecione algum produto para excluir!');
			header("Location: ".BASE_URL."produtos");
			exit;
		} 	
		
		$this->_view->check = implode(',', $_POST['check']);
						
		if (isset($_POST['confirma'])) {
			$arrayCheck = explode(',', $_POST['check']); 
			
			/*$this->loadModel('clienteEnderecos');
			$this->clienteEnderecos->excluirArray($arrayCheck);
			
			$this->loadModel('clienteInformacoes');
			$this->clienteInformacoes->excluirArray($arrayCheck);
			*/
			
			$this->produtos->excluirArray($arrayCheck);
				
			session::setSession('_tipMsg', '');
			session::setSession("_msg", 'Produto(s) excluido(s) com sucesso!');
			header("Location: ".BASE_URL."produtos");
		}
		
		$this->_view->renderView('excluir');	
	}
}