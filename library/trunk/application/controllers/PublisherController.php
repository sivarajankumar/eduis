<?php

/**
 * BookController
 * 
 * @author
 * @version 
 */

class PublisherController extends Libz_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	protected $table;
	//static $temp;
	
	public function init() {
		$this->table = new Lib_Model_DbTable_Publisher ( );
		//self::$temp++;
		$this->dbCols [] = 'publisher_id';
		$this->dbCols [] = 'publisher_name';
		$this->dbCols [] = 'address';
		
		$this->gridCols [] = 'Publisher';
        $this->gridCols [] = 'Publisher Name';
        $this->gridCols [] = 'Address';
		parent::init ();
	}
	
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		$this->view->assign ( 'controller', $this->_request->getControllerName () );
		$this->view->assign ( 'module', $this->_request->getModuleName () );
		$this->view->assign ( 'colSetup', self::gridsetup() );
	}
	
	public function fillgridAction() {
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		if ($request->isXmlHttpRequest () and $valid) {
			
			$this->jqgrid->setGridparam ( $request );
			
			$this->jqgrid->sql = $this->table->select ()->from ( $this->table->info ( 'name' ) );
			
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'address' :
						case 'publisher_name' :
							
							$this->jqgrid->sql->where ( "$key LIKE ?", $value . '%' );
							break;
						case 'publisher_id' :
							$this->jqgrid->sql->where ( "$key = ?", $value );
							break;
					}
				}
			}
			$this->fillgridfinal ();
		
		} else {
			echo ('<b>Error!! </b><br/>)');
		}
	
	}
	
	public function ispublisherAction() {
		$publisher_id = $this->getRequest ()->getParam ( 'publisher_id' );
		$result = $this->table->find($publisher_id)->toArray();
		echo isset($result[0]['publisher_name']);
		
	}

}
?>

