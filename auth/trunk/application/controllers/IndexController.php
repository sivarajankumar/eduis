<?php

class IndexController extends Authz_Base_BaseController {
	/*
	public function preDispatch() {return true;
	}*/
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
	}

}