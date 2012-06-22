<?php
/**
 * Classe controller de cidades 
 * @author Guilherme Lessa 22/06/12 - 13:20
 */
class cidadesController extends controller {
	public function __construct() {
		parent::__construct();
		$this->loadModel();
		$this->loaderLib('data');
	}
	
	/**
     * Método exibe as cidades no select option após selecionar estado (via  ajax)
     * @author Guilherme Lessa 22/06/12 - 13:00
     */
	public function geraCidades() {
			$this->_view->_layout = 'ajax';
			
			//se selecionou algum estado, exibe as cidades do respectivo estado
			if ($_POST['cod_estado']) {
				$res = $this->cidades->procura('todos',array('cod_estado'=>$_POST['cod_estado']));
				$this->_view->res = $res;
			}
			
			//manda o array para a visualização				
			$this->_view->renderView('geraCidades');	
	}
}