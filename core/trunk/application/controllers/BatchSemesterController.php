<?php
/**
 * @category   Aceis
 * @package    Default
 * @subpackage BatchSemester
 */
/*
 * Batch status w.r.t. semester
 *
 * Every semester batch advances to a new semester. It can manage that information.
 *
 * 
 */
class BatchSemesterController extends Corez_Base_BaseController {
	/*
     * @about Interface.
     */
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		$this->view->assign ( 'controller', $this->_request->getControllerName () );
		$this->view->assign ( 'module', $this->_request->getModuleName () );
	
		//$this->view->assign ( 'colSetup', self::gridsetup() );
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
			$this->grid = new $this->_helper->grid ();
			$this->grid->sql = $this->model->select ()->from ( $this->model->info ( 'name' ) );
			/*
            $searchOn = $request->getParam ( '_search' );
            if ($searchOn != 'false') {
                $sarr = $request->getParams ();
                foreach ( $sarr as $key => $value ) {
                    switch ($key) {
                        case 'isbn_id' :
                            $this->grid->sql->where ( "$key = ?", $value );
                            break;
                        case 'title' :
                        case 'long_title' :
                        case 'author' :
                            $this->grid->sql->where ( "$key LIKE ?", $value . '%' );
                            break;
                    }
                }
            }*/
			self::fillgridfinal ();
		} else {
			header ( "HTTP/1.1 403 Forbidden" );
			die ();
		}
	}

	////////combos//////////
/*
	 * deprecated
    public function combobatchsemAction() {
        //TODO PENDING...Still not in use
        $batch_dept = $this->getRequest ()->getParam ( 'batch_dept' );
        $batch_degree = $this->getRequest ()->getParam ( 'batch_degree' );
        $batch_start = $this->getRequest ()->getParam ( 'batch_start' );
        if (isset ( $batch_dept ) and isset ( $batch_degree ) and isset ( $batch_start )) {
            $result = $this->table->currentBatchSemester ( $batch_dept, $batch_degree, $batch_start );
            
            echo '<select>';
            if (1 == count ( $result )) {
                echo '<option value="' . $result [0] ['current_dept'] . '__' . $result [0] ['current_semester'] . '">' . $result [0] ['current_semester'] . '</option>';
            } else {
                echo '<option>Select one</option>';
                foreach ( $result as $key => $option ) {
                    echo '<option value="' . $option ['current_dept'] . '__' . $option ['current_semester'] . '">' . $option ['current_semester'] . '</option>';
                }
            }
            
            echo '</select>';
        } else {
            header ( "HTTP/1.1 403 Forbidden" );
            die ();
        }
    
    }*/
/*
     * Get an active batch's current semester
    
	public function getbatchsemesterAction() {
		$request = $this->getRequest ();
		$format = $request->getParam ( 'format', 'json' );
		$department = $request->getParam ( 'department_id' );
		$degree = $request->getParam ( 'degree_id' );
		$batch_start = $request->getParam ( 'batch_start' );
		if (isset ( $degree ) and isset ( $department ) and isset ( $batch_start )) {
			$result = Model_DbTable_BatchSemester::getBatchSemester ( $department, $degree, $batch_start );
			switch (strtolower ( $format )) {
				case 'json' :
					return;
					break;
				case 'select' :
					return;
					break;
			}
		}
		
		header ( "HTTP/1.1 400 Bad Request" );
		echo 'Either format type not supported or incorrect.';
		die ();
	
	}
	
	/*
     * Get Semester's Batch
     
	public function getsemesterbatchAction() {
		$request = $this->getRequest ();
		$format = $request->getParam ( 'format', 'json' );
		$department = $request->getParam ( 'department' );
		$degree = $request->getParam ( 'degree' );
		$batch_start = $request->getParam ( 'batch_start' );
		$result = $this->table->semesterBatch ();
		
		switch (strtolower ( $format )) {
			case 'json' :
				break;
			case 'select' :
				break;
			
			default :
		
		}
	
	}
	*/
}
