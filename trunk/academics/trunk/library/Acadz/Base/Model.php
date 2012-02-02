<?php
/**
 * BaseModel Class
 *
 * @category   Aceis
 * @package    Base
 * @subpackage BaseModel
 * @copyright  Copyright (c) 2009-2010 Ambala College of Engineering and Applied Research
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    0.1
 * @link       http://support.acecollege.com/projectlib/base/basecontroller
 * @since      0.1
 * @author     Avtar <avtar1986@gmail.com>
 * @author	   Hemant <hemantsan@live.com>
 */
/*
 * Base Class of all Models
 */
class Acadz_Base_Model
{
    /**
     * If TRUE then only logger will log messages.
     * @var boolean
     */
    public static $debug;
    /**
     * Default logger for Models.
     * @var Acad_Controller_Helper_Logger
     */
    protected $logger;
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
    
    
	/**
     * Constructor
     * 
     * @param  array|null $options 
     * @return void
     */
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
        self::_setTest_type_id('ASNMT');
    }
    
    
    /**
     * Overloading: allow property access
     * 
     * @param  string $name 
     * @param  mixed $value 
     * @return void
     */
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Zend_Exception('Invalid property specified');
        }
        $this->$method($value);
    }

    /**
     * Overloading: allow property access
     * 
     * @param  string $name 
     * @return mixed
     */
    public function __get($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
             throw new Zend_Exception('Invalid property specified');
        }
        return $this->$method();
    }
    
    /**
     * Set object state
     * 
     * @param  array $options
     */
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
      
}
?>