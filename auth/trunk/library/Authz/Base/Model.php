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
class Authz_Base_Model extends Zend_Db_Table {
	/**
	 * If TRUE then only logger will log messages.
	 * @var boolean
	 */
	public static $debug;
	
	/**
	 * Default logger for Models.
	 * @var object
	 */
	protected $logger;
    
	
	/**
	 * Initlize settings usually required by models.
	 */

	public static function getLogger() {
		if (Zend_Registry::isRegistered ( 'logger' ) and (self::$debug === false)) {
			$logger = Zend_Registry::get ( 'logger' );
			return $logger;
		} else
			return false;
	}
    
}

?>