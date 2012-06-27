<?php
class menusController extends controller {
	public function __construct() {
		parent::__construct();
		$this->loadModel();
	}
}