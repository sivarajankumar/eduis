<?php
/**
 * Logger helper class
 * 
 * @author 
 * @version
 *
 */
class Acad_Controller_Helper_Logger extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * Logger instance
     *
     * @var Zend_Log
     */
    private $logger;
    /**
     * Constructor: initialize plugin loader with logger instance 
     * depending on if configuration allows it
     * @return void
     */
    public function __construct ()
    {
        if (Zend_Registry::isRegistered('logger')) {
            $this->logger = Zend_Registry::get('logger');
        } else {
            throw new Exception("Logger is not in the Registry.");
        }
    }
    function direct ($message, $msgType = Zend_Log::DEBUG)
    {
        if ($this->logger)
            $this->logger->log($message, $msgType);
    }
    function __call ($name, $arguments)
    {
        if ($this->logger) {
            try {
                $this->logger->$name($arguments[0]);
            } catch (Zend_Exception $e) {
                self::direct($e->getMessage());
            }
        }
    }
}
