<?php

/**
 * RackController
 * 
 * @author
 * @version 
 */

class RackController extends Aceis_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	protected $table;
	
	public function init() {
		$this->_autoModel = true;
		$this->_autoDbCols = true;
		parent::init ();
	}
	
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		$this->view->assign ( 'controller', $this->_request->getControllerName () );
		$this->view->assign ( 'module', $this->_request->getModuleName () );
		//$this->view->assign ( 'colSetup', self::gridsetup () );
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
						case 'rack_id' :
						case 'shelf' :
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
}