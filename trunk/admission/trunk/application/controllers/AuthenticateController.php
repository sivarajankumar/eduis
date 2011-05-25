<?php
/**
 * @category   EduIS
 * @package    Academic
 * @subpackage Authenticate
 * @since	   0.1
 */
class AuthenticateController extends Zend_Controller_Action
{
    const AUTH_PATH = '/authenticate';
    const AUTH_SID = 'ACESID';
    public function indexAction ()
    {
        if (isset($_COOKIE[self::AUTH_SID])) { //Check if user already logged in from AUTH_SERVER.
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $serverUrl = 'http://' . AUTH_SERVER . self::AUTH_PATH . '/check';
            $client = new Zend_Http_Client($serverUrl, array('timeout' => 30));
            $moduleName = $this->getRequest()->getModuleName();
            $client->setCookie('PHPSESSID', $_COOKIE[self::AUTH_SID]);
            //$client->setCookie('moduleName', $moduleName);
            $response = $client->request();
            if ($response->isError()) {
                $remoteErr = 'REMOTE ERROR: (' . $response->getStatus() . ') ' .
                 $response->getBody();
                throw new Zend_Exception($remoteErr, Zend_Log::ERR);
            } else {
                $jsonContent = $response->getBody();
                $userInfo = Zend_Json_Decoder::decode($jsonContent);
                if (! count($userInfo)) {
                    throw new Zend_Exception('No privileges found.', 
                    Zend_Log::ERR);
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
        } else { //Else It must be a new user.
            $loginForm = new Admsn_Form_Auth_Login($_POST);
            $this->getRequest()->getParam('roll_no');
            $this->getRequest()->getParam('application_basis');
            $authAdapter = null;
            if ($this->getRequest()->isPost() and $loginForm->isValid($_POST)) {
                $authService = 'DbTable';
                switch (strtolower($authService)) {
                    case 'dbtable':
                        $db = $this->_getParam('db');
                        $authAdapter = new Admsnz_Resource_Acl_Guest();
                        $authAdapter->setIdentity($loginForm->getValue('username'));
                        break;
                    case 'ldap' :
					/*TODO Implement LDAP auth */
					break;
                    default:
                        throw new Zend_Exception(
                        'Unknown authentication service -> ' . $authService, 
                        Zend_Log::ALERT);
                }
                $result = Zend_Auth::getInstance()->authenticate($authAdapter);
                //$this->_helper->logger->debug ( $result );
                Zend_Session::regenerateId();
                $this->_helper->redirector('index', 'index');
            }
            $this->view->form = $loginForm;
        }
    }
    public function logoutAction ()
    {
        $serverUrl = 'http://' . AUTH_SERVER . self::AUTH_PATH . '/logout';
        $client = new Zend_Http_Client($serverUrl, array('timeout' => 30));
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
        if (isset($_COOKIE[self::AUTH_SID])) {
            preg_match('/[^.]+\.[^.]+$/', $_SERVER['SERVER_NAME'], $domain);
            setcookie(self::AUTH_SID, '', time() - 360000, self::AUTH_PATH, 
            ".$domain[0]");
        }
        Zend_Auth::getInstance()->clearIdentity();
        Zend_Session::destroy();
    }
}