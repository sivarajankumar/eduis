<?php
/**
 * PeriodattendanceController
 * 
 * @category   EduIS
 * @package    Academic
 * @subpackage Batch
 * @since	   0.1
 * @version    0.1
 */
class PeriodattendanceController extends Acadz_Base_BaseController
{
    /**
     * The default action - show the home page
     */
    protected $objPeriodAttendance;
    protected $objStudentAttendance;
    public function init ()
    {
        parent::init();
    }
    public function getisperiodtakenAction ()
    {
        $this->objPeriodAttendance = new Acad_Model_DbTable_PeriodAttendance();
        $this->objStudentAttendance = new Acad_Model_DbTable_StudentAttendance();
        $request = $this->getRequest();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout()->disableLayout();
        $periodDateobj = new Zend_Date($request->getParam("period_date"), 
        'dd/MMM/yyyy');
        $period_date = $periodDateobj->toString('YYYY-MM-dd HH:mm:ss');
        $timetable_ids = $request->getParam('timetable_ids');
        $token = strtok($timetable_ids, " ");
        $timetable_arr = array();
        $key = 0;
        while ($token != false) {
            $timetable_id = substr($token, strpos($token, ":") + 1);
            $timetable_arr[$key]['timetable_id'] = $timetable_id;
            $token = strtok(" ");
            $key ++;
        }
        $flag = $this->objPeriodAttendance->checkMarked($timetable_arr, 
        $period_date);
        if ($flag) {
            $result = $this->objStudentAttendance->getMarkedStudentList(
            $timetable_arr, $period_date);
            if (count($result) == 0) {
                echo json_encode(true);
            } else {
                echo json_encode($result);
            }
        } else {
            echo json_encode(false);
        }
    }
    public function markperiodattendanceAction ()
    {
        $this->objPeriodAttendance = new Acad_Model_DbTable_PeriodAttendance();
        //try{
        $request = $this->getRequest();
        $timetable_ids = $request->getParam('timetable_ids');
        $markeddateObj = new Zend_Date(Zend_Date::ISO_8601);
        $marked_date = $markeddateObj->toString('YYYY-MM-dd HH:mm:ss');
        $periodDateobj = new Zend_Date($request->getParam("period_date"), 
        'dd/MMM/yyyy');
        $period_date = $periodDateobj->get(Zend_Date::YEAR) . '-' .
         $periodDateobj->get(Zend_Date::MONTH) . '-' .
         $periodDateobj->get(Zend_Date::DAY); //$periodDateobj->toString('YYYY-MM-dd HH:mm:ss');
        $staff_id = $request->getParam("staff_id");
        if (isset($timetable_ids) and isset($period_date) and isset($staff_id)) {
            $token = strtok($timetable_ids, " ");
            $count = 0;
            //Check whether all periods exists in period_attendance
            while ($token != false) {
                $timetable_id = substr($token, strpos($token, ":") + 1);
                $status = Acad_Model_DbTable_PeriodAttendance::isPeriodExists(
                $period_date, $timetable_id, $staff_id);
                if (! $status) {
                    $this->getResponse()->setHttpResponseCode(500);
                    echo $this->_helper->json(
                    'Period Attendance Not Exists' . $period_date . ' ' .
                     $timetable_id);
                    return;
                }
                $token = strtok(" ");
                $count ++;
            }
            $token = NULL;
            $token = strtok($timetable_ids, " ");
            $count = 0;
            //update period marked date
            while ($token != false) {
                $timetable_id = substr($token, strpos($token, ":") + 1);
                $status = $this->objPeriodAttendance->markPeriodAttendance(
                $period_date, $timetable_id, $staff_id, $marked_date);
                $token = strtok(" ");
                $count ++;
            }
            echo $this->_helper->json('period attendance done!');
        } else {
            $this->getResponse()->setHttpResponseCode(400);
            echo ("Isufficient parameters!!");
        }
    }
    public function getperiodstudentsAction ()
    {
        $request = $this->getRequest(); /*
		$department_id = $request->getParam ( 'department_id' );
		$degree_id = $request->getParam ( 'degree_id' );
		$semester_id = $request->getParam ( 'semester_id' );*/
        $staff_id = $request->getParam('staff_id');
        $periodId = $request->getParam('period_id');
        $period_dateobj = new Zend_Date($request->getParam('period_date'), 
        'dd-MM-YYYY');
        $periodDate = $period_dateobj->toString('YYYY-MM-dd');
        $period = new Acad_Model_Period($periodId);
        $groups = $period->getGroups($periodDate, $staff_id);
        $studentList = array();
        $resultSet = array();
        $resultSet['totalgroups'] = count($groups);
        $resultSet['group_id'] = $groups;
        $totalrows = 0;
        $totalstudents = 0;
        foreach ($groups as $key => $group) {
            $group_id = $group['group_id'];
            $group_number = substr($group_id, strlen($group_id) - 1);
            $class = new Acad_Model_Class();
            $class->setDepartment($period->getDepartment())
            ->setDegree($period->getDegree())
            ->setSemester($period->getSemester());
            $studentList = Acad_Model_ClassMapper::fetchSemesterStudents(
            $class, $group_id);
            $totalstudents = $totalstudents + count($studentList);
            if ($totalrows < count($studentList)) {
                $totalrows = count($studentList);
            }
            $resultSet[$group_id] = array("group_number" => $group_number, 
            "students" => $studentList);
        }
        $resultSet['totalrows'] = $totalrows;
        $resultSet['totalstudents'] = $totalstudents;
        echo $this->_helper->json($resultSet,false);
    }
    

    public function getstudentsAction ()
    {
        $request = $this->getRequest();
		$department_id = $request->getParam ( 'department_id' );
		$degree_id = $request->getParam ( 'degree_id' );
		$semester_id = $request->getParam ( 'semester_id' );
		$group_id = $request->getParam ( 'group_id' );
		if ('ALL' == strtoupper($group_id) or !isset($group_id)) {
        $groups = Acad_Model_DbTable_Groups::getClassGroups($department_id, $degree_id);
		} else {
		    $groups = array($group_id);
		}
            
        $studentList = array();
        $resultSet = array();
        $resultSet['totalgroups'] = count($groups);
        $resultSet['group_id'] = $groups;
        $totalrows = 0;
        $totalstudents = 0;
        foreach ($groups as $key => $group_id) {
            $group_number = substr($group_id, strlen($group_id) - 1);
            $class = new Acad_Model_Class();
            $class->setDepartment($department_id)
            ->setDegree($degree_id)
            ->setSemester($semester_id);
            $studentList = Acad_Model_ClassMapper::fetchSemesterStudents(
            $class, $group_id);
            $totalstudents = $totalstudents + count($studentList);
            if ($totalrows < count($studentList)) {
                $totalrows = count($studentList);
            }
            $resultSet[$group_id] = array("group_number" => $group_number, 
            "students" => $studentList);
        }
        $resultSet['totalrows'] = $totalrows;
        $resultSet['totalstudents'] = $totalstudents;
        echo $this->_helper->json($resultSet,false);
    }
}


