<?php
/**
 * BaseController Class
 *
 * @category   Aceis
 * @package    Base
 * @subpackage BaseController
 * @copyright  Copyright (c) 2009-2010 Ambala College of Engineering and Applied Research
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    0.1
 * @link       http://support.acecollege.com/projectlib/base/basecontroller
 * @since      0.1
 * @author     Avtar <avtar1986@gmail.com>
 * @author	   Hemant <hemantsan@live.com>
 */
/*
 * Base Class of all Controllers
 */
class Admsnz_Base_BaseController extends Zend_Controller_Action
{
    protected static $debug;
    public function init ()
    {
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
    }
    /**
     * 
     * Get logger of application
     * @return Zend_Log
     */
    public static function getLogger ()
    {
        if (Zend_Registry::isRegistered('logger')) {
            $logger = Zend_Registry::get('logger');
            return $logger;
        } else {
            return false;
        }
    }
    /**
     * 
     * Get default cache for application
     * @param string $cacheName
     * @return Zend_Cache_Frontend_File
     */
    public static function getCache ($cacheName = 'database')
    {
        /**
         * 
         * Enter description here ...
         * @var Zend_Cache_Manager
         */
        $cacheManager = Zend_Registry::get('cacheManager');
        return $cacheManager->getCache($cacheName);
    }
}