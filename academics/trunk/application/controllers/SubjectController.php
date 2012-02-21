<?php
class SubjectController extends Acadz_Base_BaseController
{
    protected $summary;
    protected $stuModeWiseAtt;
    /*
     * @about Interface.
     */
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->view->assign('controller', $this->_request->getControllerName());
        $this->view->assign('module', $this->_request->getModuleName());
    }
    /*
     * Back end data provider to datagrid.
     * @return JSON data
     */
    public function fillgridAction ()
    {
        self::createModel();
        $request = $this->getRequest();
        $valid = $this->_getParam('nd');
        if ($request->isXmlHttpRequest() and $valid) {
            $this->grid = $this->_helper->grid();
            $this->grid->sql = $this->model->select()->from(
            $this->model->info('name'));
            $searchOn = $this->_getParam('_search');
            if ($searchOn != 'false') {
                $sarr = $this->_getParams();
                foreach ($sarr as $key => $value) {
                    switch ($key) {
                        case 'subject_code':
                        case 'abbr':
                        case 'subject_name':
                        case 'subject_code':
                            $this->grid->sql->where("$key LIKE ?", $value . '%');
                            break;
                        case 'subject_type_id':
                        case 'is_optional':
                        case 'lecture_per_week':
                        case 'tutorial_per_week':
                        case 'practical_per_week':
                        case 'suggested_duration':
                            $this->grid->sql->where("$key = ?", $value);
                            break;
                    }
                }
            }
            self::fillgridfinal();
        } else {
            header("HTTP/1.1 403 Forbidden");
        }
    }
    /*
	 * Show basic information of a subject.
	 * @return array 
	 */
    public function getsubjecinfoAction ()
    {
        $request = $this->getRequest();
        $format = $this->_getParam('format', 'json');
        $subject_code = $this->_getParam('subject_code');
        if (isset($subject_code)) {
            $result = Acad_Model_DbTable_Subject::getSubjectInfo($subject_code);
            switch (strtolower($format)) {
                case 'json':
                    $this->_helper->json($result);
                    return;
                case 'select':
                    echo '<select>';
                    echo '<option>Select one</option>';
                    foreach ($result as $key => $row) {
                        echo '<option value="' . $row['batch_start'] . '">' .
                         $row['batch_start'] . '</option>';
                    }
                    echo '</select>';
                    return;
                default:
                    header("HTTP/1.1 400 Bad Request");
                    echo 'Unsupported format';
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
        }
    }
    public function gettestAction ()
    {
        $request = $this->getRequest();
        $department = $this->_getParam('department_id');
        $subject_code = $this->_getParam('subject_code');
        $locked = $this->_getParam('locked');
        $format = $this->getRequest()->getParam('format', 'json');
        $subject = new Acad_Model_Course_Subject();
        $subject->setSubject_code($subject_code)->setDepartment_id($department);
        $result = $subject->getTest($locked);
        switch (strtolower($format)) {
            case 'json':
                echo $this->_helper->json($result, false);
                return;
            case 'jsonp':
                $callback = $this->_getParam('callback');
                echo $callback . '(' . $this->_helper->json($result, false) . ')';
                return;
            case 'select':
                echo '<select>';
                echo '<option>Select one</option>';
                foreach ($result as $key => $row) {
                    echo '<option value="' . $row['department_id'] . '">' .
                     $row['department_id'] . '</option>';
                }
                echo '</select>';
                return;
                break;
        }
        header("HTTP/1.1 400 Bad Request");
    }
    
    public function attendanceAction ()
    {
        $department_id = $this->_getParam('department_id');
        $subject_code = $this->_getParam('subject_code');
        $subject_mode_id = $this->_getParam('subject_mode_id');
        $lowerThreshold = $this->_getParam('lower', 65);
        $upperThreshold = $this->_getParam('upper', 75);
        $filterBelow = $this->_getParam('filter_below');
        $filterAbove = $this->_getParam('filter_above');
        $dateFrom = $this->_getParam('date_from');
        $dateUpto = $this->_getParam('date_upto');
        $status = $this->_getParam('status');
        $group = $this->_getParam('group');
        $subject_mode_id = $this->_getParam('subject_mode_id');
        $format = $this->_getParam('format', 'html');
    
        if (! ((string) $lowerThreshold === (string) (int) $lowerThreshold) or
         ! ((string) $upperThreshold === (string) (int) $upperThreshold) or ! ($upperThreshold > $lowerThreshold)) {
            throw new Exception(
            'Check lower and upper threshold parameters, Hint: "Upper"(i.e. ' . $upperThreshold .
             ') must be greater then "lower"(i.e. ' . $lowerThreshold . ')', Zend_Log::ERR);
        }
        
        if ($subject_code and $department_id) {
            $subject = new Acad_Model_Course_Subject();
            $subject->setSubject_code($subject_code)
                ->setDepartment_id($department_id)
                ->setSubject_mode_id($subject_mode_id);
            $attendanceSet = $subject->getStudentAttendance($dateFrom,$dateUpto,$status,$group,$filterBelow,$filterAbove);
            $attendanceTotal = $subject->getAttendanceTotal();
            $facultySet = $subject->getFaculty($dateFrom,$dateUpto);
            $stat = $subject->getStudentAttendanceStat();
            $summary = $subject->attendanceSummary($lowerThreshold, $upperThreshold);
            $stuModeWiseAtt = $subject->attendanceStuModeWise();
            $subject_name = $subject->getSubject_name();
        } else {
            throw new Exception('<b>Department Id</b>(department_id) as well as <b>Subject code</b>(subject_code) are <b>required</b>.', Zend_Log::INFO);
        }
        
        switch (strtolower($format)) {
            case 'test':
                $this->_helper->logger($summary);
                $this->_helper->logger($attendanceSet);
                return;
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('department_id', $this->view->escape($department_id));
                $this->view->assign('subject_code', $this->view->escape($subject_code));
                $this->view->assign('subject_mode_id', $this->view->escape($subject_mode_id));
                
                $this->view->assign('lowerThreshold', $lowerThreshold);
                $this->view->assign('upperThreshold', $upperThreshold);
                $this->view->assign('filterBelow', $filterBelow);
                $this->view->assign('filterAbove', $filterAbove);
                
                $this->view->assign('date_from', $dateFrom);
                $this->view->assign('date_upto', $dateUpto);
                
        
                $this->view->assign('stat', $stat);
                $this->view->assign('attendanceSet', $attendanceSet);
                $this->view->assign('subjectModes', array_keys($attendanceSet));
                $this->view->assign('subject_name', $subject_name);
                $this->view->assign('summary', $summary);
                $this->view->assign('stuModeWiseAtt', $stuModeWiseAtt);
                $session_startdate = Acad_Model_DbTable_AcademicSession::getSessionStartDate();
                $this->view->assign('session_startdate', $session_startdate);
                return;
            case 'json':
                echo $this->_helper->json($this->summary, false);
                return;
        }
    }
}