<?php
/**
 * To Specify Groups in a Class
 *
 * Usually a class is divided into some groups.
 * 
 * @category   Aceis
 * @package    Default
 * @subpackage Groups
 * @since	   0.1
 */
/*
 * GroupsController
 * 
 */
class GroupsController extends Corez_Base_BaseController {
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
		if ($request->isXmlHttpRequest () and $valid) {
			$this->grid = new $this->_helper->grid ( );
			
			$this->grid->sql = $this->model->select ()->from ( $this->model->info ( 'name' ) );
			
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'department_id' :
						case 'degree_id' :
						case 'group_id' :
							$this->grid->sql->where ( "$key LIKE ?", $value . '%' );
							break;
					}
				}
			}
			self::fillgridfinal ();
		
		} else {
			header ( "HTTP/1.1 403 Forbidden" );
		}
	
	}
	
	////////combos//////////
	public function getgroupAction() {
		$request = $this->getRequest ();
		$format = $request->getParam ( 'format', 'json' );
		$department = $request->getParam ( 'department_id' );
		$degree = $request->getParam ( 'degree_id' );
		$all = $request->getParam ( 'all' );
		if (isset ( $degree ) and isset ( $department )) {
			$result = Core_Model_DbTable_Groups::getClassGroups ( $department, $degree );
			switch (strtolower ( $format )) {
				case 'json' :
					$this->_helper->json ( $result );
					return;
				case 'select' :
					echo '<select>';
					echo '<option value="">Select one</option>';
					if (isset ( $all )) {
						echo '<option value="ALL">All</option>';
					}
					foreach ( $result as $key => $row ) {
						echo '<option value="' . $row ['group_id'] . '">' . $row ['group_id'] . '</option>';
					}
					echo '</select>';
					return;
			}
		}
		header ( "HTTP/1.1 400 Bad Request" );
	}
}