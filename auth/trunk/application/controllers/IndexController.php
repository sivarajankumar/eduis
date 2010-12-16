<?php

class IndexController extends Authz_Base_BaseController {
	/*
	public function preDispatch() {return true;
	}*/
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		//$this->_helper->logger->debug ( Zend_Auth::getInstance()->getIdentity() );
		$cache = $this->getCache();
		// see if a cache already exists:
		if (($result = $cache->load ( 'myresult2' )) === false) {
			
			$result = array('one','two','three');
			
			$cache->save ( $result, 'myresult2' );
		
		} else {
			// cache hit! shout so that we know
			echo "This one is from cache!\n\n";
		
		}
		
		print_r ( $result );
		//$this->_helper->logger->debug ( $cache );
		/*echo '<pre>';
		print_r($cm);*/
	}

}