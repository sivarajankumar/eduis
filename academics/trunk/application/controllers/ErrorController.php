<?php

class ErrorController extends Zend_Controller_Action {
	
	public function errorAction() {
		$errors = $this->_getParam ( 'error_handler' );
		
		switch ($errors->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE :
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER :
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION :
				
				// 404 error -- controller or action not found
				$this->getResponse ()->setHttpResponseCode ( 404 );
				$this->view->message = 'Page not found';
				break;
			default :
				// application error
				$this->getResponse ()->setHttpResponseCode ( 500 );
				$this->view->message = 'Application error';
				break;
		}
		
		// Log exception, if logger available
		$log = $this->getLog ();
		if ($log) {
			$log->crit ( '|||>>>>' . $errors->exception->getMessage () . '<<<<|||\R ' . $errors->exception->getTraceAsString (), $errors->exception );
		}
		
		// conditionally display exceptions
		if ($this->getInvokeArg ( 'displayExceptions' ) == true) {
			$this->view->exception = $errors->exception;
		}
		
		$this->view->request = $errors->request;
	}
	
	public function getLog() {
		if (Zend_Registry::isRegistered ( 'logger' )) {
			$log = Zend_Registry::get ( 'logger' );
			return $log;
		}
	
	}
	
	public function noaccessAction() {
		$errors = $this->_getParam ( 'aclError' );
		
		$log = $this->getLog ();
		if ($log) {
			$log->err ( $errors->exception->getMessage () );
		}
		
		if ($errors->request->isXmlHttpRequest ()) {
			$this->_helper->layout ()->disableLayout ();
			$this->_helper->viewRenderer->setNoRender ();
			$this->getResponse ()->setHttpResponseCode ( 403 );
			echo 'Access right is required.';
			return;
		} else {
			$this->view->message = 'Access right is required.';
			$this->view->exception = $errors->exception;
			$reqParams = $errors->request->getParams ();
			unset ( $reqParams ['aclError'] );
			$this->view->request = $reqParams;
		}
	
	}
}

