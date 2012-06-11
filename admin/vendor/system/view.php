<?php
/**
 * Classo que controla a visualização.
 * @author Daniel Salvagni
 * @author Carlos Augusto Gartner
 *
 */
class view {
	
 	//instancia do controller instanciado no construction
    private $_controller;
    /**
     * 
     * HTML salvo na memória
     * @var String
     */
    public $_html = false;
    /**
	 * 
	 * Layout do site
	 * @var String
	 */
	public $_layout = 'admin';
	/**
	 * 
	 * Charset do site
	 * @param string $_charset
	 */
    public $_charset = "utf-8";
	/**
	 * 
	 * Charset do site
	 * @param string $_charset
	 */
    public $_idioma = "pt-BR";
	/**
	 * 
	 * Mensagem de erro
	 * @param string
	 */
	public $_msg = '';
	/**
	 * 
	 * Caso tenha erro
	 * @param boolean
	 */
	public $_erro = false;
	/**
	 * 
	 * Tipo da mensagem
	 * @param string - sucesso,noticia,erro
	 */
	public $_tipoMsg = 'sucesso';	
	/**
	 * 
	 * Título 
	 * @var string
	 */
    public $_titulo = "Administração ";
    
    function __construct(Request $request) {
        //instancia o controller a partir do objeto Request
        $this->_controller = $request->getController();
    } 
    
    /**
     * Renderiza a visualização do site.
     * @param String $name - Nome da view
     */
    function renderView($name) {
   	
		
    	//define o caminho da view
        $path_view 		= SITE_ROOT . 'app' . DS . 'view' . DS . $this->_controller . DS . $name . '.phtml';
        
        //define o caminho do template
        $path_template  = SITE_ROOT . 'app' . DS . 'webroot' . DS . 'template' . DS . $this->_layout . DS . 'index.php';
		
		//var_dump($path_view); exit;
    	
        if (is_readable($path_template)) {
        	// Gera ob start para que o HTML seja salvo na memória para ser incluído somente após o PHP terminar a execução.
        	ob_start();
        	require($path_template);
        	$this->_html = ob_get_contents();
        	ob_end_clean();
     		        	
        } else {
            //caso não seja possível ler o arquivo da view, executa uma exception
            throw new Exception("Não foi possível encontrar a view {$path_view}");
        }
        
    }
	
	/**
	 * Exibe mensagem de erro se existir!
	 */
	function getMensagem() {
		if (isset($_SESSION['_msg'])) {
			$msg  =  session::getSession('_msg');
			$this->_tipoMsg = isset($_SESSION['_tipMsg']) ? session::getSession('_tipMsg') : $this->_tipoMsg;
		} else {
			$msg  = isset($this->_msg) ? $this->_msg : false;
		}
		
		if ($msg) {
			switch ($this->_tipoMsg) {
				case 'sucesso':
					$classe = ' success';
					break;
					
				case 'noticia':
					$classe = ' notice';
					break;
					
				case 'erro':
					$classe = ' error';
					break;
				
			}
			
			echo "<p class=\"message{$classe}\">{$msg}</p>";
			unset($classe,$erro);
		}
	}
       
}