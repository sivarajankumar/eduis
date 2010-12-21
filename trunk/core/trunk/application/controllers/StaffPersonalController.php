<?php

class StaffPersonalController extends Aceis_Base_BaseController {
	/*
     * @about Interface.
     */
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		$this->view->assign ( 'controller', $this->_request->getControllerName () );
		$this->view->assign ( 'module', $this->_request->getModuleName () );
	}
	
	/*
     * Back end data provider to datagrid.
     * @return JSON data
     */
	public function fillgridAction() {
		$this->jqgrid = new Aceis_Base_Helper_Jqgrid ( );
		self::createModel();
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		if ($request->isXmlHttpRequest () and $valid) {
			
			$this->jqgrid->setGridparam ( $request );
			
			$this->jqgrid->sql = $this->model->select ()->from ( $this->model->info ( 'name' ) );
			
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'staff_id' :
						case 'first_name' :
						case 'middle_name' :
						case 'last_name' :
						case 'department_id' :
							$this->jqgrid->sql->where ( "$key LIKE ?", $value . '%' );
							break;
					}
				}
			}
			self::fillgridfinal ();
		
		} else {
			header ( "HTTP/1.1 403 Forbidden" );
		}
	
	}
}