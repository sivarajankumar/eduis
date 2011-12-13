<?php
class FacultyController extends Acadz_Base_BaseController
{
    
    public function getsubjectAction (){
        $request = $this->getRequest();
        //$faculty_id = $request->getParam('faculty_id');
        $department = $request->getParam('department_id');
        $degree = $request->getParam('degree_id');
        $semester = $request->getParam('semester_id');
        $showModes = $request->getParam('modes');
        $format = $this->getRequest()->getParam('format', 'json');
        $faculty = new Acad_Model_Member_Faculty();
        $class = null;
        if (isset($department) and isset($degree) and isset($semester)) {
            $class = new Acad_Model_Class();
            $class->setDepartment($department)->setDegree($degree)->setSemester($semester);
        }
        
        $result = $faculty->getSubjects($class,$showModes);
        switch (strtolower($format)) {
            case 'json':
                echo $this->_helper->json($result,false);
                return;
            case 'jsonp':
                $callback = $request->getParam('callback');
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
        
        $request = $this->getRequest();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $authInfo = Zend_Auth::getInstance()->getStorage()->read();
            $faculty_id = $authInfo['identity'];
            
            $faculty = new Acad_Model_Member_Faculty();
            $marked = $faculty->setFacultyId($faculty_id)->listMarkedAttendance();
            $this->view->assign('marked', $marked);
        }
        
        $department = $request->getParam('department_id');
        $programme = $request->getParam('programme_id');
        $semester = $request->getParam('semester_id');
        $subject_code = $request->getParam('subject_code');
        $subject_mode_id = $request->getParam('subject_mode_id');
        
    }
    
    public function attendanceAction() {
        $request = $this->getRequest();
        $department_id = $request->getParam('department_id');
        $programme_id = $request->getParam('programme_id');
        $semester_id = $request->getParam('semester_id');
        $faculty_id = $request->getParam('faculty_id');
        $dateFrom = $request->getParam('date_from');
        $dateUpto = $request->getParam('date_upto');
        $format = $this->getRequest()->getParam('format', 'test');
        
        $faculty = new Acad_Model_Member_Faculty();
        if (true) {
            $faculty->setFacultyId($faculty_id);
        }
        $faculty->setDepartment($department_id);
        $objLevel = null;
        if ($department_id and $programme_id and $semester_id) {
            $objLevel = new Acad_Model_Class();
            $objLevel->setDepartment($department_id)
                    ->setProgramme_id($programme_id)
                    ->setSemester($semester_id);
        }
        if ($department_id) {
            $objLevel = new Acad_Model_Department();
            $objLevel->setDepartment($department_id);
        }
        $subjects = $faculty->getInHandSubjects($objLevel);
        foreach ($subjects as $subject_code => $subjectClasses) {
            foreach ($subjectClasses as $key => $subjectClass) {
                $subject = new Acad_Model_Course_Subject();
                $subjectMode = isset($subjectClass['subject_mode_id'])
                                            ?$subjectClass['subject_mode_id']
                                            :null;
                $subject->setSubject_code($subject_code)
                        ->setModes($subjectMode)
                        ->setDepartment($department_id);
                if (isset($subjectClass['department_id'])) {
                    $subject->setDepartment($subjectClass['department_id']);
                } else {
                    $subject->setDepartment($department_id);
                }
                if (isset($subjectClass['semester_id'])) {
                    $subject->setSemester($subjectClass['semester_id']);
                }
                $attendanceTotal = $subject->getAttendanceTotal($dateFrom, $dateUpto);
                
                $subjectFaculty= $subject->getFaculty();
                if (!isset($subjects[$subject_code]['subject_name'])) {
                    $subjects[$subject_code]['subject_name'] = $subject->getSubject_name();
                }
                if ($subjectMode) {
                    $subjects[$subject_code][$key]['attendance'] = $attendanceTotal[$subjectMode];
                    $subjects[$subject_code][$key]['faculty'] = $subjectFaculty[$subjectMode];
                } else {
                    $subjects[$subject_code][$key]['attendance'] = $attendanceTotal;
                    $subjects[$subject_code][$key]['faculty'] = $subjectFaculty;
                }
            }
        }
        switch (strtolower($format)) {
            case 'test':
                $this->_helper->logger($subjects);
                return;
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('department_id',$department_id);
                
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

