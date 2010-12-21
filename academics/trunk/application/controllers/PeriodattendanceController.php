<?php

/**
 * PeriodattendanceController
 * 
 * @author
 * @version 
 */

class Department_PeriodattendanceController extends Aceis_Base_BaseController{
	/**
	 * The default action - show the home page
	 */
	protected $objPeriodAttendance;
	protected $objStudentAttendance;
	public function init() {
		$this->objPeriodAttendance = new Department_Model_DbTable_PeriodAttendance ( );
		$this->objStudentAttendance = new Department_Model_DbTable_StudentAttendance ( );
		parent::init();
	}
	
	public function noaclisperiodtakenAction() {
		$request = $this->getRequest ();
		$this->_helper->viewRenderer->setNoRender ();
		$this->_helper->layout ()->disableLayout ();
		$periodDateobj = new Zend_Date($request->getParam ( "period_date" ),'dd/MMM/yyyy');
		$period_date = $periodDateobj->toString('YYYY-MM-dd HH:mm:ss');
		$timetable_ids = $request->getParam ( 'timetable_ids' );
		$token = strtok ( $timetable_ids, " " );
		$timetable_arr = array ();
		$key = 0;
		while ( $token != false ) {
			$timetable_id = substr ( $token, strpos ( $token, ":" ) + 1 );
			$timetable_arr [$key] ['timetable_id'] = $timetable_id;
			$token = strtok ( " " );
			$key ++;
		}
		$flag = $this->objPeriodAttendance->checkMarked ( $timetable_arr, $period_date );
		
		if ($flag) {
			$result = $this->objStudentAttendance->getMarkedStudentList ( $timetable_arr, $period_date );
			if (count ( $result ) == 0) {
				echo json_encode ( true );
			} else {
				echo json_encode ( $result );
			}
		} else {
			echo json_encode ( false );
		}
	
	}
	
	public function markperiodattendanceAction() {
		//try{
		$request = $this->getRequest ();
		$timetable_ids = $request->getParam ( 'timetable_ids' );
		$markeddateObj = new Zend_Date(Zend_Date::ISO_8601);
		$marked_date = $markeddateObj->toString('YYYY-MM-dd HH:mm:ss');
		$periodDateobj = new Zend_Date($request->getParam ( "period_date" ),'dd/MMM/yyyy');
		$period_date =   $periodDateobj->get(Zend_Date::YEAR) .  '-' . $periodDateobj->get(Zend_Date::MONTH) . '-' . $periodDateobj->get(Zend_Date::DAY);//$periodDateobj->toString('YYYY-MM-dd HH:mm:ss');
		$staff_id = $request->getParam ( "staff_id" );
		if (isset ( $timetable_ids ) and isset ( $period_date ) and isset ( $staff_id )) {
			$token = strtok ( $timetable_ids, " " );
			$count = 0;
			//Check whether all periods exists in period_attendance
			
			while ( $token != false ) {
				$timetable_id = substr ( $token, strpos ( $token, ":" ) + 1 );
				$status = Department_Model_DbTable_PeriodAttendance::isPeriodExists($period_date,$timetable_id,$staff_id);
					if(!$status)
				{
					$this->getResponse ()->setHttpResponseCode ( 500 );
					echo $this->_helper->json('Period Attendance Not Exists' . $period_date . ' ' . $timetable_id );
					return;
					
				}
				$token = strtok ( " " );
				$count++;
			}
			$token = NULL;
			$token = strtok ( $timetable_ids, " " );
			$count = 0;
			
			//update period marked date
			
			while ( $token != false ) {
				$timetable_id = substr ( $token, strpos ( $token, ":" ) + 1 );
				$status = $this->objPeriodAttendance->markPeriodAttendance($period_date,$timetable_id,$staff_id,$marked_date);
				$token = strtok ( " " );
				$count++;
			}
			echo $this->_helper->json('period attendance done!');
				
					
		} else {
			$this->getResponse ()->setHttpResponseCode ( 400 );
			echo("Isufficient parameters!!");
		}
		
	}

}


