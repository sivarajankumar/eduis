<?php

class Department_StudentattendanceController extends Acadz_Base_BaseController {
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( FALSE );
		$this->_helper->layout ()->enableLayout ();
		$this->view->assign ( 'controller', $this->_request->getControllerName () );
		$this->view->assign ( 'module', $this->_request->getModuleName () );
		if (Zend_Auth::getInstance ()->hasIdentity ()) {
			$arr = Zend_Auth::getInstance ()->getIdentity ();
			$staff_id = $arr [1];
			$this->view->assign ( 'staff_id', $staff_id );
			$session_startdate = Model_DbTable_AcademicSession::getSessionStartDate ();
			$this->view->assign ( 'session_startdate', $session_startdate );
		
		}
	
	}
	/**
	 * @return json responce
	 */
	public function fillperiodgridAction() {
		$request = $this->getRequest ();
		//Getting Request Parameters
		$staff_id = $request->getParam ( 'staff_id' );
		$weekday_number = $request->getParam ( 'weekday_number' );
		$department_id = $request->getParam ( 'department_id' );
		$period_dateobj = new Zend_Date ( $request->getParam ( 'period_date' ),'dd/MMM/yyyy' );
		$period_date = $period_dateobj->toString ( 'YYYY-MM-dd' );
		
		if (isset ( $staff_id )) {
			$dayPeriods = Acad_Model_DbTable_TimeTable::getFacultyDayPeriods ( $staff_id, $period_date,$weekday_number);
			
		if((isset ( $period_date )))
			{
			$adjustedPeriods = Acad_Model_DbTable_FacultyAdjustment::getAdjusted ( $staff_id, $period_date );
			foreach ( $dayPeriods as $key => $value ) {
				$dayPeriods [$key] ['adjusted'] = 0;
				$dayPeriods [$key] ['nonattendance'] = 0;
				foreach ( $adjustedPeriods as $akey => $avalue ) {
					if ($value ['timetable_id'] == $avalue ['source_timetable_id']) {
						$dayPeriods [$key] ['adjusted'] = 1;
					}
				}
				$noattendance = Acad_Model_DbTable_NoAttendanceDay::isnoattendanceday ( $period_date, $dayPeriods [$key] ['department_id'], $dayPeriods [$key] ['degree_id'], $dayPeriods [$key] ['semester_id'] );
				if ($noattendance) {
					$dayPeriods [$key] ['nonattendance'] = 1;
				}
			}
			}
			//echo json_encode($dayPeriods);
			echo $this->_helper->json( $dayPeriods );
		} else {
			$this->getResponse ()->setHttpResponseCode ( 400 );
			echo "Bad Parameters..";
		}
	}
	
	public function markabsentAction() {
		$request = $this->getRequest ();
		$period_dateobj = new Zend_Date ( $request->getParam ( 'period_date' ),'dd/MMM/yyyy');
		$period_date = $period_dateobj->toString ( 'YYYY-MM-dd HH:mm:ss' );
		$student_list = $request->getParam ( "studentlst" );
		if ($student_list) {
			$token = strtok ( $student_list, " " );
			$objzendtable = new Zend_Db_Table ( 'student_attendance' );
			$sql = 'INSERT INTO `student_attendance` (`period_date`, `timetable_id`, `student_roll_no`) VALUES ';
			$addComma = null;
			while ( $token != false ) {
				$timetable_token = substr ( $token, 0, strpos ( $token, "#" ) );
				$timetable_id = substr ( $timetable_token, strpos ( $timetable_token, ":" ) + 1 );
				$rollno_token = substr ( $token, strpos ( $token, "#" ) );
				$student_roll_no = substr ( $rollno_token, strpos ( $rollno_token, ":" ) + 1 );
				if ($addComma) {
					$sql .= ', ';
				}
				$sql .= "('$period_date','$timetable_id','$student_roll_no')";
				$addComma = 1;
				$token = strtok ( " " );
			}
			try {
				$objzendtable->getDefaultAdapter ()->query ( $sql );
				echo 'Attendance is marked successfully.';
			} catch ( Exception $e ) {
				$this->getResponse ()->setHttpResponseCode ( 400 );
				echo $e->getMessage ();
			}
		} else {
			echo ("Hey, Nice class!! All are present.");
		}
		
	}
	
	////////////////
	

	/**
	 * @deprecated
	 */
	public function fetchmarkedAction() {
		$myarray = array ();
		$myarray ['staff_id'] = $_GET ['staffid'];
		$myarray ['weekday_number'] = $_GET ['dayid'];
		$myarray ['period_number'] = $_GET ['periodnum'];
		$myarray ['subject_code'] = $_GET ['subcode'];
		$myarray ['subject_mode_id'] = $_GET ['submode'];
		$myarray ['group_id'] = $_GET ['groupid'];
		$myarray ['semester_id'] = $_GET ['semid'];
		//$myarray['Period_date'] = $_GET['pdate'];
		$timetableid = $this->getuniquettid ( $myarray );
		if ($timetableid) {
			$date = $_GET ['pdate'];
			$sql = "select student_roll_no from student_attendance where timetable_id=" . "'" . $timetableid . "'" . ' AND Period_Date=' . "'" . $date . "'";
			$result = $this->getData ( $sql );
			foreach ( $result as $key => $object ) {
				echo ($object->student_roll_no . ',');
			}
		} else {
			echo "Multiple Entry of Period";
			return false;
		}
	}
	

	public function reportstuwiseAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		self::createModel();
		//$rollno = '2306001';
		$rollno = $this->getRequest ()->getParam ( 'rollno' );
		if ($rollno) {
			$semsubjectInfo = new Acad_Model_DbTable_TimeTable ( );
			$periodInfo = new Acad_Model_DbTable_PeriodAttendance ( );
			
			$student = Acad_Model_DbTable_StudentDepartment::getStudentInfo($rollno);
			if ($student) {
				$semsubjects = Acad_Model_DbTable_SubjectDepartment::getSemesterSubjects ( $student ['department_id'], $student ['degree_id'], $student ['semester_id']);
			foreach ( $semsubjects as $row => $subject ) {
				$semsubjects [$row] ['ttids'] = $semsubjectInfo->getSubjectTimetableids ( $student ['department_id'], $student ['degree_id'], $student ['semester_id'], $subject ['subject_code'], '', $student ['group_id'], FALSE );
				$semsubjects [$row] ['totLec'] = $periodInfo->totalLectures ( $semsubjects [$row] ['ttids'] );
				$semsubjects [$row] ['absent'] = $this->model->totalAbsent ( $semsubjects [$row] ['ttids'], $rollno );
			}
			
			$this->view->assign ( 'student', $student );
			$this->view->assign ( 'semsubjects', $semsubjects );
			}
			else {
				echo 'Either the Roll number is invalid or not active';
			}
			
			
		} else {
			echo 'Student Roll number is required';
		}
	
		
	/*$totSub = $this->table->totalSubjects ( $rollno );
		$totLec = $this->table->totalLectures ( $rollno );
		$totAbsent = $this->table->totalAbsent ( $rollno );
		$this->processData ( $totSub, $totLec, $totAbsent );*/
	//print_r($totLec);
	//print_r($totAbsent);
	}

}






