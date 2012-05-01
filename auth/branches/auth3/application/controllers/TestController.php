<?php

class TestController extends Authz_Base_BaseController {
	/*
	public function preDispatch() {return true;
	}*/
	public function gogoAction() {
		$myArray = $this->_getParam('myarray');
		print_r($myArray);
	}
	public function popoAction() {
		$this->_helper->layout ()->enableLayout ();
		$this->_helper->viewRenderer->setNoRender ();
		echo 'Im in popo';
	}
	
	public function indexAction() {
		$this->_helper->layout ()->enableLayout ();
		$this->_helper->viewRenderer->setNoRender (false);
		echo 'Im in index';
	}
	

	public function gettestAction() {
	    $user = $_COOKIE['identity'];
	    echo "Hello $user";
	    
	}

}