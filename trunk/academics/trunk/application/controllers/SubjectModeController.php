<?php
class Department_SubjectModeController extends Aceis_Base_BaseController {
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
		$this->jqgrid = new Aceis_Base_Helper_Jqgrid ();
		self::createModel ();
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		if ($request->isXmlHttpRequest () and $valid) {
			
			$this->jqgrid->setGridparam ( $request );
			
			$this->jqgrid->sql = $this->model->select ()
											->from ( $this->model->info ( 'name' ) );
			
			/*$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'subject_mode_name' :
							$this->jqgrid->sql->where ( "$key LIKE ?", $value . '%' );
							break;
						case 'subject_mode_id' :
						case 'subject_type_id' :
							$this->jqgrid->sql->where ( "$key = ?", $value );
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
	
	/*
	 * 
	 */
	public function getactivesubjectmodeAction() {
		$request = $this->getRequest ();
		$format = $request->getParam ( 'format', 'json' );
		$subject_code = $request->getParam ( 'subject_code' );
		// If this attribute is set then it will show only grouplevel subject mode and not class level.
		$groupMode = ('PARTIAL' == $request->getParam ( 'period_status' )) ? 'TRUE' : NULL;
		if (isset ( $subject_code )) {
			$result = Department_Model_DbTable_SubjectMode::getSubjectModes ( $subject_code, $groupMode );
			switch (strtolower ( $format )) {
				case 'json' :
					$this->_helper->json($result);
					return;
				case 'select' :
					echo '<select>';
					echo '<option>Select one</option>';
					foreach ( $result as $key => $row ) {
						echo '<option value="' . $row ['subject_mode_id'] . '">' . $row ['subject_mode_id'] . '</option>';
					}
					echo '</select>';
					return;
			}
		}
		
		header ( "HTTP/1.1 400 Bad Request" );
		echo 'Oops!! Incorrect way to access data.';
	
	}
	public function getsubjectmodeAction()
	{
	$request = $this->getRequest ();	
	$subject_code = $request->getParam ( 'subject_code' );
	if (isset ( $subject_code )) {
			$resultSet = Department_Model_DbTable_SubjectMode::getSubjectModes ( $subject_code);
			$this->_helper->json($resultSet);
			return;
	}
		header ( "HTTP/1.1 400 Bad Request" );
		echo 'Oops!! Incorrect way to access data.';
		
	}

    /*
     * 
     */
    public function getisgrouptogetherAction() {
        $request = $this->getRequest ();
        $format = $request->getParam ( 'format', 'select' );
        $subject_mode = $request->getParam ( 'subject_mode_id' );
        if (isset ( $subject_mode )) {
            $result = Department_Model_DbTable_SubjectMode::groupTogether($subject_mode);
            echo $result;
            return ;
        }
        
        header ( "HTTP/1.1 400 Bad Request" );
        echo 'Oops!! Inputs are incorrect.';
    
    }

}