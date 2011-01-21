<?php

/**
 * RackController
 * 
 * @author
 * @version 
 */

class RackController extends Libz_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		$this->view->assign ( 'controller', $this->_request->getControllerName () );
		$this->view->assign ( 'module', $this->_request->getModuleName () );
		//$this->view->assign ( 'colSetup', self::gridsetup () );
	}
	
	public function fillgridAction() {
		self::getModel();
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		if ($request->isXmlHttpRequest () and $valid) {
			$this->grid = $this->_helper->grid();
			$this->grid->sql = $this->model->select ()->from ( $this->model->info ( 'name' ) );
			
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'rack_id' :
						case 'shelf' :
							$this->grid->sql->where ( "$key = ?", $value );
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