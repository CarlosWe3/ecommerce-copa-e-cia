<?php
class configuracoesModel extends model {
	
	public $tabela = "cec_configuracoes";
	public $nom_loja;
	public $des_email_principal;
	public $des_descricao_seo;
	public $des_metatag_seo;

	public function __construct() {
		parent::__construct();
	}
			
	function _set() {
		$res = $this->procura('unico');
		
		if($res) {
			$this->nom_loja  		   = $res['nom_loja'];
			$this->des_email_principal = $res['des_email_principal'];
			$this->des_descricao_seo   = $res['des_descricao_seo'];
			$this->des_metatag_seo     = $res['des_metatag_seo'];
		}
	}
	
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