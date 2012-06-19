<?php
class cidadesController extends controller {
	public function __construct() {
		parent::__construct();
		$this->loadModel();
		$this->loaderLib('data');
	}
	
	public function geraCidades() {
			$this->_view->_layout = 'ajax';
			
			
			if ($_POST['cod_estado']) {
				$res = $this->cidades->procura('todos',array('cod_estado'=>$_POST['cod_estado']));
				$this->_view->res = $res;
			}
							
			$this->_view->renderView('geraCidades');	
	}
}