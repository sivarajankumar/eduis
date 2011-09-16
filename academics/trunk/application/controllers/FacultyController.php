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
}

