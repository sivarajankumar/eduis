<?php
/**
 * Application bootstrap
 * 
 * @package Tnp
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAppConfig ()
    {
        // Define path to CDN server.
        defined('CDN_SERVER') ||
         define('CDN_SERVER', 'site.cdn.aceambala.com');
        // Define path to CDN server.
        defined('AUTH_SERVER') ||
         define('AUTH_SERVER', 'auth.aceambala.com');
        // Define path to Core server.
        defined('CORE_SERVER') ||
         define('CORE_SERVER', 'core.aceambala.com');
        // Define path to Academics server.
        defined('ACADEMIC_SERVER') ||
         define('ACADEMIC_SERVER', 'academic.aceambala.com');
        // Define path to Library server.
        defined('LIBRARY_SERVER') ||
         define('LIBRARY_SERVER', 'library.aceambala.com');
        // Define path to Academics server.
        defined('ACCOUNT_SERVER') ||
         define('ACCOUNT_SERVER', 'account.aceambala.com');
        defined('DATA_EXCEL') ||
         define('DATA_EXCEL', $this->getOption('data_excel'));
    }
    protected function _initViewBase ()
    {
        $this->bootstrap('View');
        /* @var $view Zend_View_Abstract */
        $view = $this->getResource('View');
        $view->addHelperPath('ZendX/JQuery/View/Helper/', 
        'ZendX_JQuery_View_Helper');
        //Set default document type.
        $view->doctype('XHTML1_STRICT');
        // Set the initial title and separator:
        $view->headTitle('Tnp')->setSeparator(' :: ');
    }
    protected function _initCache ()
    {
        $cacheManager = $this->bootstrapCacheManager()->getResource(
        'cachemanager');
        Zend_Registry::set("cacheManager", $cacheManager);
    }
    protected function _initLogger ()
    {
        $logger = $this->bootstrapLog()->getResource('Log');
        /*if (! $this->hasPluginResource ( 'Log' )) {
			return false;
		}*/
        switch (strtolower(APPLICATION_ENV)) {
            case 'production':
                $writer = new Zend_Log_Writer_Firebug();
                $filter = new Zend_Log_Filter_Priority(Zend_Log::NOTICE, '>=');
                $writer->addFilter($filter);
                // Uncomment and alter following line if you want to get more then message.
                //$writer->setPriorityStyle(Zend_Log::WARN, 'TRACE');
                $logger->addWriter($writer);
                break;
            case 'staging':
                //Not considered yet.
                break;
            case 'testing':
                //Not considered yet.
                break;
            case 'development':
                $writer = new Zend_Log_Writer_Firebug();
                $filter = new Zend_Log_Filter_Priority(2, '>=');
                $writer->addFilter($filter);
                $writer->setPriorityStyle(Zend_Log::WARN, 'TRACE');
                $logger->addWriter($writer);
                break;
            default:
                throw new Zend_Exception(
                'Unknown <b>Application Environment</b> to create log writer in bootstrap.', 
                Zend_Log::WARN);
        }
        // Now set logger globally in application.
        Zend_Registry::set("logger", $logger);
    }
    protected function _initDbProfiler ()
    {
        switch (strtolower(APPLICATION_ENV)) {
            case 'production':
                //Not considered yet.
                break;
            case 'staging':
                //Not considered yet.
                break;
            case 'testing':
                //Not considered yet.
                break;
            case 'development':
                $profiler = new Zend_Db_Profiler_Firebug(
                'DB Queries : ' . ucfirst(strtolower(APPLICATION_ENV)));
                $profiler->setEnabled(true);
                $db = $this->bootstrapDb()->getResource('db');
                $db->setProfiler($profiler);
                break;
            default:
                throw new Zend_Exception(
                'Unknown <b>Application Environment</b> to create db profiler in bootstrap.', 
                Zend_Log::WARN);
        }
    }
}

