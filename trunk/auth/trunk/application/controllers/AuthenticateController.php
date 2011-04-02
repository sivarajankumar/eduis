<?php
class AuthenticateController extends Zend_Controller_Action {
	const AUTH_PATH = '/authenticate';
	const AUTH_SID = 'ACESID';
	
	public function indexAction() {
		//$this->_helper->layout ()->disableLayout ();
		$authData = Zend_Auth::getInstance ()->getStorage ()->read ();
		if (is_array($authData) and $authData['identity'] != 'anon' and $authData) {
		    //do nothing...
		    //$this->_helper->redirector ( 'index', 'index' );
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
					/*TODO Implement LDAP auth */
					break;
					default :
						throw new Zend_Exception ( 'Unknown authentication service -> ' . $authService, Zend_Log::ALERT );
				}
				
				$result = Zend_Auth::getInstance ()->authenticate ( $authAdapter );
				//$this->_helper->logger->debug ( $result );
				switch ($result->getCode ()) {
					case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND :
					case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID :
						break;
					
					case Zend_Auth_Result::SUCCESS :
						Zend_Session::regenerateId ();
						
						preg_match ( '/[^.]+\.[^.]+$/', $_SERVER ['SERVER_NAME'], $domain );
						setcookie ( self::AUTH_SID, Zend_Session::getId (), time () + 1200, self::AUTH_PATH, ".$domain[0]", null, true  );
						$last = time();
						setcookie ( 'last', $last,  null,  null, ".$domain[0]", null, true );
						$lastLogin = new Zend_Session_Namespace('last');
						$lastLogin->lastLogin = $last;
						$lastLogin->setExpirationHops(1,null,1);
						$this->_helper->redirector ( 'index', 'index' );
						return;
					
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
		Zend_Auth::getInstance ()->clearIdentity ();
	    preg_match ( '/[^.]+\.[^.]+$/', $_SERVER ['SERVER_NAME'], $domain );
		if (isset ( $_COOKIE [self::AUTH_SID] )) {
			setcookie ( self::AUTH_SID, false, 315554400, self::AUTH_PATH, ".$domain[0]", null, true  );
		}
	    if (isset ( $_COOKIE ['last'] )) {
			setcookie ( 'last', false, time()-36000, null, ".$domain[0]");
		}
		
		if (isset ( $_COOKIE ['identity'] )) {
			setcookie ( 'identity', false, time()-36000, null, ".$domain[0]");
		}
		Zend_Session::destroy ();
	}
	
	/**
	 * 
	 * Check the user authentication.
	 * @throws Zend_Exception
	 */
	public function checkAction() {
		$this->_helper->viewRenderer->setNoRender ();
		$this->_helper->layout ()->disableLayout ();
		
		$authData = Zend_Auth::getInstance ()->getStorage ()->read ();
						
		/*
		 * * The below code was meant to enhance security check.
		 * @TODO Security Check
		 * 
		 * $moduleName = 'academic';
		if (isset ( $_COOKIE ['moduleName'] )) {
			$moduleName = $_COOKIE ['moduleName'];
			if (! array_key_exists ( $moduleName, $authData ['moduleRole'] )) {
				throw new Zend_Exception ( 'Invalid module "' . $moduleName . '"', Zend_Log::ERR );
			}
		} else {
			$this->getResponse ()->setHttpResponseCode ( 400 );
			throw new Zend_Exception ( 'Unauthorized attempt from ' . $_SERVER ['REMOTE_ADDR'], Zend_Log::ALERT );
		}
		
		if (isset($authData ['moduleWise'] [$moduleName])) {
		    $remoteAcl ['roles'] = array_merge($remoteAcl['roles'], $authData ['moduleWise'][$moduleName]);
		}*/
		unset($authData ['acl']);
		//$this->_helper->logger($authData);
		$this->_helper->json ( $authData );
	}

}