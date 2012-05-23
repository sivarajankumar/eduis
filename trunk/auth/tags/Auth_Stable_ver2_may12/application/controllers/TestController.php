<?php

class TestController extends Authz_Base_BaseController {
	/*
	public function preDispatch() {return true;
	}*/
	public function gogoAction() {
		$this->_helper->layout ()->enableLayout ();
		$this->_helper->viewRenderer->setNoRender ();
		echo 'Im in gogo';
	}
	public function popoAction() {
		$this->_helper->layout ()->enableLayout ();
		$this->_helper->viewRenderer->setNoRender ();
		echo 'Im in popo';
	}
	

	public function gettestAction() {
	    $user = $_COOKIE['identity'];
	    echo "Hello $user";
	    
	}

}