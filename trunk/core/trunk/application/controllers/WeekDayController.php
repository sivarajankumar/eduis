<?php
/**
 * @category   Aceis
 * @package    Default
 * @subpackage WeekDay
 * @since	   0.1
 */
/**
 * Manage weekday (i.e. working days).
 *
 */
class WeekDayController extends Corez_Base_BaseController {
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
		$this->jqgrid = new $this->_helper->jqgrid ();
		self::createModel ();
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
						case 'weekday_number' :
							$this->jqgrid->sql->where ( "$key = ?", $value . '%' );
							break;
						case 'weekday_name' :
							$this->jqgrid->sql->where ( "$key LIKE ?", '%' . $value . '%' );
							break;
					}
				}
			}
			self::fillgridfinal ();
		
		} else {
			header ( "HTTP/1.1 403 Forbidden" );
		}
	
	}
	
	public function getweekdayAction() {
		$result = Core_Model_DbTable_WeekDay::fillday ();
		$format = $this->getRequest ()->getParam ( 'format', 'json' );
		switch (strtolower ( $format )) {
			case 'json' :
				$this->_helper->json ( $result );
				return;
			case 'select' :
				echo '<select>';
				echo "<option>Select one</option>";
				foreach ( $result as $key => $object ) {
					echo '<option value="' . $object ['weekday_number'] . '">' . $object ['weekday_name'] . '</option>';
				}
				echo '</select>';
				return;
			default:
				header ( "HTTP/1.1 400 Bad Request" );
				echo 'Unsupported format';
		}
	}
}

