<?php
/**
 * Classe controller de categorias de produtos
 * @author Guilherme Lessa 22/06/12 - 12:50
 */
class categoriasController extends controller {
	public function __construct() {
		parent::__construct();
		$this->loadModel();
	}
	
   /**
    * Método iniciado automaticamente no controller
    * @author Guilherme Lessa 22/06/12 - 13:00
    */
	public function index() {
		$this->_view->script = html::script(array('toolTip.js', 'check.js', 'geraSlug.js'));
		$this->_view->titulo = "Categorias";
	
		if(isset($_POST['buscar'])) {
		/*
		 * se foi executado uma busca de categorias, 
		 * então seta váriaveis de busca, filtrando resultados do getListagem()
		 */
			$this->categorias->buscar_nom   = $_POST['buscar_nom'];
			$this->categorias->buscar_des   = $_POST['buscar_des'];
			$this->categorias->buscar_slug  = $_POST['buscar_slug'];
		}
		
		$this->_view->res = $this->categorias->getListagem();
	}
	
   /**
	* Método que exibe a categoria clicada
    * @param int $id - chave primaria da categoria capturada na url, seta a categoria a exibir
	* @author Guilherme Lessa 22/06/12 - 13:00
	*/
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
	
   /**
    * Método exclui categoria atraves dos checkbox
    * @author Guilherme Lessa 22/06/12 - 13:00
    */
	public function excluir() {	
		$this->_view->selecionado = $this->categorias->selectArray($_POST['check']);
		$this->_view->titulo = "Categorias > Excluir";
		
		//caso não selecione nenhuma categoria para exluir
		if (count($_POST['check']) == 0) {
			session::setSession('_tipMsg', '');
			session::setSession("_msg", 'Selecione alguma categoria para excluir!');
			header("Location: ".BASE_URL."categorias");
			exit;
		} 	
		
		//remove as vírgulas (,) do array 
		$this->_view->check = implode(',', $_POST['check']);
		
		//se confirmar exclusão
		if (isset($_POST['confirma'])) {
			$arrayCheck = explode(',', $_POST['check']); 
			
			//metodo que exclui todas as categorias do array, construido via checkbox
			$this->categorias->excluirArray($arrayCheck);
				
			session::setSession('_tipMsg', '');
			session::setSession("_msg", 'Categoria(s) excluidas(s) com sucesso!');
			header("Location: ".BASE_URL."categorias");
		}
		
		$this->_view->renderView('excluir');	
	}
	
   /**
    * Método que altera a categoria clicada
    * @param int $id - chave primaria da categoria capturada na url, seta a categoria a alterar
    * @author Guilherme Lessa 22/06/12 - 13:00
    */
	public function alterar($id = false) {
		$this->_view->titulo = "Categorias > Alterar";
		$this->_view->script = html::script(array('toolTip.js', 'geraSlug.js'));
		
		if ($id) {
			$this->categorias->id = $id;
			$this->categorias->_set();
			$this->_view->categorias = $this->categorias;
			 
			$this->loadModel('status');
			$this->_view->todosStatus = $this->status->procura('todos');
			
			//quando submeter o formulário de alteração
			if(isset($_POST['cadastrar'])) {
				$nom_categoria = $_POST['nom_categoria'];
				$des_categoria = $_POST['des_categoria'];
				$txt_categoria = $_POST['txt_categoria'];
				$url_slug	   = $_POST['url_slug'];
				$cod_status	   = $_POST['ind_status'];
				
				// função que verifica se os campos obrigatórios (array de campos) foram preenchido
				$campos = array($nom_categoria,$url_slug);
			    $diferenteZero = model::diferenteZero($campos);

				if($diferenteZero == false) { //se algum campo obrigatório não for preenchido, erro
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
	
   /**
    * Método que cadastra novas categorias
    * @author Guilherme Lessa 22/06/12 - 13:00
    */
	public function cadastrar() {
		$this->_view->titulo = "Categorias > Cadastrar";
		$this->_view->script = html::script(array('toolTip.js', 'geraSlug.js'));
		
		$this->loadModel('status');
		$this->_view->todosStatus = $this->status->procura('todos');
		
		//quando submeter o formulário de alteração
		if(isset($_POST['cadastrar'])) {
			$nom_categoria = $_POST['nom_categoria'];
			$des_categoria = $_POST['des_categoria'];
			$txt_categoria = $_POST['txt_categoria'];
			$url_slug	   = $_POST['url_slug'];
			$cod_status	   = $_POST['ind_status'];
			
			
			// função que verifica se os campos obrigatórios (array de campos) foram preenchido
			$campos = array($nom_categoria,$url_slug);
		    $diferenteZero = model::diferenteZero($campos);

			if($diferenteZero == false) { //se algum campo obrigatório não for preenchido, erro
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