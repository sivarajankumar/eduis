<?php
class AuthenticateController extends Zend_Controller_Action {
	const AUTH_PATH = '/authenticate';
	const AUTH_SID = 'ACESID';
	
	public function indexAction() {
		//$this->_helper->layout ()->disableLayout ();
        $auth = Zend_Auth::getInstance();
		$authContent = $auth->getStorage ()->read ();
		$authAcl = new Zend_Session_Namespace('authAcl');
		$guestID = Authz_Resource_Acl_Guest::GUEST_ID;
		if (is_array($authContent) and $authContent['identity'] != $guestID) {
			return;
		}
		$loginForm = new Auth_Form_Auth_Login ( $_POST );
		$authAdapter = null;
		
		if ($this->getRequest ()->isPost () and $loginForm->isValid ( $_POST )) {
			
			$authService = 'DbTable';
			switch (strtolower ( $authService )) {
				case 'dbtable' :
					$db = $this->_getParam ( 'db' );
					$authAdapter = new Zend_Auth_Adapter_DbTable ( $db, 'auth_user', 'login_id', 'sec_passwd' );
					
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
					setcookie ( 'last', $last,  null,  '/', ".$domain[0]", null, true );
					$lastLogin = new Zend_Session_Namespace('last');
					$lastLogin->lastLogin = $last;
					$lastLogin->setExpirationHops(1,null,1);
					
					$authAcl = new Zend_Session_Namespace('authAcl');
					$authAcl->authId = $loginForm->getValue ( 'username' );
					
					$this->_helper->redirector ( 'index', 'index' );
					return;
				
				default :
					/** do stuff for other failure **/
					break;
			}
		}
		$this->view->form = $loginForm;
	}
	public function welcomeguestAction() {
		$this->_helper->layout ()->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( );
        $auth = Zend_Auth::getInstance();
		$authContent = $auth->getStorage ()->read ();
		$authAcl = new Zend_Session_Namespace('authAcl');
		$guestAdapter = new Authz_Resource_Acl_Guest();
		$guestID = Authz_Resource_Acl_Guest::GUEST_ID;
		$authAcl->authId = $guestID;
        $auth->authenticate($guestAdapter);
        $this->_helper->logger('No remote cookie found. So, identifying as "anon" with guest privilege.');
            
        if (isset($authAcl->redirectedFrom)) {
			$rdirctdFrom = $authAcl->redirectedFrom;
			$moduleName = $this->getRequest()->getModuleName();
			$params= empty($rdirctdFrom->redirectedParams)?array():$rdirctdFrom->redirectedParams;
			                
			$this->_helper->redirector ( $rdirctdFrom['action'],
										$rdirctdFrom['controller'],
										$rdirctdFrom['module'],
										$params);
		} else {
			$this->getResponse()->setRedirect('/');
		}
	}
	public function logoutAction() {
		$this->_helper->layout ()->disableLayout ();
            preg_match('/[^.]+\.[^.]+$/', $_SERVER['SERVER_NAME'], $domain);
    	    if (isset ( $_COOKIE [self::AUTH_SID] )) {
                setcookie(self::AUTH_SID, '', time() - 360000, self::AUTH_PATH, ".$domain[0]");
    		}
    	    if (isset ( $_COOKIE ['last'] )) {
    			setcookie ( 'last', '', time() - 36000, '/', ".$domain[0]");
    		}
    		
    		if (isset ( $_COOKIE ['identity'] )) {
    			setcookie ( 'identity', '', time() - 36000,'/', ".$domain[0]");
    		}
        Zend_Auth::getInstance()->clearIdentity();
        Zend_Session::destroy();
        Zend_Session::regenerateId();
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

	public function registerAction()
	{
		$this->_helper->viewRenderer->setNoRender (false);
		$this->_helper->layout ()->enableLayout();
	}
	public function saveregistrationinfoAction()
	{
		
	}
}