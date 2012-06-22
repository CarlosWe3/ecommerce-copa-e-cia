<?php
/**
 * Classe model de configurações do site
 * @author Guilherme Lessa 22/06/12 - 14:00
 */
class configuracoesModel extends model {
	public $tabela = "cec_configuracoes";
	public $nom_loja;
	public $des_email_principal;
	public $des_descricao_seo;
	public $des_metatag_seo;

	public function __construct() {
		parent::__construct();
	}
	
	 /**
      * Método que seta as variáveis do controler com a unica configuração inserida no banco
      * @author Guilherme Lessa 22/06/12 - 14:00
      */
	function _set() {
		$res = $this->procura('unico');
		
		if($res) {
			$this->nom_loja  		   = $res['nom_loja'];
			$this->des_email_principal = $res['des_email_principal'];
			$this->des_descricao_seo   = $res['des_descricao_seo'];
			$this->des_metatag_seo     = $res['des_metatag_seo'];
		}
	}
	
   /**
	* Método que altera as configurações do site
	* @author Guilherme Lessa 22/06/12 - 14:00
	*/
	function alterar() {
		$sql = "UPDATE ".$this->tabela." 
				SET nom_loja 			= ?
				   ,des_email_principal = ? 
				   ,des_descricao_seo	= ?
				   ,des_metatag_seo	    = ?
				WHERE cod_configuracao	= ? ";
		$prep = $this->conn->prepare($sql);
		$valores = array($this->nom_loja, $this->des_email_principal, $this->des_descricao_seo, $this->des_metatag_seo, $this->id);
		$prep->execute($valores);
	}
}