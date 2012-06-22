<?php
/**
 * Classe controller de configurações do site
 * @author Guilherme Lessa 22/06/12 - 13:50
 */
class configuracoesController extends controller {
	public function __construct() {
		parent::__construct();
		$this->loadModel();
	}
	
	/**
    * Método iniciado automaticamente no controller
    * @author Guilherme Lessa 22/06/12 - 14:00
	* @param int $id - chave primaria da configuração, se acaso mude, deve ser trocada manualmente
    */
	public function index($id = 1) {
		$this->_view->titulo = "Configurações";
		$this->_view->script = html::script(array('toolTip.js', 'alphaNumeric.js', 'chamadasAlphaNumeric.js'));
		
		//quando submeter o formulário de atualização
		if(isset($_POST['atualizar'])) {
			$nom_loja 			 = $_POST['nom_loja'];
			$des_email_principal = $_POST['email_principal'];
			$des_descricao_seo   = $_POST['des_site'];
			$des_metatag_seo	 = $_POST['meta_tags'];
			
			// função que verifica se os campos obrigatórios (array de campos) foram preenchido
			$campos = array($nom_loja,$des_email_principal,$des_descricao_seo,$_POST['meta_tags']);
		    $diferenteZero = model::diferenteZero($campos); //verifica se todos os campos do array contem valor

			if($diferenteZero == false) { //erro de campos vazios
				$this->_view->_msg 	   = 'Os campos marcados com asterisco (*) devem ser preenchidos!'; 
				$this->_view->_tipoMsg = 'erro';
			} else {
				$this->configuracoes->id 				  = $id;
				$this->configuracoes->nom_loja 			  = $nom_loja;
				$this->configuracoes->des_email_principal = $des_email_principal;
				$this->configuracoes->des_descricao_seo   = $des_descricao_seo;
				$this->configuracoes->des_metatag_seo     = $des_metatag_seo;
				$this->configuracoes->alterar();
					
				$this->_view->_msg 	   = 'Configurações atualizadas com sucesso!'; 
				$this->_view->_tipoMsg = 'sucesso';
			}
		}
		
		/**
		 * Método iniciado automaticamente no controller
		 * @author Guilherme Lessa 22/06/12 - 14:00
		 * @param int $id - chave primaria da configuração
		 */		
		if ($id) {
			//seta o id da configuração
			$this->configuracoes->id = $id;
			
			//chama o método
			$this->configuracoes->_set();
			
			//envia para visualização o resultado
			$this->_view->configuracoes = $this->configuracoes;
		}
	}
}