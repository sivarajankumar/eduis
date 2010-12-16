<?php
class AuthenticateController extends Zend_Controller_Action {
	const AUTH_PATH = '/authenticate';
	const AUTH_SID = 'ACESID';
	
	public function indexAction() {
		$this->_helper->layout ()->disableLayout ();
		$authData = Zend_Auth::getInstance ()->getStorage ()->read ();
		if ($authData ['identity'] != 'anon') {
			$this->_helper->redirector ( 'index', 'index' );
		} else {
			$loginForm = new Auth_Form_Auth_Login ( $_POST );
			$authAdapter = null;
			
			if ($this->getRequest ()->isPost () and $loginForm->isValid ( $_POST )) {
				
				$authService = 'DbTable';
				switch (strtolower ( $authService )) {
					case 'dbtable' :
						$db = $this->_getParam ( 'db' );
						$authAdapter = new Zend_Auth_Adapter_DbTable ( $db, 'auth_user', 'user_id', 'sec_passwd' );
						
						$authAdapter->setIdentity ( $loginForm->getValue ( 'username' ) );
						$authAdapter->setCredential ( $loginForm->getValue ( 'password' ) );
						break;
					case 'ldap' :
					/*TODO Implement LDAP auth*/
					break;
					default :
						throw new Zend_Exception ( 'Unknown authentication service -> ' . $authService, Zend_Log::ALERT );
						break;
				}
				
				$result = Zend_Auth::getInstance ()->authenticate ( $authAdapter );
				//$this->_helper->logger->debug ( $result );
				switch ($result->getCode ()) {
					case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND :
					case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID :
						break;
					
					case Zend_Auth_Result::SUCCESS :
						//$this->_helper->FlashMessenger ( $result->getMessages() );
						//$result->getMessages();
						Zend_Session::regenerateId ();
						
						preg_match ( '/[^.]+\.[^.]+$/', $_SERVER ['SERVER_NAME'], $domain );
						setcookie ( self::AUTH_SID, Zend_Session::getId (), time () + 1200, self::AUTH_PATH, ".$domain[0]" );
						$this->_helper->redirector ( 'index', 'index' );
						return;
						break;
					
					default :
						/** do stuff for other failure **/
						break;
				}
			}
			$this->view->form = $loginForm;
		}
	}
	/*
	public function accessAction() {
		$this->_helper->viewRenderer->setNoRender ();
		$this->_helper->layout ()->disableLayout ();
		
	
	}*/
	
	public function logoutAction() {
		if (isset ( $_COOKIE [self::AUTH_SID] )) {
			preg_match ( '/[^.]+\.[^.]+$/', $_SERVER ['SERVER_NAME'], $domain );
			setcookie ( self::AUTH_SID, '', time () - 360000, self::AUTH_PATH, ".$domain[0]" );
		}
		Zend_Auth::getInstance ()->clearIdentity ();
		Zend_Session::destroy ();
	}
	
	public function checkAction() {
		$this->_helper->viewRenderer->setNoRender ();
		$this->_helper->layout ()->disableLayout ();
		
		$authData = Zend_Auth::getInstance ()->getStorage ()->read ();
		$moduleName = null;
		if (isset ( $_COOKIE ['moduleName'] )) {
			$moduleName = $_COOKIE ['moduleName'];
			if (! array_key_exists ( $moduleName, $authData ['moduleRole'] )) {
				throw new Zend_Exception ( 'Invalid module "' . $moduleName . '"', Zend_Log::ERR );
			}
		} else {
			$this->getResponse ()->setHttpResponseCode ( 400 );
			throw new Zend_Exception ( 'Unauthorized attempt from ' . $_SERVER ['REMOTE_ADDR'], Zend_Log::ALERT );
		}
		
		$remoteAcl ['identity'] = $authData ['identity'];
		$remoteAcl ['roles'] = $authData ['moduleRole'] [$moduleName];
		
		$this->_helper->json ( $remoteAcl );
	}

}