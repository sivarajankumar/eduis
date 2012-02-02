<?php
class FacultyController extends Acadz_Base_BaseController
{
    public function getsubjectAction (){
        //$faculty_id = $this->_getParam('faculty_id');
        $department = $this->_getParam('department_id');
        $programme_id = $this->_getParam('programme_id');
        $semester = $this->_getParam('semester_id');
        $showModes = $this->_getParam('modes');
        $format = $this->_getParam('format', 'json');
        $faculty = new Acad_Model_Member_Faculty();
        $class = null;
        if (isset($department) and isset($programme_id) and isset($semester)) {
            $class = new Acad_Model_Class();
            $class->setDepartment($department)
                    ->setProgramme_id($programme_id)
                    ->setSemester($semester);
        }
        
        $result = $faculty->getSubjects($class,$showModes);
        switch (strtolower($format)) {
            case 'json':
                echo $this->_helper->json($result,false);
                return;
            case 'jsonp':
                $callback = $this->_getParam('callback');
                echo $callback . '(' . $this->_helper->json($result, false) . ')';
                return;
            case 'select':
                echo '<select id="facultySubject">';
                echo '<option value="">Select one</option>';
                foreach ($result as $subjectCode => $subjectInfo) {
                    foreach ($subjectInfo as $key => $subject) {
                        $mode = isset($subject['subject_mode_id'])? $subject['subject_mode_id'] : null;
                        $modeValStr = isset($mode)? '_'.$mode : null;
                        $modeTxtStr = isset($mode)? ' - '.$mode : null;
                        echo '<option value="' . $subjectCode.$modeValStr. '">'
                                                .ucwords(strtolower($subject['subject_name']))
                                                .$modeTxtStr . '</option>';
                    }
                }
                echo '</select>';
                return;
        }
        header("HTTP/1.1 400 Bad Request");
    }
    
    public function markedattendanceAction() {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $authInfo = Zend_Auth::getInstance()->getStorage()->read();
            $faculty_id = $authInfo['identity'];
            
            $faculty = new Acad_Model_Member_Faculty();
            $marked = $faculty->setFacultyId($faculty_id)->listMarkedAttendance();
            $this->view->assign('marked', $marked);
        }
        
        $department = $this->_getParam('department_id');
        $programme = $this->_getParam('programme_id');
        $semester = $this->_getParam('semester_id');
        $subject_code = $this->_getParam('subject_code');
        $subject_mode_id = $this->_getParam('subject_mode_id');
    }
    
    public function attendanceAction() {
        $department_id = $this->_getParam('department_id');
        $programme_id = $this->_getParam('programme_id');
        $semester_id = $this->_getParam('semester_id');
        $faculty_id = $this->_getParam('faculty_id');
        $dateFrom = $this->_getParam('date_from');
        $dateUpto = $this->_getParam('date_upto');
        $format = $this->_getParam('format', 'html');
        
        $faculty = new Acad_Model_Member_Faculty();
        if (true) {
            $faculty->setFacultyId($faculty_id);
        }
        $faculty->setDepartment($department_id);
        $objLevel = null;
        if ($department_id) {
            $objLevel = new Acad_Model_Department();
            $objLevel->setDepartment($department_id);
        }
        if ($department_id and $programme_id and $semester_id) {
            $objLevel = new Acad_Model_Class();
            $objLevel->setDepartment($department_id)
                    ->setProgramme_id($programme_id)
                    ->setSemester($semester_id);
        }
        $subjects = $faculty->getInHandSubjects($objLevel,TRUE);
        foreach ($subjects as $subject_code => $subjectClasses) {
            $subject = new Acad_Model_Course_Subject(array('subject_code'=>$subject_code));
            $subjectName = $subject->getSubject_name();
            foreach ($subjectClasses as $key => $subjectClass) {
                $subjects[$subject_code][$key]['subject_name'] = $subjectName;
            }
        }
        switch (strtolower($format)) {
            case 'test':
                $this->_helper->logger($subjects);
                return;
            case 'html':
                $this->_helper->logger($subjects);
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('department_id',$this->view->escape($department_id));
                $urlSubjectDetail = $this->_helper->url('attendance','subject');
                $this->view->assign('urlSubjetDetail',$this->view->escape($urlSubjectDetail));
                $this->view->assign('subjects',$subjects);
                $this->view->assign('date_from',$this->view->escape($dateFrom));
                $this->view->assign('date_upto',$this->view->escape($dateUpto));
                $this->view->assign('faculty',$faculty);
                $this->view->assign('viewLevel',$objLevel);
                return;
            case 'json':
                echo $this->_helper->json($subjects,false);
                return;
            case 'jsonp':
                $callback = $this->_getParam('callback');
                echo $callback . '(' . $this->_helper->json($subjects, false) . ')';
                return;
        }
    }
}

