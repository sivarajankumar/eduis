<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage Batch
 * @since	   0.1
 */
/*
 * Batch(es) in a degree of a department.
 * 
 */
class BatchController extends Corez_Base_BaseController {
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
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		if ($request->isXmlHttpRequest () and $valid) {
			self::createModel();
			$this->grid = $this->_helper->grid();
			
			$this->grid->sql = $this->model->select ()->from ( $this->model->info ( 'name' ) );
			
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'department_id' :
						case 'degree_id' :
							$this->grid->sql->where ( "$key LIKE ?", $value . '%' );
							break;
						case 'batch_start' :
							$this->grid->sql->where ( "$key = ?", $value );
							break;
					}
				}
			}
			self::fillgridfinal ();
		
		} else {
			$this->getResponse()
				->setException('Non ajax request')
				->setHttpResponseCode(400);
		}
	
	}
	
	////////combos//////////
	/*
	public function combobatchyearAction() {
		$request = $this->getRequest ();
		$department_id = $request->getParam ( 'department_id' );
		$degree_id = $request->getParam ( 'degree_id' );
		if (isset ( $department_id ) and isset ( $degree_id )) {
			$result = $this->table->fillbatchyear ( $department_id, $degree_id );
			echo '<select>';
			echo '<option>Select one</option>';
			foreach ( $result as $key => $row ) {
				echo '<option value="' . $row ['batch_start'] . '">' . $row ['batch_start'] . '</option>';
			}
			echo '</select>';
		} else {
            header ( "HTTP/1.1 403 Forbidden" );
            die;
		}
	
	}*/
	
	/*
	 * Show active batches of a department's degree
	 * @return array 
	 */
	public function getactivebatchesAction() {
		$request = $this->getRequest ();
		$format = $request->getParam ( 'format', 'json' );
		$department = $request->getParam ( 'department_id' );
		$degree = $request->getParam ( 'degree_id' );
		if (isset ( $degree ) and isset ( $department )) {
			$result = Core_Model_DbTable_Batch::batch ( $department, $degree );
			switch (strtolower ( $format )) {
				case 'json' :
					$this->_helper->json($result);
					return;
				case 'select' :
					echo '<select>';
					echo '<option>Select one</option>';
					foreach ( $result as $key => $row ) {
						echo '<option value="' . $row ['batch_start'] . '">' . $row ['batch_start'] . '</option>';
					}
					echo '</select>';
					return;
				default :
					$this->getResponse()
						->setException('Unsupported format request')
						->setHttpResponseCode(400);
			}
		} else {
			header ( "HTTP/1.1 400 Bad Request" );
		}
	}
	
	/* @deprecated "I think its useless. -hemant"
     * Show all batches of a department's degree
     */
	public function getallbatches() {
		;
	}
}
