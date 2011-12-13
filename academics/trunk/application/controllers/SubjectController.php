<?php
class SubjectController extends Acadz_Base_BaseController
{
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
        $valid = $request->getParam('nd');
        if ($request->isXmlHttpRequest() and $valid) {
            $this->grid = $this->_helper->grid();
            $this->grid->sql = $this->model->select()->from(
            $this->model->info('name'));
            $searchOn = $request->getParam('_search');
            if ($searchOn != 'false') {
                $sarr = $request->getParams();
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
        $format = $request->getParam('format', 'json');
        $subject_code = $request->getParam('subject_code');
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
    
    

    public function gettestAction(){
        $request = $this->getRequest();
        $department = $request->getParam('department_id');
        $subject_code = $request->getParam('subject_code');
        $locked = $request->getParam('locked');
        $format = $this->getRequest()->getParam('format', 'json');
        $subject = new Acad_Model_Course_Subject();
        $subject->setSubject_code($subject_code)->setDepartment($department);
        $result = $subject->getTest($locked);
        switch (strtolower($format)) {
            case 'json':
                echo $this->_helper->json($result,false);
                return;
            case 'jsonp':
                $callback = $request->getParam('callback');
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
    
    public function attendanceAction() {
        $request = $this->getRequest();
        $department_id = $request->getParam('department_id');
        $subject_code = $request->getParam('subject_code');
        $subject_mode_id = $request->getParam('subject_mode_id');
        $fail = $request->getParam('fail',65);
        $pass = $request->getParam('pass',75);
        $subject_mode_id = $request->getParam('subject_mode_id');
        $format = $this->getRequest()->getParam('format', 'html');
        
        $result = null;
        if ($subject_code and $department_id) {
            $subject = new Acad_Model_Course_Subject();
            $subject->setSubject_code($subject_code)
                    ->setDepartment($department_id)
                    ->setModes($subject_mode_id);
            $result['stat'] = $subject->getStudentAttendanceStat();
            $result['attendance'] = $subject->getStudentAttendance();
            $result['faculty']= $subject->getFaculty();
            $result['subject_name'] = $subject->getSubject_name();
        }
        
        if (!(( string ) $fail === ( string ) ( int ) $fail) 
			or !(( string ) $pass === ( string ) ( int ) $pass) 
			or !($pass > $fail)) {
            throw new Exception('Check Pass and Fail parameters, Hint: "Pass"(i.e. '.
            $pass.') must be greater then "fail"(i.e. '.$fail.')', Zend_Log::ERR);
        }
        
        switch (strtolower($format)) {
            case 'test':
                $this->_helper->logger($result);
                return;
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                
                $this->view->assign('fail',$fail);
                $this->view->assign('pass',$pass);
                
                $this->view->assign('department_id',$department_id);
                $this->view->assign('subject_code',$subject_code);
                $this->view->assign('subject_mode_id',$subject_mode_id);
                
                $this->view->assign('stat',$result['stat']);
                $this->view->assign('attendance',$result['attendance']);
                $this->view->assign('faculty',$result['faculty']);
                $this->view->assign('subject_name',$result['subject_name']);
                
                return;
            case 'json':
                echo $this->_helper->json($result,false);
                return;
            case 'jsonp':
                $callback = $request->getParam('callback');
                echo $callback . '(' . $this->_helper->json($result, false) . ')';
                return;
        }
        
    }
    
}