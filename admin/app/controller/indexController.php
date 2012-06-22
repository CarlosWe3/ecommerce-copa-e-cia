<?php
class indexController extends controller {
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$this->_view->titulo = "Teste";
	}
}	