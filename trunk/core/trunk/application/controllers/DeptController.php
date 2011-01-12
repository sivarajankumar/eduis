<?php
/**
 * @category   EduIS
 * @package    Core
 * @subpackage Dept
 */
/**
 * Department
 * 
 */
class DeptController extends Corez_Base_BaseController {
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
	 * @about Back end data provider to datagrid.
	 * @return JSON data
	 */
	public function fillgridAction() {
		self::createModel ();
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		if ($valid) {
			$this->grid = new $this->_helper->grid ( );
			
			$this->grid->sql = $this->model->select ()->from ( $this->model->info ( 'name' ) );
			
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'department_id' :
							$this->grid->sql->where ( "$key LIKE ?", $value . '%' );
							break;
						case 'department_name' :
							$this->grid->sql->where ( "$key LIKE ?", '%' . $value . '%' );
							break;
					}
				}
			}
			self::fillgridfinal ();
		
		} else {
			header ( "HTTP/1.1 403 Forbidden" );
		}
	
	}
	/*
	 * @return Options for 'Select' element of HTML.
	 */
	public function getdepartmentAction() {
		self::createModel ();
		$format = $this->getRequest ()->getParam ( 'format', 'json' );
		$result = $this->model->select ()->query ()->fetchAll ();
		switch (strtolower ( $format )) {
			case 'json' :
				$this->_helper->json ( $result );
				return;
			case 'select' :
				echo '<select>';
				echo '<option value="">Select One</option>';
				foreach ( $result as $key => $object ) {
					echo '<option value="' . $object ['department_id'] . '">' . $object ['department_id'] . '-' . $object ['department_name'] . '</option>';
				}
				echo '</select>';
				return;
		}
	
	}

}
