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
        $authData = Zend_Auth::getInstance()->getStorage()->read();
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        //!isset($authData ['identity']) and $authData ['identity'] != 'anon' 
        if (false) {
            $this->_helper->redirector('index', 'index');
        } else {
            
        
            $client = new Zend_Http_Client(
            'http://' . AUTH_SERVER . self::AUTH_PATH . '/check', 
            array('timeout' => 30));
            if (isset($_COOKIE[self::AUTH_SID])) {
                $moduleName = $this->getRequest()->getModuleName();
                $client->setCookie('PHPSESSID', $_COOKIE[self::AUTH_SID]);
                //$client->setCookie('moduleName', $moduleName);
                $response = $client->request();
                if ($response->isError()) {
                    $remoteErr = 'REMOTE ERROR: (' . $response->getStatus() .
                     ') ' . $response->getBody();
                    throw new Zend_Exception($remoteErr, Zend_Log::ERR);
                } else {
                    $jsonContent = $response->getBody();
                    $userInfo = Zend_Json_Decoder::decode($jsonContent);
                    if (! count($userInfo)) {
                        throw new Zend_Exception(
                        'No privileges found.', Zend_Log::ERR);
                    }
                    $remoteAcl = new Zend_Session_Namespace('remoteAcl');
                    $remoteAcl->userInfo = $userInfo;
          
                    if (isset($remoteAcl->redirectedFrom)) {
                        $rdirctdFrom = $remoteAcl->redirectedFrom;
                        $module = $moduleName == $rdirctdFrom['module'] ? '' : $rdirctdFrom['module'] .
                         '/';
                        $controller = $rdirctdFrom['controller'] == 'index' ? '' : $rdirctdFrom['controller'];
                        $action = $rdirctdFrom['action'] == 'index' ? '' : '/' .
                         $rdirctdFrom['action'];
                        $url = '/' . $module . $controller . $action;
                        $this->getResponse()->setRedirect($url);
                    } else {
                        $this->getResponse()->setRedirect('/');
                    }
                }
            } else {
                echo 'You need to login first.';
                /*
					$userInfo['identity'] = 'anon';
					$userInfo['roles'][] = 'guest';
						$remoteAcl->userInfo = $userInfo;
						if (isset ( $_SERVER ['HTTP_REFERER'] )) {
							$this->getResponse ()->setRedirect ( $_SERVER ['HTTP_REFERER'] );
						} else {
							$this->getResponse ()->setRedirect ( '/' );
						}
						//*/
            } 
        } 
    }

    public function logoutAction () {
        $serverUrl = 'http://' . AUTH_SERVER . self::AUTH_PATH . '/logout';
        $client = new Zend_Http_Client($serverUrl, array('timeout' => 30));
        try {
            if (isset($_COOKIE[self::AUTH_SID])) {
                $moduleName = $this->getRequest()->getModuleName();
                $client->setCookie('PHPSESSID', $_COOKIE[self::AUTH_SID]);
                $client->setCookie('moduleName', $moduleName);
                $response = $client->request();
                if ($response->isError()) {
                    $remoteErr = $response->getStatus() . ' : ' .
                     $response->getMessage() . '<br/>' . $response->getBody();
                    throw new Zend_Exception($remoteErr, Zend_Log::ERR);
                }
            } else {
                $this->_helper->logger('No remote cookie found');
            }
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
        }
        if (isset($_COOKIE[self::AUTH_SID])) {
            preg_match('/[^.]+\.[^.]+$/', $_SERVER['SERVER_NAME'], $domain);
            setcookie(self::AUTH_SID, '', time() - 360000, self::AUTH_PATH, 
            ".$domain[0]");
        }
        Zend_Auth::getInstance()->clearIdentity();
        Zend_Session::destroy();
    }
}