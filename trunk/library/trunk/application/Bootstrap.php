<?php

/**
 * Application bootstrap
 * 
 * @package Library
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	
	protected function _initViewBase() {
		$this->bootstrap ( 'View' );
		$view = $this->getResource ( 'View' );
		$view->addHelperPath ( 'ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper' );
		//Set default document type.
		$view->doctype ( 'XHTML1_STRICT' );
		
		// Set the initial title and separator:
		$view->headTitle ( 'Library' )->setSeparator ( ' :: ' );
	
	}
	protected function _initCache() {
		$cache = $this->bootstrapCacheManager ()->getResource ( 'cachemanager' );
		Zend_Registry::set ( "cacheManager", $cache );
	}
	protected function _initLogger() {
		$logger = $this->bootstrapLog ()->getResource ( 'Log' );
		/*if (! $this->hasPluginResource ( 'Log' )) {
			return false;
		}*/
		
		switch (APPLICATION_ENV) {
			case 'production' :
				$writer = new Zend_Log_Writer_Firebug ();
				$filter = new Zend_Log_Filter_Priority ( 5, '>=' );
				$writer->addFilter ( $filter );
				// Uncomment and alter following line if you want to get more then message.
				//$writer->setPriorityStyle(Zend_Log::WARN, 'TRACE');
				$logger->addWriter ( $writer );
				break;
			
			case 'staging' :
				//Not considered yet.
				break;
			
			case 'testing' :
				//Not considered yet.
				break;
			
			case 'development' :
				$writer = new Zend_Log_Writer_Firebug ();
				$filter = new Zend_Log_Filter_Priority ( 2, '>=' );
				$writer->addFilter ( $filter );
				// Uncomment and alter following line if you want to get more then message.
				//$writer->setPriorityStyle(Zend_Log::WARN, 'TRACE');
				$logger->addWriter ( $writer );
				break;
			
			default :
				throw new Zend_Exception ( 'Unknown <b>Application Environment</b> to create log writer in bootstrap.', Zend_Log::WARN );
		
		}
		
		// Now set logger globally in application.
		Zend_Registry::set ( "logger", $logger );
	
	}
	
	protected function _initDbProfiler() {
		switch (APPLICATION_ENV) {
			case 'production' :
				//Not considered yet.
				break;
			
			case 'staging' :
				//Not considered yet.
				break;
			
			case 'testing' :
				//Not considered yet.
				break;
			
			case 'development' :
				$profiler = new Zend_Db_Profiler_Firebug ( 'All DB Queries' );
				$profiler->setEnabled ( true );
				$db = $this->bootstrapDb ()->getResource ( 'db' );
				$db->setProfiler ( $profiler );
				break;
			default :
				throw new Zend_Exception ( 'Unknown <b>Application Environment</b> to create db profiler in bootstrap.', Zend_Log::WARN );
		
		}
	}
}
