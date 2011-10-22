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
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $subject_code = $request->getParam('subject_code');
        $subject_mode_id = $request->getParam('subject_mode_id');
        $department_id = $request->getParam('department_id');
        $this->view->assign('subject_code',$subject_code);
        $this->view->assign('subject_mode_id',$subject_mode_id);
        $this->view->assign('department_id',$department_id);
        if (isset($subject_code)) {
            $subject = new Acad_Model_Course_Subject();
            $subject->setSubject_code($subject_code)
                    ->setDepartment($department_id)
                    ->setModes($subject_mode_id);
                    
            $attendanceTotal = $subject->getAttendanceTotal();
            $this->view->assign('attendanceTotal',$attendanceTotal);
            $this->_helper->logger($attendanceTotal);
        }
    }
    
    
    public function attendancestatAction() {
        $request = $this->getRequest();
        $department = $request->getParam('department_id');
        $subject_code = $request->getParam('subject_code');
        $subject_mode = $request->getParam('subject_mode_id');
        $subject = new Acad_Model_Course_Subject();
        $subject->setSubject_code($subject_code)
                ->setDepartment($department)
                ->setModes($subject_mode);
        $format = $this->getRequest()->getParam('format', 'json');
        $result['stat'] = $subject->getStudentAttendanceStat();
        $result['attendance'] = $subject->getStudentAttendance();
        $result['total'] = $subject->getAttendanceTotal();
        switch (strtolower($format)) {
            case 'test':
                $this->_helper->logger($result);
                return;
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
        
    }
    
}