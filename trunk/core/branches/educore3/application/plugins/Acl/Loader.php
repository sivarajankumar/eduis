<?php
/**
 * @category   Core
 * @package    Plugin_Acl
 * @subpackage Loader
 * @copyright  Copyright (c) 2009-2010 HeAvi
 */
/**
 * Check the access privilage of user.
 * 
 * It by default assumes a user as guest (if not logged in). It stores all roles and resources
 * in application cache. Creates a new user-specific role with parent roles from main-ACL and 
 * stores the new ACL in user\'s session storage along with identity.
 * 
 * Finally, it pick user ACL from user\'s session and check access rights. If allowed, it return
 * otherwise redirects to ErrorController -> noaccessAction with exceptions.
 */
class Core_Plugin_Acl_Loader extends Zend_Controller_Plugin_Abstract
{

    const GUEST = 'guest';
    const AUTH_URL = '/authenticate';
    /**
     * preDispatch() - Check the access privilage of user.
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return boolean 
     * @throws Zend_Exception on access denied.
     */
    public function preDispatch (Zend_Controller_Request_Abstract $request) {
        $actionName = strtolower($request->getActionName());
        $controllerName = strtolower($request->getControllerName());
        if (substr($actionName, 0, 4) == 'fill' or
         substr($actionName, 0, 3) == 'get' or
         'authenticate' == strtolower($controllerName)or
         'error' == strtolower($controllerName)) {
            return;
        }
        if (! Zend_Session::isDestroyed()) {
            self::initUserAcl();
            self::check();
        } else {
            throw new Zend_Exception('Session is destroyed.', Zend_Log::WARN);
        }
    }

    /**
     * getCache() - Fetch cache from registry.
     *
     * @param  string $cacheName
     * @return Zend_Cache
     */
    public static function getCache ($cacheName = 'database') {
        return Zend_Registry::get('cacheManager')->getCache($cacheName);
    }

    /**
     * getDb() - Fetch cache from registry.
     *
     * @return Zend_Db_Adapter_Pdo_Mysql
     */
    public static function getDb () {
        return Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource(
        'db');
    }

    /**
     * getLogger() - Fetch logger from registry.
     *
     * @return Zend_Log
     */
    public static function getLogger () {
        return Zend_Registry::get('logger');
    }
    /**
     * initUserAcl() - Bind user specific ACL with user session.
     *
     * @return Zend_Acl
     */
    protected function initUserAcl () {
        $authContent = Zend_Auth::getInstance()->getStorage()->read();
        if (! is_array($authContent)) {
            self::getLogger()->debug('Fresh visitor');
            $remoteAcl = new Zend_Session_Namespace('remoteAcl');
            if (! isset($remoteAcl->userInfo)) {
                $remoteAcl->redirectedFrom = array_intersect_key($this->getRequest()->getParams(),
                                                        $this->getRequest()->getUserParams());
                                                        
                 $remoteAcl->redirectedParams = array_diff_key($this->getRequest()->getParams(),
                                                        $this->getRequest()->getUserParams());
                self::getLogger()->debug('Redirecting to "'.self::AUTH_URL.'", redirecting from');
                self::getLogger()->debug($remoteAcl->redirectedFrom);
                $this->getResponse()->setRedirect(self::AUTH_URL, 303);
                return;
            } else {
                Zend_Registry::get('logger')->debug(
                'User has logged in auth module');
            }
            $commonAcl = self::getCache()->load('commonAcl');
            if ($commonAcl === false) {
                $commonAcl = self::initAcl();
            } else {
                Zend_Registry::get('logger')->debug('Common ACL from Cache.');
            }
            $acl = $commonAcl['acl'];
            $userInfo = $remoteAcl->userInfo;
            $userRoles = array_intersect($userInfo['roles'], $commonAcl['dbRoles']);
            Zend_Registry::get('logger')->debug('Module Roles of '.$userInfo['identity']);
            Zend_Registry::get('logger')->debug($userRoles);
            $acl->addRole($userInfo['identity'], $userRoles);
            $userInfo['acl'] = $acl;
            Zend_Auth::getInstance()->getStorage()->write($userInfo);
            Zend_Registry::get('logger')->debug(
            $userInfo['identity'].' specific ACL saved in session.');
        }
    }

    /**
     * initAcl() - Initialize common ACL and save to cache.
     *
     * @return Zend_Acl
     */
    protected static function initAcl () {
        $cache = self::getCache();
        $db = self::getDb();
        $selectRes = new Zend_Db_Select($db);
        $roleResources = $selectRes->from('mod_role_resource')
            ->query(Zend_Db::FETCH_GROUP)
            ->fetchAll();
        //Zend_Registry::get ( 'logger' )->notice ( 'Role and Resources:' );
        //Zend_Registry::get ( 'logger' )->debug ( $roleResources );
        $acl = new Zend_Acl();
        $dbRoles = array(self::GUEST);
        $acl->addRole(self::GUEST);
        foreach ($roleResources as $roleKey => $resources) {
            $role = strtolower($roleKey);
            if (! (self::GUEST === $role)) {
                if (! $acl->hasRole($role)) {
                    $acl->addRole($role, self::GUEST);
                    $dbRoles[] = $role;
                } else {
                    Zend_Registry::get('logger')->debug(
                    'Duplicate role : "' . $role . '"');
                }
            }
            foreach ($resources as $key => $resource) {
                $res = strtolower(
                $resource['module_id'] . '_' . $resource['controller_id'] . '_' .
                 $resource['action_id']);
                if (! $acl->has($res)) {
                    $acl->addResource($res);
                }
                $acl->allow($role, $res);
            }
        }
        $commonAcl = array('acl'=>$acl, 'dbRoles' => $dbRoles);
        $cache->save($commonAcl, 'commonAcl');
        Zend_Registry::get('logger')->debug('Common ACL cached.');
        
        return $commonAcl;
    }

    /*
	 * getUserRoles() - Fetch User roles from database.
	 *
	 * @param string $user_id
	 * @return array $userRole
	 */
    /*public static function getUserRoles($user_id) {
		$userRole = array ();
		if ($user_id == 'anon') {
			$userRole ['moduleWise'] = NULL;
		} else {
			$db = self::getDb ();
			$selectUserRoles = new Zend_Db_Select ( $db );
			$dbRoles = $selectUserRoles->from ( 'mod_role_resource', 'module_id' )->join ( 'user_role', '`user_role`.`role_id` = `role_resource`.`role_id`', 'role_id' )->where ( "user_id = ?", $user_id )->query ()->fetchAll ( Zend_Db::FETCH_GROUP );
			
			foreach ( $dbRoles as $module => $moduleWiseRoles ) {
				foreach ( $moduleWiseRoles as $roleKey => $role ) {
					if (isset ( $role ['role_id'] )) {
						$uRole = $role ['role_id'];
						$userRole ['moduleWise'] [$module] [] = $uRole;
						$userRole ['roles'] [] = $uRole;
					} else {
						throw new Zend_Exception ( 'Db column "role_id" is not set.', Zend_Log::DEBUG );
					}
				}
			}
		
		}
		
		$userRole ['roles'] [] = self::GUEST;
		return $userRole;
	}*/
    public function check ()
    {
        $request = $this->_request;
        $authContent = Zend_Auth::getInstance()->getStorage()->read();
    
        if (isset($_COOKIE['last'])) {
            if ($_COOKIE['last'] != $authContent['last']) {
                if ('production' == strtolower(APPLICATION_ENV)) {
                    Zend_Registry::get('logger')->notice(
                    'Its seems tht someone else has logged in. So updating auth info');
                }
                Zend_Auth::getInstance()->clearIdentity();
                Zend_Session::regenerateId();
                $remoteAcl = new Zend_Session_Namespace('remoteAcl');
                $remoteAcl->redirectedFrom = $this->getRequest()->getParams();
                $this->getResponse()->setRedirect(self::AUTH_URL, 303);
            }
        } else {
                if ('development' == strtolower(APPLICATION_ENV)) {
                    Zend_Registry::get('logger')->debug(
                    '$_COOKIE["Last"] is not set');
                }
        }
            if (isset($authContent['acl'])) {
                $userAcl = $authContent['acl'];
                if ($userAcl instanceof Zend_Acl) {
                    $reqResource = strtolower(
                    $request->getModuleName() . '_' .
                     $request->getControllerName() . '_' .
                     $request->getActionName());
                    if ($userAcl->has($reqResource)) {
                        if ($userAcl->isAllowed($authContent['identity'], 
                        $reqResource)) {
                            return true;
                        } else {
                            if ('development' != strtolower(APPLICATION_ENV)) {
                                throw new Exception(
                                'ACL denied "' .
                                 str_ireplace('_', '/', $reqResource) . '" to ' .
                                 $authContent['identity'] . ' at ' .
                                 $_SERVER['REMOTE_ADDR'], Zend_Log::ALERT);
                            }
                            Zend_Registry::get('logger')->notice(
                            'ACL ERROR: BLOCKED BY ACL. BUT FUNCTIONAL DUE TO DEVELOPMENT ENV.');
                        }
                    } else {
                        if ('development' != strtolower(APPLICATION_ENV)) {
                            throw new Exception(
                            'RESOURCE "' . str_ireplace('_', '/', $reqResource) .
                             '" is not found in ACL', Zend_Log::WARN);
                        }
                        Zend_Registry::get('logger')->notice(
                        'ACL ERROR: RESOURCE "' .
                         str_ireplace('_', '/', $reqResource) .
                         '" is not found in ACL');
                    }
                } else {
                    throw new Exception(
                    'Not a valid instance of ACL. var_export(userACL)=>' .
                     var_export($userAcl, true), Zend_Log::ERR);
                }
            } else {
                throw new Exception('User Acl not found.', Zend_Log::ERR);
            }
    }
}