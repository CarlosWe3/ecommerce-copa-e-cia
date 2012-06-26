<?php
/**
 * Classe model de produtos do site
 * @author Guilherme Lessa 26/06/12 - 17:45
 */
class produtosModel extends model {
	public $tabela = "cec_produtos";
	
	public $num_produto;
	public $num_estoque_alerta;
	public $vlr_preco;
	public $url_slug;
	public $des_descricao;
	public $des_informacao;
	public $cod_status;
	
	public $buscar_nom;
	public $buscar_val;
	public $buscar_des;
	public $buscar_dat_inicio_promo;
	public $buscar_dat_fim_promo;
	
	public function __construct() {
		parent::__construct();
	}
		
	public function getListagem() {
		/*
		$busca = '';
		if($this->buscar_nom) {
			$busca .= " AND P.nom_produto LIKE '%".$this->buscar_nom."%' ";
		}
		
		if($this->buscar_val) {
			$busca .= " AND P.vlr_preco = '%".$this->buscar_val."%' ";
		}
		
		if($this->buscar_des) {
			$busca .= " AND P.des_descricao LIKE '".$this->buscar_des."' ";
		}
		
		if($this->buscar_dat_inicio_promo) {
			$busca .= " AND PP.dat_inicio = '".$this->buscar_dat_inicio_promo."' ";
		}
		
		if($this->buscar_dat_fim_promo) {
			$busca .= " AND PP.dat_fim = '".$this->buscar_dat_fim_promo."' ";
		}
		 
		if($this->buscar_status) {
			$busca .= " AND S.cod_status = '".$this->buscar_status."' ";
		}*/	
		
		$sql = "SELECT P.cod_produto, 
		               P.nom_produto,
		               P.num_produto,
		               P.vlr_preco,
		               S.nom_status
		        FROM ".$this->tabela." as P,
	                   cec_status as S
		        WHERE P.cod_status = S.cod_status
		        ORDER BY P.cod_produto DESC";
				// "/*cec_produto_promocoes as PP*/"
		$prep = $this->conn->prepare($sql);
		$prep->execute();
		return $prep->fetchAll();
	}
	
	 /**
      * Método que seta as variáveis do controler com a unica configuração inserida no banco
      * @author Guilherme Lessa 26/06/12 - 17:50
      */
	function _set() {
		$res = $this->procura('unico');
		
		if($res) {
			$this->cod_produto  	  = $this->id;
			$this->nom_produto  	  = $res['nom_produto'];
			$this->num_produto  	  = $res['num_produto'];
			$this->num_estoque_alerta = $res['num_estoque_alerta'];
			$this->vlr_preco 		  = $res['vlr_preco'];
			$this->url_slug   		  = $res['url_slug'];
			$this->des_descricao      = $res['des_descricao'];
			$this->des_informacao     = $res['des_informacao'];
			$this->cod_status   	  = $res['cod_status'];
		}
	}
	
	/**
	* Método que cadastra produtos no site
	* @author Guilherme Lessa 26/06/12 - 17:50
	*/
	function cadastrar() {
		$sql = "insert into ".$this->tabela." 
				(nom_produto, num_produto, num_estoque_alerta, vlr_preco, url_slug, des_descricao, des_informacao, cod_status) 
				values ('".$this->nom_produto."',
						'".$this->num_produto."',
						'".$this->num_estoque_alerta."',
						'".$this->vlr_preco."',
						'".$this->url_slug."',
						'".$this->des_descricao."',
						'".$this->des_informacao."',
						'".$this->cod_status."')";
		$prep = $this->conn->prepare($sql);
		$prep->execute();
	}
	
	/**
	* Método que cria um pré-cadastro de produtos no site
	* @author Guilherme Lessa 26/06/12 - 17:50
	*/
	function preCadastro() {
		$sql = "insert into ".$this->tabela." 
				(cod_status) 
				values (3)";
		$prep = $this->conn->prepare($sql);
		$prep->execute();
	}
	
	/**
	* Método constroi um array com todos os cod/nomes dos produtos
	* @param array $array - array dos codigos/nomes de todos os produtos
	* @author Guilherme Lessa 26/06/12 - 17:55
	*/
	function selectArray($array) {
		$cod = '';
		foreach($array as $ln) {
			 $cod .= ",'$ln'"; 
		} 
		$cod = substr($cod, 1);
		
		$sql = 'SELECT cod_produto, 
		               nom_produto
		        FROM '.$this->tabela.'
		        WHERE cod_produto IN ('.$cod.')';
		$prep = $this->conn->prepare($sql);
		$prep->execute();
		return $prep->fetchAll();
	}
	
	/**
	* Método que altera produtos no site
	* @author Guilherme Lessa 26/06/12 - 17:55
	*/
	function alterar() {
		$sql = "UPDATE ".$this->tabela." 
				SET nom_produto 	   = ?
				   ,num_produto 	   = ? 
				   ,num_estoque_alerta = ?
				   ,vlr_preco    	   = ?
				   ,url_slug    	   = ?
				   ,des_descricao      = ?
				   ,des_informacao     = ?
				   ,cod_status    	   = ?
				WHERE cod_produto 	   = ?";
		$prep = $this->conn->prepare($sql);
		$valores = array($this->nom_produto, $this->num_produto, $this->num_estoque_alerta, $this->vlr_preco, $this->url_slug, $this->des_descricao, $this->des_informacao, $this->cod_status, $this->id);
		$prep->execute($valores);	
	}
	
	/**
	* Método que exclui todos os produtos selecionados, passados no array
	* @param array $array - array dos cod de todos os produtos selecionados a excluir
	* @author Guilherme Lessa 26/06/12 - 17:55
	*/
	function excluirArray($array) {
		$cod = '';
		foreach($array as $ln) {
			 $cod .= ",'$ln'"; 
		} 
		$cod = substr($cod, 1);
		
		$sql = 'DELETE FROM '.$this->tabela.' 
				WHERE cod_produto IN ('.$cod.')';
		$prep = $this->conn->prepare($sql);
		$prep->execute();
	}
	
	/**
	* Método que constroi um array com todos os nomes dos produtos 
	* passando o array na função autocomplete ui jquery, para selecionar produtos relacionados
	* @author Guilherme Lessa 26/06/12 - 18:00
	*/
	function arrayNomProdutos() {
		$sql = 'SELECT P.nom_produto
		        FROM '.$this->tabela.' AS P, cec_status AS S
				WHERE S.cod_status = 1
				AND P.cod_status = S.cod_status';
		$prep = $this->conn->prepare($sql);
		$prep->execute();
		
		$arrayNomProdutos = '';
		
		foreach($prep->fetchAll() as $ln) {
			 $arrayNomProdutos .= ',"'.$ln['nom_produto'].'"'; 
		} 
	
		return substr($arrayNomProdutos, 1);
	}
	
	/**
	* Método que limpa todos os produtos rascunhos, criados automaticamente quando se entra no cadastro de produtos e não terminados 
	* @author Guilherme Lessa 26/06/12 - 18:00
	*/
	public function excluirRascunhos() {
		$sql = 'SELECT P.cod_produto
		        FROM '.$this->tabela.' AS P, cec_status AS S
				WHERE S.cod_status = 3
				AND P.cod_status = S.cod_status';
		$prep = $this->conn->prepare($sql);
		$prep->execute();
		$rascunhos = $prep->fetchAll();
		
		foreach($rascunhos as $ln) {
			$sql = 'DELETE FROM cec_produtos_dimensoes
					WHERE cod_produto IN ('.$ln['cod_produto'].')';
			$prep = $this->conn->prepare($sql);
			$prep->execute();
			
			$sql = 'DELETE FROM cec_produto_estatisticas
					WHERE cod_produto IN ('.$ln['cod_produto'].')';
			$prep = $this->conn->prepare($sql);
			$prep->execute();
			
			$sql = 'DELETE FROM cec_produto_imagens
					WHERE cod_produto IN ('.$ln['cod_produto'].')';
			$prep = $this->conn->prepare($sql);
			$prep->execute();
			
			$sql = 'DELETE FROM cec_produto_promocoes
					WHERE cod_produto IN ('.$ln['cod_produto'].')';
			$prep = $this->conn->prepare($sql);
			$prep->execute();
			
			$sql = 'DELETE FROM cec_produto_relacionados
					WHERE cod_produto IN ('.$ln['cod_produto'].')';
			$prep = $this->conn->prepare($sql);
			$prep->execute();
			
			$sql = 'DELETE FROM '.$this->tabela.'
					WHERE cod_produto IN ('.$ln['cod_produto'].')';
			$prep = $this->conn->prepare($sql);
			$prep->execute();
		}
	}
}