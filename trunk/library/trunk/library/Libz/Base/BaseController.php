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
class Libz_Base_BaseController extends Zend_Controller_Action {
	
	/**
	 * Model of the controller
	 * @var Libz_Base_Model
	 */
	protected $model;
	
	/**
	 * Database Columns to be processed.
	 * @var array Array of database columns.
	 */
	protected $dbCols;
	
	/**
	 * Grid
	 * @var Lib_Controller_Helper_Grid
	 */
	protected $grid;
	
	protected static $debug;
	
	/**
	 * Set Model class for Controller
	 * 
	 * If TRUE then corrosponding model is saved to {@link $model} by {@link init()}
	 * @var boolean
	 */
	protected $_autoModel = FALSE;
	
	/**
	 * Fetches Columns from database.
	 * 
	 * If TRUE then database columns are saved to {@link $dbCols} by {@link init()}
	 * @var boolean
	 */
	protected $_autoDbCols = FALSE;
	
	/**
	 * Hide/Ignore database columns
	 * 
	 * Removes the columns which are not required while using $_autoDbCols
	 * But it should not have any primary key.
	 * (Do not hide a primary key in order to maintain consistency in output)
	 * 
	 * @var array
	 */
	protected $_hideDbCols = array ();
	
	/**
	 * Initlization of settings usually required by controllers.
	 */
	public function init() {
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		$this->_helper->layout ()->disableLayout ();
		
		/*
		 * To show debug messages.
		 */
		if ('development' == APPLICATION_ENV) {
			self::$debug = true;
		}
		
		/**
		 * Automatically creates model object
		 */
		if (TRUE == $this->_autoModel) {
			self::createModel ();
		}
		
		//Automatically Setup Database Columns
		if (TRUE == $this->_autoDbCols) {
			self::createDbCols ();
			/*
			if ($this->debug) {
				$this->_helper->logger->info ( 'Auto $dbCols' );
				$this->_helper->logger->debug ( $this->dbCols );
				$this->_helper->logger->info ( 'Auto $_hideDbCols' );
				$this->_helper->logger->debug ( $this->_hideDbCols );
			}*/
		
		}
	}
	protected function getModel($forceReCreate = FALSE) {
		if ((! isset ( $this->model )) || $forceReCreate) {
			$module = $this->getRequest ()->getModuleName ();
			$moduleName = null;
			$prefix = null;
			$defaultModule = $this->getFrontController ()->getDispatcher ()->getDefaultModule ();
			if (strtolower ( $defaultModule ) != strtolower ( $module )) {
				$moduleName = ucfirst ( $module ) . '_';
				$prefix = $moduleName;
			} else {
				$appNameSpace = $this->getInvokeArg ( 'bootstrap' )->getAppNamespace ();
				$prefix = ucfirst($appNameSpace) . '_';
			}
			
			$className = get_class ( $this );
			//output : Module_ClassnameController
			

			$class = substr ( $className, 0, strlen ( $className ) - 10 );
			//Module_Classname
			

			$class = substr ( $class, strlen ( $moduleName ) );
			//Classname
			

			$model = $prefix . 'Model_DbTable_' . $class;
			$this->model = new $model ();
		}
		return $this->model;
	}
	
	/**
	 * @deprecated getModel function sounds better then createModel
	 */
	protected function createModel($forceReCreate = FALSE) {
		return self::getModel($forceReCreate);
	}
	
	protected function createDbCols($forceReCreate = FALSE) {
		if (isset ( $this->model )) {
			if ((! isset ( $this->dbCols )) || $forceReCreate) {
				$this->dbCols = $this->model->info ( 'cols' );
				if (count ( $this->_hideDbCols )) {
					$this->dbCols = array_diff ( $this->dbCols, $this->_hideDbCols );
				}
				return $this->dbCols;
			}
		} else {
			self::createModel ();
			self::createDbCols ();
		}
	
	}
	
	/**
	 * Process and filter request data.
	 * 
	 * @param array Array of request data.
	 * @return array Array of processed request data.
	 */
	private function paramData($rdata) {
		$data = array ();
		foreach ( $this->dbCols as $key => $param ) {
			if (isset ( $rdata [$param] )) {
				$data [$param] = $rdata [$param];
			} else {
				$this->_helper->logger->debug ( "$param is not in request." );
			
		//$this->_helper->logger->alert ( 'Request Data :' );
			//$this->_helper->logger ( $rdata );
			//$this->_helper->logger->alert ( 'Processed data :' );
			//$this->_helper->logger ( $data );
			}
		}
		return $data;
	}
	
	/**
	 * Process rowId to use in where condition.
	 * @return string String with formatted where condition.
	 */
	private function whereData($id) {
		$where = array ();
		/**
		 * If multiple rows are selected then their primary keys are seprated by ','
		 * So here seprating primary keys 
		 */
		$primaryKeys = explode ( ',', $id );
		foreach ( $primaryKeys as $key => $tupleKey ) {
			/*
			 * If primary key is composite then cols are seprated by '__'
			 * So here seprating cols of a composite key
			 */
			$primaryKeys [$key] = explode ( '__', $tupleKey );
			
			//$pkey begin from location 1
			array_unshift ( $primaryKeys [$key], 'faaltoo' );
		}
		/*
		
			$this->_helper->logger ( 'Primary Keys of grid in whereData()' );
			$this->_helper->logger ( $primaryKeys );*/
		
		/*
		 * Create where condition
		 */
		$where = '';
		$pkey = $this->model->info ( 'primary' );
		
		/*
		
			$this->_helper->logger ( 'Primary Keys of db in whereData()' );
			$this->_helper->logger ( $pkey );*/
		
		$setOr = false;
		foreach ( $primaryKeys as $num => $tupleKey ) {
			if ($setOr) {
				$where .= ' OR ';
			}
			$setAnd = false;
			$where .= ' ( ';
			foreach ( $pkey as $num => $col ) {
				if ($setAnd) {
					$where .= ' AND ';
				}
				$where .= $this->model->getAdapter ()->quoteInto ( "$col = ?", $tupleKey [$num] );
				$setAnd = true;
			}
			$where .= ' ) ';
			$setOr = true;
		}
		/*
			$this->_helper->logger ( '#where condition in whereData()' );
			$this->_helper->logger ( $where );*/
		
		return $where;
	}
	
	/**
	 * (C)reate, (R)ead, (U)pdate, (D)elete function.
	 * 
	 * All CRUD activities pass through this method.
	 * @return mixed Status of Add/Update/Delete commands if successful else exception string with header status {@link $errorCode}.
	 */
	public function crudAction() {
		$request = $this->getRequest ();
		$status = NULL;
		$errorCode = 400;
		if ($request->isXmlHttpRequest () and $request->isPost ()) {
			self::createDbCols ();
			switch ($request->getParam ( 'oper' )) {
				case 'add' :
					$rdata = $request->getParams ();
					$data = self::paramData ( $rdata );
					try {
						$status = $this->model->insert ( $data );
						echo $status;
					} catch ( Zend_Exception $e ) {
						$this->_helper->logger->err ( $e->getMessage () );
						$this->_helper->logger->alert ( 'Row insertion failure :' );
						$this->_helper->logger ( 'Status = ' . $status );
						$this->_helper->logger->alert ( 'Request Data :' );
						$this->_helper->logger ( $rdata );
						$this->_helper->logger->alert ( 'Processed data :' );
						$this->_helper->logger ( $data );
						
						$this->getResponse ()->setHttpResponseCode ( $errorCode );
						echo 'DATA SUBMIT FAILED: Either criteria is not fulfilled or inputs are wrong.';
						return false;
					}
					if ($status) {
						$this->_helper->logger->debug ( 'Status :' );
						$this->_helper->logger ( $status );
					}
					return true;
					break;
				
				case 'del' :
					$id = $request->getParam ( 'id' );
					$where = self::whereData ( $id );
					try {
						$status = $this->model->delete ( $where );
					} catch ( Zend_Exception $e ) {
						$this->_helper->logger->err ( $e->getMessage () );
						$this->_helper->logger->err ( 'Row deletion failure :' );
						$this->_helper->logger ( 'Status = ' . $status );
						$this->_helper->logger->alert ( 'WHERE clause :' );
						$this->_helper->logger ( $where );
						$this->getResponse ()->setHttpResponseCode ( $errorCode );
						echo 'CANNOT DELETE: Either dependents exists or permission not granted.';
						return false;
					}
					if ($status) {
						$this->_helper->logger->debug ( 'Status :' );
						$this->_helper->logger ( $status );
					}
					return true;
					break;
				
				case 'edit' :
					$rdata = $request->getParams ();
					$data = self::paramData ( $rdata );
					
					$id = $rdata ['id'];
					$where = self::whereData ( $id );
					try {
						$status = $this->model->update ( $data, $where );
					} catch ( Zend_Exception $e ) {
						$this->_helper->logger->err ( $e->getMessage () );
						$this->_helper->logger->err ( 'Row updation failure :' );
						$this->_helper->logger ( 'Status = ' . $status );
						
						$this->getResponse ()->setHttpResponseCode ( $errorCode );
						echo 'CANNOT UPDATE: Either criteria not fulfilled or permission not granted.';
						return false;
					}
					if ($status) {
						$this->_helper->logger->debug ( 'Status :' );
						$this->_helper->logger ( $status );
					}
					return true;
					break;
				
				default :
					$this->_helper->logger->crit ( 'The param "oper" has unexpected value :' . $request->getParam ( 'oper' ) );
					return false;
			}
		} else {
			$this->_helper->logger->err ( 'Criteria to access CRUD is not fullfilled' );
			header ( "HTTP/1.1 403 Forbidden" );
			die ();
		}
	
	}
	
	/**
	 * Prepares the data, then fetch and encode to json
	 * @return json response
	 */
	protected function fillgridfinal() {
		$response = $this->jqgrid->prepareResponse ();
		
		$result = $this->jqgrid->fetchdata ();
		$pkey = $this->model->info ( 'primary' );
		
		foreach ( $result as $key => $row ) {
			$gridTuplekey = null;
			foreach ( $pkey as $num => $col ) {
				$gridTuplekey [] = $row [$col];
			}
			$response->rows [$key] ['id'] = implode ( '__', $gridTuplekey );
			$response->rows [$key] ['cell'] = array_values ( $row );
		}
		$this->_helper->json ( $response );
	}
	/*
	protected function gridsetup() {
		$format = new stdClass ();
		
		//$format->config ['url'] = $request['url'];
		

		//$format->config ['datatype'] = 'json';
		

		foreach ( $this->gridCols as $key => $value ) {
			$format->colNames [$key] = $value;
		}
		
		foreach ( $this->dbCols as $key => $value ) {
			$format->colModel [$key] ['name'] = $value;
			$format->colModel [$key] ['index'] = $value;
			$format->colModel [$key] ['editable'] = true;
		}
		$format->sortname = $this->dbCols [0];
		
		$colSetup = json_encode ( $format );
		$colSetup = substr ( $colSetup, 1, strlen ( $colSetup ) - 2 );
		return $colSetup;
	}
*/
	
	public static function getLogger() {
		if (Zend_Registry::isRegistered ( 'logger' )) {
			$logger = Zend_Registry::get ( 'logger' );
			return $logger;
		} else {
			return false;
		}
	
	}
	
	public function getCache($cacheName = 'database') {
		$cache = $this->getFrontController ()->getParam ( 'bootstrap' )->getResource ( 'cachemanager' )->getCache ( $cacheName );
		return $cache;
	}
}