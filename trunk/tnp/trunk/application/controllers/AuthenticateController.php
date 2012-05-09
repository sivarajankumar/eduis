<?php
/**
 * @category   EduIS
 * @package    Library
 * @subpackage Authenticate
 * @since	   0.1
 */
class AuthenticateController extends Zend_Controller_Action {

    const AUTH_PATH = '/authenticate';
    const AUTH_SID = 'ACESID';

    public function indexAction () {
        $auth = Zend_Auth::getInstance();
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $remoteAcl = new Zend_Session_Namespace('remoteAcl');
        $userInfo = array();
            if (isset($_COOKIE[self::AUTH_SID])) {
                $client = new Zend_Http_Client(
                'http://' . AUTH_SERVER . self::AUTH_PATH . '/check', 
                array('timeout' => 30));
                
                $client->setCookie('PHPSESSID', $_COOKIE[self::AUTH_SID]);
                //$client->setCookie('moduleName', $moduleName);
                $response = $client->request();
                if ($response->isError()) {
                    $remoteErr = 'ERROR from '.AUTH_SERVER.' : (' . $response->getStatus() . ') ' .
                     $response->getMessage().', i.e. '.$response->getHeader('Message');
                    throw new Zend_Exception($remoteErr, Zend_Log::ERR);
                } else {
                    $jsonContent = $response->getBody();
                    $userInfo = Zend_Json_Decoder::decode($jsonContent);
                    if (! count($userInfo)) {
                        throw new Zend_Exception(
                        'No privileges found.', Zend_Log::ERR);
                    }
                    $remoteAcl->userInfo = $userInfo;
          
                }
            } else {
                    $guestAdapter = new Tnpz_Resource_Acl_Guest();
                    $auth->authenticate($guestAdapter);
					$userInfo['identity'] = $guestAdapter::GUEST_ID;
					$userInfo['roles'][] = 'guest';
					$remoteAcl->userInfo = $userInfo;
                    $this->_helper->logger('No remote cookie found. So, identifying as"'
                                            .$guestAdapter::GUEST_ID.
                    						'" with guest privilege.');
            }
    
            if (isset($remoteAcl->redirectedFrom)) {
                $rdirctdFrom = $remoteAcl->redirectedFrom;
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

    public function logoutAction () {
        $this->_helper->layout()->disableLayout();
        $serverUrl = 'http://' . AUTH_SERVER . self::AUTH_PATH . '/logout';
        $client = new Zend_Http_Client($serverUrl, array('timeout' => 30));
        try {
            if (isset($_COOKIE[self::AUTH_SID])) {
                $moduleName = $this->getRequest()->getModuleName();
                $client->setCookie('PHPSESSID', $_COOKIE[self::AUTH_SID]);
                $client->setCookie('moduleName', $moduleName);
                $response = $client->request();
                if ($response->isError()) {
                    $remoteErr = $remoteErr = 'REMOTE ERROR: (' . $response->getStatus() . ') ' .
                 $response->getMessage().', i.e. '.$response->getHeader('Message');
                    throw new Zend_Exception($remoteErr, Zend_Log::ERR);
                }
            } else {
                $this->_helper->logger('No remote cookie found. So, not requesting AUTH_SERVER to logout.');
            }
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
        }
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
}