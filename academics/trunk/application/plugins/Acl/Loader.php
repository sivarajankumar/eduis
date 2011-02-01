<?php
/**
 * @category   Auth
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
class Acad_Plugin_Acl_Loader extends Zend_Controller_Plugin_Abstract
{
    const GUEST = 'guest';
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
        $auth = Zend_Auth::getInstance();
        if (! Zend_Session::isDestroyed()) {
            if (! $auth->hasIdentity()) {
                $guestAdapter = new Libz_Resource_Acl_Guest();
                $auth->authenticate($guestAdapter);
            }
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
     * initUserAcl() - Bind user specific ACL with user session.
     *
     * @return Zend_Acl
     */
    protected function initUserAcl () {
        $authContent = Zend_Auth::getInstance()->getStorage()->read();
        if (! is_array($authContent)) {
            Zend_Registry::get('logger')->debug('Fresh visitor');
            $remoteAcl = new Zend_Session_Namespace('remoteAcl');
            if (! isset($remoteAcl->userInfo)) {
                $remoteAcl->redirectedFrom = $this->getRequest()->getParams();
                $this->getResponse()->setRedirect('authenticate', 303);
                return;
            } else {
                Zend_Registry::get('logger')->debug(
                'User has logged in auth module');
            }
            $cache = self::getCache();
            $commonAcl = $cache->load('commonAcl');
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
    public function check () {
        $request = $this->_request;
        $authContent = Zend_Auth::getInstance()->getStorage()->read();
        
        //Zend_Registry::get('logger')->debug($authContent);
        if ($_COOKIE['last'] == $authContent['last']) {
            if (isset($authContent['acl'])) {
                $userAcl = $authContent['acl'];
                if ($userAcl instanceof Zend_Acl) {
                    $reqResource = strtolower(
                    $request->getModuleName() . '_' . $request->getControllerName() .
                     '_' . $request->getActionName());
                    try {
                        if ($userAcl->has($reqResource)) {
                            if ($userAcl->isAllowed($authContent['identity'], 
                            $reqResource)) {
                                return true;
                            } else {
                                throw new Zend_Exception(
                                'ACL denied "' .
                                 str_ireplace('_', '/', $reqResource) . '" to ' .
                                 $authContent['identity']. ' at '.$_SERVER['REMOTE_ADDR'], Zend_Log::ERR);
                            }
                        } else {
                            throw new Zend_Exception(
                            'RESOURCE "' . str_ireplace('_', '/', $reqResource) .
                             '" is not found in ACL', Zend_Log::WARN);
                        }
                    } catch (Zend_Exception $e) {
                        $error = new stdClass();
                        $error->request = $this->_request;
                        $error->exception = $e;
                        $this->_request->setParam('aclError', $error);
                        $request->setControllerName('error');
                        $request->setActionName('noaccess');
                    }
                }
            } else {
                throw new Zend_Exception('User Acl not found.', Zend_Log::ERR);
            }
        } else {
            Zend_Auth::getInstance()->clearIdentity();
            Zend_Session::regenerateId();
            $remoteAcl = new Zend_Session_Namespace('remoteAcl');
            $remoteAcl->redirectedFrom = $this->getRequest()->getParams();
            $this->getResponse()->setRedirect('authenticate', 303);
        }
        
    }
}