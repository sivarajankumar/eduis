<?php

class FacultyAdjustmentController extends Acadz_Base_BaseController {
	protected $objtimetable;
	protected $objfacultyadjustment;
	protected $request;
	protected $response;
	protected $param;

	public function init() {
		$this->_helper->viewRenderer->setNoRender ( true );
		$this->_helper->layout ()->disableLayout ();
		$this->objtimetable = new Acad_Model_DbTable_TimeTable ( );
		$this->objfacultyadjustment = new Acad_Model_DbTable_FacultyAdjustment();

		$this->param = array();


			
	}

	/**
	 * @param WHERE condition
	 * @param OREDER BY clause
	 * @param Number of row to fetch
	 * @param Offset row from where fetching to be started
	 * @return fetched result array
	 */


	/*
	 * @about Interface.
	 */
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		if(isset($_SESSION['staff_detail']))
		{
			$staff_Details=$_SESSION['staff_detail'];
			$department_id= $staff_Details['department_id'];
			$this->view->assign('department_id',$department_id);
			$session_startdate = Model_DbTable_AcademicSession::getSessionStartDate ();
			$this->view->assign ( 'session_startdate', $session_startdate );
		}
	}



	public function adjustperiodAction()
	{
		$request = $this->getRequest();
		$period_id = $request->getParam('period_id');
		$staff_id = 	   $request->getParam('staff_id');
		$target_subject = $request->getParam('target_subject');
		$target_staff_id = $request->getParam('target_staff_id');
		$adjustment_dateobj =new Zend_Date($request->getParam ( 'adjustment_date' ),'dd/MMM/yyyy');
		$adjustment_date = $adjustment_dateobj->toString('YYYY-MM-dd HH:mm:ss');
		$resultSet = Acad_Model_DbTable_TimeTable::getPeriodIdTimetable($period_id,$adjustment_date,$staff_id);
		$insertData  = NULL;
		try{
			$cnt = 0;
			foreach($resultSet as $key => $value)
			{
				$adj_resultSet = Acad_Model_DbTable_TimeTable::getSubjectTimetableids($value['department_id'],$value['degree_id'],$value['semester_id'],$target_subject,$value['subject_mode_id'],$value['group_id']);
				if(count($adj_resultSet) > 0 )
				{
				$insertData[$cnt++]= array('source_timetable_id' => $value['timetable_id'] , 'start_date' => $adjustment_date, 'source_staff_id' => $staff_id , 'target_timetable_id' => $adj_resultSet[0] , 'target_staff_id' => $target_staff_id ) ;
				}
				else{
					$this->getResponse ()->setHttpResponseCode ( 400 );
					echo $this->_helper->json('Timetable Entry does not exists for ' . implode(',',array($target_subject,$value['subject_mode_id'],$value['group_id'])) );	
					return;
				}
			}
			$result = $this->objfacultyadjustment->adjustperiod($insertData);
		if ($result) {
			echo $this->_helper->json("Period successfully adjusted ");
		} else {
			$this->getResponse ()->setHttpResponseCode ( 400 );
			echo $this->_helper->json('Error occured while adjustment');	
					
		}
		}catch(Exception $ex){
		$this->getResponse ()->setHttpResponseCode ( 400 );
		echo $this->_helper->json('Error occured while adjustment');	
			
		}

			

	}
	public function gettodayadjustmentsAction()
	{
		$request = $this->getRequest();
		$target_staff_id= $request->getParam('staff_id');
		$start_dateobj =new Zend_Date($request->getParam ( 'period_date' ),'dd/MMM/yyyy');
		$start_date = $start_dateobj->toString('YYYY-MM-dd HH:mm:ss');
		$result = Acad_Model_DbTable_FacultyAdjustment::getAdjustment($target_staff_id,$start_date);
		/*if(count($adjustmentResultSet) > 0 )
		{
			$this->objtimetable->dbselect->reset();
			$this->objtimetable->dbselect->distinct ()->group('period_number');
			$cols = array ('degree_id', 'department_id', 'semester_id', 'period_number', 'subject_code', 'subject_mode_id' );
			$result = $this->objtimetable->getadjustmenttimetableinfo ( $adjustmentResultSet, $cols );

		}*/
		echo json_encode($result);
	}
	public function canceladjustmentAction()
	{
		$request = $this->getRequest();
		$staff_id = $request->getParam('staff_id');
		$period_id = $request->getParam('period_id');
		$periodDateobj = new Zend_Date($request->getParam ( "period_date" ),'dd/MMM/yyyy');
		$period_date = $periodDateobj->toString('YYYY-MM-dd HH:mm:ss');
		
		$deleted = Acad_Model_DbTable_FacultyAdjustment::cancelAdjustment($period_id,$staff_id,$period_date);
		if($deleted > 0)
		{
			echo "Adjustment Deleted Successfully";
		}
		else {
			echo "Adjustment Not Deleted ";
		}
		



	}
}