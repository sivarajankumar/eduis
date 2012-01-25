<?php
class StudentattendanceController extends Acadz_Base_BaseController
{
    public $identity;
    public function init ()
    {
        $session_startdate = Acad_Model_DbTable_AcademicSession::getSessionStartDate();
        $this->view->assign('session_startdate', $session_startdate);
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $authInfo = Zend_Auth::getInstance()->getStorage()->read();
            $this->department_id = $authInfo['department_id'];
            $this->identity = $authInfo['identity'];
            $staff_id = $authInfo['identity'];
        }
        $this->view->assign('controller', $this->_request->getControllerName());
        $this->view->assign('module', $this->_request->getModuleName());
        $this->view->assign('staff_id', $this->identity);
        parent::init();
    }
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function markAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->view->assign('staff_id', $this->identity);
    }
    /**
     * @return json response
     */
    public function fillperiodgridAction ()
    {
        $request = $this->getRequest();
        $period_dateobj = null;
        $weekday_number = null;
        //Getting Request Parameters
        $reqDate = $request->getParam('period_date');
        if ($reqDate) {
            $period_dateobj = new Zend_Date($reqDate);
            $weekday_number = $period_dateobj->toString('e');
        } else {
            $period_dateobj = new Zend_Date();
        }
        $staff_id = $request->getParam('staff_id');
        if (! $staff_id) {
            if (Zend_Auth::getInstance()->hasIdentity()) {
                $authInfo = Zend_Auth::getInstance()->getStorage()->read();
                $staff_id = $authInfo['identity'];
            } else {
                throw new Zend_Exception('You need to login first.', 
                Zend_Log::ERR);
            }
        }
        $period_date = $period_dateobj->get(Zend_Date::ISO_8601);
        if (isset($staff_id)) {
            $dayPeriods = Acad_Model_DbTable_TimeTable::getFacultyDayPeriods(
            $staff_id, $period_date, $weekday_number);
            if (isset($period_date) and isset($weekday_number)) {
                $adjustedPeriods = Acad_Model_DbTable_FacultyAdjustment::getAdjusted(
                $staff_id, $period_date);
                foreach ($dayPeriods as $key => $value) {
                    $dayPeriods[$key]['adjusted'] = 0;
                    $dayPeriods[$key]['nonattendance'] = 0;
                    foreach ($adjustedPeriods as $akey => $avalue) {
                        if ($value['timetable_id'] ==
                         $avalue['source_timetable_id']) {
                            $dayPeriods[$key]['adjusted'] = 1;
                        }
                    }
                    $noattendance = Acad_Model_DbTable_NoAttendanceDay::isnoattendanceday(
                    $period_date, $dayPeriods[$key]['department_id'], 
                    $dayPeriods[$key]['degree_id'], 
                    $dayPeriods[$key]['semester_id']);
                    if ($noattendance) {
                        $dayPeriods[$key]['nonattendance'] = 1;
                    }
                }
            }
            $response = new stdClass();
            $response->page = 1;
            $response->total = 1;
            $response->records = count($dayPeriods);
            foreach ($dayPeriods as $key => $period) {
                $response->rows[$key]['id'] = $period['timetable_id'];
                $response->rows[$key]['cell'] = $period;
            }
            echo $this->_helper->json($response, false);
        } else {
            throw new Zend_Exception('Unidentified access', Zend_Log::ALERT);
        }
    }
    public function markabsentAction ()
    {
        $request = $this->getRequest();
        $period_dateobj = new Zend_Date($request->getParam('period_date'), 
        'dd/MMM/yyyy');
        $period_date = $period_dateobj->get(Zend_Date::ISO_8601);
        $student_list = $request->getParam("studentlst");
        if ($student_list) {
            $token = strtok($student_list, " ");
            $objzendtable = new Zend_Db_Table('student_attendance');
            $sql = 'INSERT INTO `student_attendance` (`period_date`, `timetable_id`, `student_roll_no`) VALUES ';
            $addComma = null;
            while ($token != false) {
                $timetable_token = substr($token, 0, strpos($token, "#"));
                $timetable_id = substr($timetable_token, 
                strpos($timetable_token, ":") + 1);
                $rollno_token = substr($token, strpos($token, "#"));
                $student_roll_no = substr($rollno_token, 
                strpos($rollno_token, ":") + 1);
                if ($addComma) {
                    $sql .= ', ';
                }
                $sql .= "('$period_date','$timetable_id','$student_roll_no')";
                $addComma = 1;
                $token = strtok(" ");
            }
            try {
                $objzendtable->getDefaultAdapter()->query($sql);
                echo 'Attendance is marked successfully.';
            } catch (Exception $e) {
                $this->getResponse()->setHttpResponseCode(400);
                echo $e->getMessage();
            }
        } else {
            echo ("Hey, Nice class!! All are present.");
        }
    }
    public function markattendanceAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value) ? $value : htmlentities(trim($value));
            $this->applicant->$colName = $value;
        }
        $period_dateobj = new Zend_Date($request->getParam('period_date'), 
        'dd-MMM-yyyy');
        $period_date = $period_dateobj->toString('YYYY-MM-dd HH:mm:ss');
        $params['period_date'] = $period_date;
        $params['weekday_number'] = $period_dateobj->get(
        Zend_Date::WEEKDAY_DIGIT);
        $params['faculty_id'] = $this->identity;
        $model = new Acad_Model_Member_Student();
        try {
            $insertId = $model->setAttendence($params);
            if ($insertId) {
                if (! isset($params['absentee'])) {
                    echo ("Hey, Nice class!! All are present.\n");
                }
                echo 'Attendance marked successfully with period ID: ' .$insertId .
                 ".\n Kindly note down this Id in case of any mistake.";
            } else {
                echo 'Attendance could not be submitted this time. Please try again.';
            }
        } catch (Exception $e) {
            $this->_helper->logger->debug($e->getMessage());
            switch ($e->getCode()) {
                case 23000:
                    throw new Zend_Exception(
                    'Attendance has been already marked.', Zend_Log::ERR);
                    break;
                default:
                    throw new Zend_Exception(
                    'Sorry, unable to process the request', Zend_Log::ERR);
                    break;
            }
        }
    }
    ////////////////
    /**
     * @deprecated
     */
    public function fetchmarkedAction ()
    {
        $myarray = array();
        $myarray['staff_id'] = $_GET['staffid'];
        $myarray['weekday_number'] = $_GET['dayid'];
        $myarray['period_number'] = $_GET['periodnum'];
        $myarray['subject_code'] = $_GET['subcode'];
        $myarray['subject_mode_id'] = $_GET['submode'];
        $myarray['group_id'] = $_GET['groupid'];
        $myarray['semester_id'] = $_GET['semid'];
        //$myarray['Period_date'] = $_GET['pdate'];
        $timetableid = $this->getuniquettid($myarray);
        if ($timetableid) {
            $date = $_GET['pdate'];
            $sql = "select student_roll_no from student_attendance where timetable_id=" .
             "'" . $timetableid . "'" . ' AND Period_Date=' . "'" . $date . "'";
            $result = $this->getData($sql);
            foreach ($result as $key => $object) {
                echo ($object->student_roll_no . ',');
            }
        } else {
            echo "Multiple Entry of Period";
            return false;
        }
    }
    public function viewstuwiseAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $class = new Acad_Model_Class();
        $class->setDepartment('cse')
            ->setDegree('btech')
            ->setSemester('8');
        //$this->_helper->logger($class->getAttendance('CSE-202E',null,'2011-03-08','2011-03-10'));
        $this->_helper->logger($class->getSubjects());
    }
    public function getoverviewAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function getoverviewdataAction ()
    {
        $request = $this->getRequest();
        //Getting Request Parameters
        $period_dateobj = new Zend_Date(
        $request->getParam('attendance_date'), 'dd-MM-YYYY');
        $period_date = $period_dateobj->toString('YYYY-MM-dd');
        //$this->_helper->viewRenderer->setNoRender(false);
        //$this->_helper->layout()->enableLayout();
        $class = new Acad_Model_Department();
        $result = $class->getAttendanceOverview($period_date);
        $this->gridparam['page'] = $request->getParam('page', 1); // get the requested page
        $this->gridparam['limit'] = $request->getParam('rows', 20); // rows limit in Grid
        $this->_count = count($result);
        $response = new stdClass();
        foreach ($result as $key => $value) {
            $response->rows[$key]['id'] = $value['department_id'];
            $response->rows[$key]['cell'] = array($value['department_id'], 
            $value['total'], $value['marked'], $value['last_marked']);
        }
        $response->page = $this->gridparam['page'];
        $response->total = 1;
        $response->records = $this->_count;
        echo $this->_helper->json($response, false);
    }
    /**
     * Department wise detail of data
     * Enter description here ...
     */
    public function getdetaildataAction ()
    {
        $request = $this->getRequest();
        //Getting Request Parameters
        $period_dateobj = new Zend_Date(
        $request->getParam('attendance_date'), 'dd-MM-YYYY');
        $period_date = $period_dateobj->toString('YYYY-MM-dd');
        $department = $request->getParam('department_id');
        //$this->_helper->viewRenderer->setNoRender(false);
        //$this->_helper->layout()->enableLayout();
        $depttObj = new Acad_Model_Department();
        $depttObj->setDepartment($department);
        $result = $depttObj->getAttendanceDetail($period_date);
        $this->_helper->logger($result);
        $this->gridparam['page'] = $request->getParam('page', 1); // get the requested page
        $this->gridparam['limit'] = $request->getParam('rows', 20); // rows limit in Grid
        $this->_count = count($result);
        $response = new stdClass();
        foreach ($result as $key => $value) {
            $response->rows[$key]['id'] = $value['subject_code'];
            $response->rows[$key]['cell'] = array($value['staff_id'], 
            $value['marked_date'], $value['degree_id'], $value['semester_id'], 
            $value['periods_covered'], $value['subject_code'], 
            $value['subject_mode_id'], $value['group_id']);
        }
        $response->page = $this->gridparam['page'];
        $response->total = 1;
        $response->records = $this->_count;
        echo $this->_helper->json($response, false);
    }
    /*public function reportstuwiseAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        self::createModel();
        //$rollno = '2306001';
        $rollno = $this->getRequest()->getParam('rollno');
        if ($rollno) {
            $semsubjectInfo = new Acad_Model_DbTable_TimeTable();
            $periodInfo = new Acad_Model_DbTable_PeriodAttendance();
            $student = Acad_Model_DbTable_StudentDepartment::getStudentInfo(
            $rollno);
            if ($student) {
                $semsubjects = Acad_Model_DbTable_SubjectDepartment::getSemesterSubjects(
                $student['department_id'], $student['degree_id'], 
                $student['semester_id']);
                foreach ($semsubjects as $row => $subject) {
                    $semsubjects[$row]['ttids'] = $semsubjectInfo->getSubjectTimetableids(
                    $student['department_id'], $student['degree_id'], 
                    $student['semester_id'], $subject['subject_code'], '', 
                    $student['group_id'], FALSE);
                    $semsubjects[$row]['totLec'] = $periodInfo->totalLectures(
                    $semsubjects[$row]['ttids']);
                    $semsubjects[$row]['absent'] = $this->model->totalAbsent(
                    $semsubjects[$row]['ttids'], $rollno);
                }
                $this->view->assign('student', $student);
                $this->view->assign('semsubjects', $semsubjects);
            } else {
                echo 'Either the Roll number is invalid or not active';
            }
        } else {
            echo 'Student Roll number is required';
        }
        //$totSub = $this->table->totalSubjects ( $rollno );
		//$totLec = $this->table->totalLectures ( $rollno );
		//$totAbsent = $this->table->totalAbsent ( $rollno );
		//$this->processData ( $totSub, $totLec, $totAbsent );
    //print_r($totLec);
    //print_r($totAbsent);
    }*/
    public function getsubjectattAction ()
    {
        $class = new Acad_Model_Class();
        $class->setDepartment('CSE')
            ->setDegree('BTECH')
            ->setSemester('8');
        $result = $class->getSubjectAttendanceDetail('CSE-302');
        $this->_helper->logger($result);
    }
    public function getlastmarkedAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $faculty = new Acad_Model_Member_Faculty();
        $faculty->setMemberId($this->identity);
        $result = $faculty->listMarkedAttendance();
        $this->view->assign('lastMarked', $result);
    }
    //############# Unmarked attendances....
    /**
     * Unmarked by an individual faculty
     */
    public function getunmarkedAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function getunmarkedattAction ()
    {
        $faculty = new Acad_Model_Member_Faculty();
        $staff_id = ($this->getRequest()->getParam('staff_id')) ? $this->getRequest()->getParam(
        'staff_id') : $this->identity;
        $faculty->setMemberId($staff_id);
        $result = $faculty->listUnMarkedAttendance();
        echo $this->_helper->json($result, false);
    }
    /**
     * Unmarked in class
     */
    public function getclassunmarkedAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function getclassunmarkedattAction ()
    {
        $request = $this->getRequest();
        $department = $request->getParam('department_id');
        $degree = $request->getParam('degree_id');
        $semester = $request->getParam('semester_id');
        $class = new Acad_Model_Class();
        $class->setDepartment($department)
            ->setDegree($degree)
            ->setSemester($semester);
        $result = $class->getUnmarkedAttendance();
        $response = new stdClass();
        $response->page = 1;
        $response->total = 1;
        $response->records = count($result);
        $response->rows = $result;
        echo $this->_helper->json($response, false);
         //$this->_helper->logger($result);
    }
}






