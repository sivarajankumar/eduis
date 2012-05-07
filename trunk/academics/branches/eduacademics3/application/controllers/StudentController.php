  <?php
/**
 * StudentController
 * 
 * @author team eduis
 * @version 3
 */
class StudentController extends Zend_Controller_Action
{
    /**
     * 
     *@todo remove static value
     */
    protected $_member_id = 1;
    /**
     * The default action - show the home page
     */
    public function init ()
    {
        /* Initialize action controller here */
    }
    /**
     * @todo Consider :if you dont want any other class to call this function
     * make it private
     * dont allow even view to acess it
     * cause it is for internal functioning only
     * @return the $_member_id
     */
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    public function indexAction ()
    {
        // action body
    }
    /*
     * returns matric data of student
     * @param int qualification_id  
     * @return array $matric_data return array of present data of student in qualification table
     */
    private function fetchMatricData ($qualification_id)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_model = $student_model->fetchQualificationInfo(
        $qualification_id);
        if ($qualification_model instanceof Acad_Model_Qualification_Matric) {
            $matric_data['board'] = $qualification_model->getBoard();
            $matric_data['board_roll_no'] = $qualification_model->getBoard_roll_no();
            $matric_data['city_name'] = $qualification_model->getCity_name();
            $matric_data['institution'] = $qualification_model->getInstitution();
            $matric_data['marks_obtained'] = $qualification_model->getMarks_obtained();
            $matric_data['passing_year'] = $qualification_model->getPassing_year();
            $matric_data['percentage'] = $qualification_model->getPercentage();
            $matric_data['school_rank'] = $qualification_model->getSchool_rank();
            $matric_data['state_name'] = $qualification_model->getState_name();
            $matric_data['total_marks'] = $qualification_model->getTotal_marks();
        }
        return $matric_data;
    }
    /*
     * returns btech data of student
     * @param int qualification_id  
     * @return array $btech return array of present data of student in qualification table
     */
    private function fetchBtechData ($qualification_id)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_model = $student_model->fetchQualificationInfo(
        $qualification_id);
        $btech_data = array();
        if ($qualification_model instanceof Acad_Model_Qualification_Btech) {
            $btech_data['university'] = $qualification_model->getUniversity();
            $btech_data['city_name'] = $qualification_model->getCity_name();
            $btech_data['marks_obtained'] = $qualification_model->getMarks_obtained();
            $btech_data['passing_year'] = $qualification_model->getPassing_year();
            $btech_data['percentage'] = $qualification_model->getPercentage();
            $btech_data['state_name'] = $qualification_model->getState_name();
            $btech_data['total_marks'] = $qualification_model->getTotal_marks();
            $btech_data['discipline_id'] = $qualification_model->getDiscipline_id();
            $btech_data['institution'] = $qualification_model->getDiscipline_id();
            ;
        }
        return $btech_data;
    }
    /*
     * returns twelfth data of student
     * @param int qualification_id  
     * @return array $twelfth_array return array of present data of student in qualification table
     */
    private function fetchTwelfthData ($qualification_id)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_model = $student_model->fetchQualificationInfo(
        $qualification_id);
        if ($qualification_model instanceof Acad_Model_Qualification_Twelfth) {
            $twelfth_data['board'] = $qualification_model->getBoard();
            $twelfth_data['board_roll_no'] = $qualification_model->getBoard_roll_no();
            $twelfth_data['city_name'] = $qualification_model->getCity_name();
            $twelfth_data['institution'] = $qualification_model->getInstitution();
            $twelfth_data['marks_obtained'] = $qualification_model->getMarks_obtained();
            $twelfth_data['passing_year'] = $qualification_model->getPassing_year();
            $twelfth_data['percentage'] = $qualification_model->getPercentage();
            $twelfth_data['school_rank'] = $qualification_model->getSchool_rank();
            $twelfth_data['state_name'] = $qualification_model->getState_name();
            $twelfth_data['total_marks'] = $qualification_model->getTotal_marks();
            $twelfth_data['discipline_id'] = $qualification_model->getDiscipline_id();
            $twelfth_data['pcm_percentage'] = $qualification_model->getPcm_percent();
        }
        return $twelfth_data;
    }
    private function fetchDiplomaData ($qualification_id)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_model = $student_model->fetchQualificationInfo(
        $qualification_id);
        if ($qualification_model instanceof Acad_Model_Qualification_Diploma) {
            $diploma_data['university'] = $qualification_model->getUniversity();
            $diploma_data['board_roll_no'] = $qualification_model->getBoard_roll_no();
            $diploma_data['city_name'] = $qualification_model->getCity_name();
            $diploma_data['institution'] = $qualification_model->getInstitution();
            $diploma_data['marks_obtained'] = $qualification_model->getMarks_obtained();
            $diploma_data['passing_year'] = $qualification_model->getPassing_year();
            $diploma_data['percentage'] = $qualification_model->getPercentage();
            $diploma_data['remarks'] = $qualification_model->getRemarks();
            $diploma_data['state_name'] = $qualification_model->getState_name();
            $diploma_data['total_marks'] = $qualification_model->getTotal_marks();
            $diploma_data['discipline_id'] = $qualification_model->getDiscipline_id();
            $diploma_data['migration_date'] = $qualification_model->getMigration_date();
        }
        return $diploma_data;
    }
    private function fetchCompetitiveExamData ($exam_id)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $exam_data = array();
        $exam_model = new Acad_Model_CompetitiveExam();
        $exam_model->setExam_id($exam_id);
        $exam_model->fetchInfo();
        $student_exam_model = $student_model->fetchCompetitveExamInfo($exam_id);
        if ($student_exam_model instanceof Acad_Model_StudentCompetitiveExam) {
            $exam_data['name'] = $exam_model->getName();
            $exam_data['total_score'] = $student_exam_model->getTotal_score();
            $exam_data['abbr'] = $exam_model->getAbbreviation();
            $exam_data['air'] = $student_exam_model->getAll_india_rank();
            $exam_data['roll_no'] = $student_exam_model->getRoll_no();
            $exam_data['total_score'] = $student_exam_model->getTotal_score();
        }
        return $exam_data;
    }
    private function fetchDmcInfo ($specific_dmc_info_id = null, 
    $class_specific = null, $result_type_specific = null, $all = null, 
    $considered_only = null, $ordered_by_date = null)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        if ($specific_dmc_info_id) {
            $dmc_info = self::setDmcInfoData($specific_dmc_info_id);
            return $dmc_info;
        }
        if ($class_specific) {
            $dmc_info_ids = $student_model->fetchDmcInfoIds(true, null, null, 
            null, null);
            $dmc_info = self::setDmcInfoData($dmc_info_ids);
            return $dmc_info;
        }
        if ($result_type_specific) {
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, true, null, 
            null, true);
            $dmc_info = self::setDmcInfoData($dmc_info_ids);
            return $dmc_info;
        }
        if ($all) {
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, null, true, 
            null, null);
            $dmc_info = self::setDmcInfoData($dmc_info_ids);
            return $dmc_info;
        }
        if ($considered_only) {
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, null, null, 
            true, null);
            $dmc_info = self::setDmcInfoData($dmc_info_ids);
            return $dmc_info;
        }
        if ($ordered_by_date) {
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, null, null, 
            null, true);
            $dmc_info = self::setDmcInfoData($dmc_info_ids);
            return $dmc_info;
        }
    }
    private function setDmcInfoData ($dmc_info_ids)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        if (is_array($dmc_info_ids) and ! empty($dmc_info_ids)) {
            $dmc_info_data = array();
            foreach ($dmc_info_ids as $dmc_info_id => $dmc_id) {
                $dmc_info_model = $student_model->fetchDmcInfo($dmc_info_id);
                if ($dmc_info_model instanceof Acad_Model_Course_DmcInfo) {
                    $dmc_info_data[$dmc_info_id]['dmc_id'] = $dmc_id;
                    $dmc_info_data[$dmc_info_id]['dispatch_date'] = $dmc_info_model->getDispatch_date();
                    $dmc_info_data[$dmc_info_id]['marks_obtained'] = $dmc_info_model->getMarks_obtained();
                    $dmc_info_data[$dmc_info_id]['percentage'] = $dmc_info_model->getPercentage();
                    $dmc_info_data[$dmc_info_id]['result_type_id'] = $dmc_info_model->getResult_type_id();
                    $dmc_info_data[$dmc_info_id]['scaled_marks'] = $dmc_info_model->getScaled_marks();
                    $dmc_info_data[$dmc_info_id]['total_marks'] = $dmc_info_model->getTotal_marks();
                }
            }
        } else {
            $dmc_info_model = $student_model->fetchDmcInfo($dmc_info_ids);
            if ($dmc_info_model instanceof Acad_Model_Course_DmcInfo) {
                $dmc_info_data[$dmc_info_ids]['dmc_id'] = $dmc_info_model->getDmc_id();
                $dmc_info_data[$dmc_info_ids]['dispatch_date'] = $dmc_info_model->getDispatch_date();
                $dmc_info_data[$dmc_info_ids]['marks_obtained'] = $dmc_info_model->getMarks_obtained();
                $dmc_info_data[$dmc_info_ids]['percentage'] = $dmc_info_model->getPercentage();
                $dmc_info_data[$dmc_info_ids]['result_type_id'] = $dmc_info_model->getResult_type_id();
                $dmc_info_data[$dmc_info_ids]['scaled_marks'] = $dmc_info_model->getScaled_marks();
                $dmc_info_data[$dmc_info_ids]['total_marks'] = $dmc_info_model->getTotal_marks();
            }
        }
        return $dmc_info_data;
    }
    private function fetchsubjectDmc ($dmc_info_id, $subject_ids)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $dmc_data = array();
        if (is_array($subject_ids)) {
            foreach ($subject_ids as $key => $subject_id) {
                $dmc_object = $student_model->fetchDmc($dmc_info_id, 
                $subject_id);
                if ($dmc_object instanceof Acad_Model_Course_DmcMarks) {
                    $dmc_data[$subject_id]['date'] = $dmc_object->getDate();
                    $dmc_data[$subject_id]['external'] = $dmc_object->getExternal();
                    $dmc_data[$subject_id]['internal'] = $dmc_object->getInternal();
                    $dmc_data[$subject_id]['percentage'] = $dmc_object->getPercentage();
                }
            }
        } else {
            $dmc_object = $student_model->fetchDmc($dmc_info_id, $subject_ids);
            if ($dmc_object instanceof Acad_Model_Course_DmcMarks) {
                $dmc_data['date'] = $dmc_object->getDate();
                $dmc_data['external'] = $dmc_object->getExternal();
                $dmc_data['internal'] = $dmc_object->getInternal();
                $dmc_data['percentage'] = $dmc_object->getPercentage();
            }
        }
        return $dmc_data;
    }
    private function fetchStudentSubjects ($class_id)
    {
        $class_object = new Acad_Model_StudentSubject();
        $class_object->setClass_id($class_id);
        $class_object->setMember_id($this->getMember_id());
        $subject_ids = $class_object->fetchSubjects();
        $subject_data = array();
        foreach ($subject_ids as $key => $subject_id) {
            $subject_object = new Acad_Model_Subject();
            $subject_object->setSubject_id($subject_id);
            $subject_object->fetchInfo();
            $subject_data[$subject_id]['name'] = $subject_object->getSubject_name();
            $subject_data[$subject_id]['code'] = $subject_object->getSubject_code();
        }
        return $subject_data;
    }
    private function fetchclassdmc ($class_id, $dmc_view_type, 
    $dmc_info_id = null)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $student_subject = new Acad_Model_StudentSubject();
        $student_subject->setMember_id($this->getMember_id());
        $student_subject->setClass_id($class_id);
        $subject_ids = $student_subject->fetchSubjects();
         Zend_Registry::get('logger')->debug($subject_ids);
        $subject_data = array();
        $dmc_data = array();
        $dmc_info_data = array();
        switch ($dmc_view_type) {
            case 'latest':
                $subject_data = self::fetchStudentSubjects($class_id);
                $class_dmc_info_id_array = $student_model->fetchDmcInfoIds($class_id, 
                null, null, null, true);
               $dmc_info_id_array = array_keys($class_dmc_info_id_array);
                $dmc_info_id = $dmc_info_id_array[0];
                if ($dmc_info_id) {
                    $dmc_info_data = self::fetchDmcInfo($dmc_info_id);
                    $dmc_data = self::fetchsubjectDmc($dmc_info_id, 
                    $subject_ids);
                }
                break;
            case 'single':
                $subject_data = self::fetchStudentSubjects($class_id);
                $dmc_info_data = self::fetchDmcInfo($dmc_info_id);
                $dmc_data = self::fetchsubjectDmc($dmc_info_id, $subject_ids);
                break;
        }
        $response = array('dmc_info_data' => $dmc_info_data, 
        'dmc_data' => $dmc_data, 'subject_data' => $subject_data);
        Zend_Registry::get('logger')->debug($response);
        return $response;
    }
    public function registerAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $critcal_info = $student_model->fetchCriticalInfo();
        Zend_Registry::get('logger')->debug($critcal_info);
        if ($critcal_info == false) {
            $PROTOCOL = 'http://';
            $URL_STU_CRITICAL_INFO = $PROTOCOL . CORE_SERVER .
             '/student/fetchcriticalinfo';
            $client = new Zend_Http_Client($URL_STU_CRITICAL_INFO);
            $client->setCookie('PHPSESSID', $_COOKIE['PHPSESSID']);
            $response = $client->request();
            if ($response->isError()) {
                $remoteErr = 'REMOTE ERROR: (' . $response->getStatus() . ') ' .
                 $response->getMessage();
                throw new Zend_Exception($remoteErr, Zend_Log::ERR);
            }
            $critical_data = Zend_Json::decode($response->getBody());
            if ($critical_data) {
                $student_model->saveCriticalInfo($critical_data);
            } else {
                $msg = 'PLEASE REGISTER IN CORE MODULE....GOTO core.aceambala.com';
                throw new Exception('$msg');
            }
        }
        $this->_redirect('student/profile');
    }
    /**
     * @todo check status of profile in auth that it is filled or not
     * Enter description here ...
     */
    public function profileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $this->_helper->viewRenderer->setNoRender(false);
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $filled_qualifications = array();
        $qualification_model = new Acad_Model_Qualification();
        $qualifications = $qualification_model->fetchQualifications();
        $qualfication_id_array = $student_model->fetchQualificationsIds();
        if (is_array($qualfication_id_array)) {
            $qualification_ids = array_flip($qualfication_id_array);
            $filled_qualifications = array_intersect_key($qualifications, 
            $qualification_ids);
        }
        $degree_data = array();
        $info = array();
        $class_ids = array();
        $class_semester = array();
        $class_dmc_info_ids = array();
        $dmc_dispatch_dates = array();
        $no_details_sems = array();
        $student = new Acad_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $class_ids = $student->fetchAllClassIds();
        $class = new Acad_Model_Class();
        foreach ($class_ids as $class_id) {
            //for unsetting object properties
            //$class->initsave();
            $class->setClass_id($class_id);
            $class->fetchInfo();
            $semester_id = $class->getSemester_id();
            $class_semester[$class_id] = $semester_id;
        }
        foreach ($class_semester as $class_idA => $sem) {
            $dmc_info_ids = array();
            $dmc_info_ids = $student->fetchDmcInfoIds($class_idA);
            if (! $dmc_info_ids) {
                $dmc_info_ids = array();
                $no_details_sems[] = $sem;
            } else {
                $class_dmc_info_ids[$class_idA] = $dmc_info_ids;
            }
        }
        $dmc_dispatch_dates = $student->fetchDmcInfoIdsByDate(true);
        foreach ($class_dmc_info_ids as $class_idB => $dmc_info_id_array) {
            $semester_idA = $class_semester[$class_idB];
            foreach ($dmc_info_id_array as $dmc_info_id => $dmc_id) {
                $degree_data[$semester_idA][$dmc_info_id]['class_id'] = $class_idB;
                $degree_data[$semester_idA][$dmc_info_id]['dmc_id'] = $dmc_id;
                $degree_data[$semester_idA][$dmc_info_id]['dispatch_date'] = $dmc_dispatch_dates[$dmc_info_id];
            }
        }
        foreach ($no_details_sems as $no_details_sem) {
            $degree_data[$no_details_sem][] = array();
        }
        Zend_Registry::get('logger')->debug($degree_data);
        $exam_model = new Acad_Model_CompetitiveExam();
        $exams = $exam_model->fetchExams();
        $present_exam_ids_array = $student_model->fetchCompetitveExamIds();
        $filled_exams = array();
        if ($present_exam_ids_array) {
            $present_exam_ids = array_flip($present_exam_ids_array);
            $filled_exams = array_intersect_key($exams, $present_exam_ids);
        }
        $response = array('degree_data' => $degree_data, 
        'qualifications' => $qualifications, 
        'filled_qualifications' => $filled_qualifications, 'exams' => $exams, 
        'filled_exams' => $filled_exams);
        Zend_Registry::get('logger')->debug($response);
        switch ($format) {
            case 'html':
                $this->view->assign('filled_qualifications', 
                $filled_qualifications);
                $this->view->assign('degree_data', $degree_data);
                $this->view->assign('class_semester', $class_semester);
                $this->view->assign('qualifications', $qualifications);
                $this->view->assign('exams', $exams);
                $this->view->assign('filled_exams', $filled_exams);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' .
                 $this->_helper->json($filled_qualifications, false) . ')';
                break;
            case 'json':
                $this->_helper->json($filled_qualifications);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($filled_qualifications);
                break;
            default:
                ;
                break;
        }
    }
    public function viewmatricinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $qualification_name = 'MATRIC';
        $qualification_model = new Acad_Model_Qualification();
        $qualifications = $qualification_model->fetchQualifications();
        $qualification_id = array_search($qualification_name, $qualifications);
        $qualification_data = self::fetchMatricData($qualification_id);
        Zend_Registry::get('logger')->debug($qualification_data);
        switch ($format) {
            case 'html':
                if (! empty($qualification_data)) {
                    $this->view->assign('matric', $qualification_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' .
                 $this->_helper->json($qualification_data, false) . ')';
                break;
            case 'json':
                $this->_helper->json($qualification_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($qualification_data);
                break;
            default:
                ;
                break;
        }
    }
    public function viewtwelfthinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_name = 'TWELFTH';
        $qualification_model = new Acad_Model_Qualification();
        $qualifications = $qualification_model->fetchQualifications();
        $qualification_id = array_search($qualification_name, $qualifications);
        $qualification_data = self::fetchTwelfthData($qualification_id);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($qualification_data)) {
                    $this->view->assign('twelfth', $qualification_data);
                    Zend_Registry::get('logger')->debug($qualification_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($qualification_data, 
                false) . ')';
                break;
            case 'json':
                $this->_helper->json($qualification_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($qualification_data);
                break;
            default:
                ;
                break;
        }
    }
    public function viewdiplomainfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_name = 'DIPLOMA';
        $qualification_model = new Acad_Model_Qualification();
        $qualifications = $qualification_model->fetchQualifications();
        $qualification_id = array_search($qualification_name, $qualifications);
        $qualification_data = self::fetchDiplomaData($qualification_id);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($qualification_data)) {
                    $this->view->assign('diploma', $qualification_data);
                    Zend_Registry::get('logger')->debug($qualification_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($qualification_data, 
                false) . ')';
                break;
            case 'json':
                $this->_helper->json($qualification_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($qualification_data);
                break;
            default:
                ;
                break;
        }
    }
    public function viewbtechinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_name = 'BTECH';
        $qualification_model = new Acad_Model_Qualification();
        $qualifications = $qualification_model->fetchQualifications();
        $qualification_id = array_search($qualification_name, $qualifications);
        $qualification_data = self::fetchBtechData($qualification_id);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($qualification_data)) {
                    $this->view->assign('btech', $qualification_data);
                    Zend_Registry::get('logger')->debug($qualification_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' .
                 $this->_helper->json($qualification_data, false) . ')';
                break;
            case 'json':
                $this->_helper->json($qualification_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($qualification_data);
                break;
            default:
                ;
                break;
        }
    }
    public function viewleetinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $exam_name = 'LEET';
        $exam_model = new Acad_Model_CompetitiveExam();
        $exams = $exam_model->fetchExams();
        Zend_Registry::get('logger')->debug($exams);
        $exam_id = array_search($exam_name, $exams);
        $exam_data = self::fetchCompetitiveExamData($exam_id);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($exam_data)) {
                    $this->view->assign('leet', $exam_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($exam_data, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($exam_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($exam_data);
                break;
            default:
                ;
                break;
        }
    }
    public function viewaieeeinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $exam_name = 'AIEEE';
        $exam_model = new Acad_Model_CompetitiveExam();
        $exams = $exam_model->fetchExams();
        $exam_id = array_search($exam_name, $exams);
        $exam_data = self::fetchCompetitiveExamData($exam_id);
        switch ($format) {
            case 'html':
                if (! empty($exam_data)) {
                    $this->view->assign('aieee', $exam_data);
                    Zend_Registry::get('logger')->debug($exam_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($exam_data, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($exam_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($exam_data);
                break;
            default:
                ;
                break;
        }
    }
    public function viewgateinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $exam_name = 'GATE';
        $exam_model = new Acad_Model_CompetitiveExam();
        $exams = $exam_model->fetchExams();
        $exam_id = array_search($exam_name, $exams);
        $exam_data = self::fetchCompetitiveExamData($exam_id);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($exam_data)) {
                    $this->view->assign('gate', $exam_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($exam_data, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($exam_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($exam_data);
                break;
            default:
                ;
                break;
        }
    }
    public function savematricinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $qualification_name = $params['myarray']['qualification_name'];
        $qualification_model = new Acad_Model_Qualification();
        $qualifications = $qualification_model->fetchQualifications();
        $qualification_id = array_search($qualification_name, $qualifications);
        $save_data = $params['myarray']['qualification_data'];
        Zend_Registry::get('logger')->debug($save_data);
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $student_model->saveQualificationInfo($qualification_id, $save_data);
        $success = true;
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($success)) {
                    $this->view->assign('is_successfull', $success);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($success, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($success);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($success);
                break;
            default:
                ;
                break;
        }
    }
    public function savetwelfthinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $qualification_name = $params['myarray']['qualification_name'];
        $qualification_model = new Acad_Model_Qualification();
        $qualifications = $qualification_model->fetchQualifications();
        $qualification_id = array_search($qualification_name, $qualifications);
        $save_data = $params['myarray']['qualification_data'];
        Zend_Registry::get('logger')->debug($save_data);
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $student_model->saveQualificationInfo($qualification_id, $save_data);
        $success = true;
        switch ($format) {
            case 'html':
                if (! empty($success)) {
                    $this->view->assign('is_successfull', $success);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($success, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($success);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($success);
                break;
            default:
                ;
                break;
        }
    }
    public function savediplomainfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $qualification_name = $params['myarray']['qualification_name'];
        $qualification_model = new Acad_Model_Qualification();
        $qualifications = $qualification_model->fetchQualifications();
        $qualification_id = array_search($qualification_name, $qualifications);
        $save_data = $params['myarray']['qualification_data'];
        Zend_Registry::get('logger')->debug($save_data);
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $student_model->saveQualificationInfo($qualification_id, $save_data);
        $success = true;
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($success)) {
                    $this->view->assign('is_successfull', $success);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($success, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($success);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($success);
                break;
            default:
                ;
                break;
        }
    }
    public function savebtechinfoAction ()
    {
        {
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout()->disableLayout();
            $request = $this->getRequest();
            $params = array_diff($request->getParams(), 
            $request->getUserParams());
            $format = $this->_getParam('format', 'html');
            $qualification_name = $params['myarray']['qualification_name'];
            $qualification_model = new Acad_Model_Qualification();
            $qualifications = $qualification_model->fetchQualifications();
            $qualification_id = array_search($qualification_name, 
            $qualifications);
            $save_data = $params['myarray']['qualification_data'];
            Zend_Registry::get('logger')->debug($save_data);
            $student_model = new Acad_Model_Member_Student();
            $student_model->setMember_id($this->getMember_id());
            $student_model->saveQualificationInfo($qualification_id, $save_data);
            $success = true;
            switch ($format) {
                case 'html':
              
                    if (! empty($success)) {
                        $this->view->assign('is_successfull', $success);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' . $this->_helper->json($success, false) .
                     ')';
                    break;
                case 'json':
                    $this->_helper->json($success);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($success);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function saveleetinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $save_data = $params['myarray']['exam_data'];
        $exam_name = 'LEET';
        $success = self::saveExamInfo($exam_name, $save_data);
        switch ($format) {
            case 'html':
                if (! empty($success)) {
                    $this->view->assign('is_successfull', $success);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($success, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($success);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($success);
                break;
            default:
                ;
                break;
        }
    }
    public function saveaieeeinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $save_data = $params['myarray']['exam_data'];
        $exam_name = 'AIEEE';
        $success = self::saveExamInfo($exam_name, $save_data);
        switch ($format) {
            case 'html':
                if (! empty($success)) {
                    $this->view->assign('is_successfull', $success);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($success, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($success);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($success);
                break;
            default:
                ;
                break;
        }
    }
    private function saveExamInfo ($exam_name, $save_data)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $exam_model = new Acad_Model_CompetitiveExam();
        $exams = $exam_model->fetchExams();
        $exam_id = array_search($exam_name, $exams);
        $save_data['exam_id'] = $exam_id;
        $student_model->saveCompetitiveExamInfo($save_data);
        return true;
    }
    public function savegateinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $save_data = $params['myarray']['exam_data'];
        $exam_name = 'GATE';
        $success = self::saveExamInfo($exam_name, $save_data);
        switch ($format) {
            case 'html':
                if (! empty($success)) {
                    $this->view->assign('is_successfull', $success);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($success, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($success);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($success);
                break;
            default:
                ;
                break;
        }
    }
    public function createprofileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function editmatricinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_name = 'MATRIC';
        $qualification_model = new Acad_Model_Qualification();
        $qualifications = $qualification_model->fetchQualifications();
        $student_qualification_ids_array = $student_model->fetchQualificationsIds();
        $student_qualification_ids = array_flip(
        $student_qualification_ids_array);
        $student_qualifications = array_intersect_key($qualifications, 
        $student_qualification_ids);
        $qualification_id = array_search($qualification_name, 
        $student_qualifications);
        if ($qualification_id) {
            $student_model = new Acad_Model_Member_Student();
            $qualification_data = self::fetchMatricData($qualification_id);
            Zend_Registry::get('logger')->debug($qualification_data);
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($qualification_data)) {
                        $this->view->assign('qualification_data', 
                        $qualification_data);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' .
                     $this->_helper->json($qualification_data, false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($qualification_data);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($qualification_data);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function edittwelfthinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_name = 'TWELFTH';
        $qualification_model = new Acad_Model_Qualification();
        $qualifications = $qualification_model->fetchQualifications();
        $student_qualification_ids_array = $student_model->fetchQualificationsIds();
        $student_qualification_ids = array_flip(
        $student_qualification_ids_array);
        $student_qualifications = array_intersect_key($qualifications, 
        $student_qualification_ids);
        $qualification_id = array_search($qualification_name, 
        $student_qualifications);
        if ($qualification_id) {
            $student_model = new Acad_Model_Member_Student();
            $qualification_data = self::fetchTwelfthData($qualification_id);
            Zend_Registry::get('logger')->debug($qualification_data);
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($qualification_data)) {
                        $this->view->assign('qualification_data', 
                        $qualification_data);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' .
                     $this->_helper->json($qualification_data, false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($qualification_data);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($qualification_data);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function editbtechinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_name = 'BTECH';
        $qualification_model = new Acad_Model_Qualification();
        $qualifications = $qualification_model->fetchQualifications();
        $student_qualification_ids_array = $student_model->fetchQualificationsIds();
        $student_qualification_ids = array_flip(
        $student_qualification_ids_array);
        $student_qualifications = array_intersect_key($qualifications, 
        $student_qualification_ids);
        $qualification_id = array_search($qualification_name, 
        $student_qualifications);
        if ($qualification_id) {
            $student_model = new Acad_Model_Member_Student();
            $qualification_data = self::fetchBtechData($qualification_id);
            Zend_Registry::get('logger')->debug($qualification_data);
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($qualification_data)) {
                        $this->view->assign('qualification_data', 
                        $qualification_data);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' .
                     $this->_helper->json($qualification_data, false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($qualification_data);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($qualification_data);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function editdiplomainfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_name = 'DIPLOMA';
        $qualification_model = new Acad_Model_Qualification();
        $qualifications = $qualification_model->fetchQualifications();
        $student_qualification_ids_array = $student_model->fetchQualificationsIds();
        $student_qualification_ids = array_flip(
        $student_qualification_ids_array);
        $student_qualifications = array_intersect_key($qualifications, 
        $student_qualification_ids);
        $qualification_id = array_search($qualification_name, 
        $student_qualifications);
        if ($qualification_id) {
            $student_model = new Acad_Model_Member_Student();
            $qualification_data = self::fetchDiplomaData($qualification_id);
            Zend_Registry::get('logger')->debug($qualification_data);
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($qualification_data)) {
                        $this->view->assign('qualification_data', 
                        $qualification_data);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' .
                     $this->_helper->json($qualification_data, false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($qualification_data);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($qualification_data);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function editaieeeinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $exam_name = 'AIEEE';
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $exam_ids = $student_model->fetchCompetitveExamIds();
        if (! empty($exam_ids)) {
            $exam_id = array_search($exam_name, $exam_ids);
            Zend_Registry::get('logger')->debug($exam_ids);
            if ($exam_id) {
                $exam_data = self::fetchCompetitiveExamData($exam_id);
                switch ($format) {
                    case 'html':
                        if (! empty($exam_data)) {
                            $this->view->assign('exam_data', $exam_data);
                        }
                        break;
                    case 'jsonp':
                        $callback = $this->getRequest()->getParam('callback');
                        echo $callback . '(' .
                         $this->_helper->json($exam_data, false) . ')';
                        break;
                    case 'json':
                        $this->_helper->json($exam_data);
                        break;
                    case 'test':
                        Zend_Registry::get('logger')->debug($exam_data);
                        break;
                    default:
                        ;
                        break;
                }
            }
        }
    }
    public function editleetinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $exam_name = 'AIEEE';
        $exam_model = new Acad_Model_CompetitiveExam();
        $exams = $exam_model->fetchExams();
        $exam_id = array_search($exam_name, $exams);
        if ($exam_id) {
            $student_model = new Acad_Model_Member_Student();
            $qualification_data = self::fetchCompetitiveExamData($exam_id);
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($qualification_data)) {
                        $this->view->assign('qualification_data', 
                        $qualification_data);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' .
                     $this->_helper->json($qualification_data, false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($qualification_data);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($qualification_data);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function editgateinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $exam_name = 'AIEEE';
        $exam_model = new Acad_Model_CompetitiveExam();
        $exams = $exam_model->fetchExams();
        $exam_id = array_search($exam_name, $exams);
        if ($exam_id) {
            $student_model = new Acad_Model_Member_Student();
            $qualification_data = self::fetchCompetitiveExamData($exam_id);
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($qualification_data)) {
                        $this->view->assign('qualification_data', 
                        $qualification_data);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' .
                     $this->_helper->json($qualification_data, false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($qualification_data);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($qualification_data);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    /**
     * 
     * only to render view of 
     */
    public function createdmcAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function viewdmcAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $response = self::fetchclassdmc($params['class_id'], 
        $params['dmc_view_type'], $params['dmc_info_id']);
        switch ($format) {
            case 'html':
                if (! empty($response)) {
                    $this->view->assign('response', $response);
                    Zend_Registry::get('logger')->debug($response);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($response, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($response);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($response);
                break;
            default:
                ;
                break;
        }
    }
    public function editdmcAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        if($params['dmc_info_id'])
        {
        $response = self::fetchclassdmc($params['class_id'], 
        $this->_getParam('dmc_view_type','latest'),$params['dmc_info_id']);
        }
        else {
             $response = self::fetchclassdmc($params['class_id'], 
        $params['dmc_view_type']);
        }
        switch ($format) {
            case 'html':
                if (! empty($response)) {
                    $this->view->assign('response', $response);
                    Zend_Registry::get('logger')->debug($response);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($response, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($response);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($response);
                break;
            default:
                ;
                break;
        }
    }
    public function savedmcAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $dmc_data_array = $params['myarray'];
        $dmc_data_array['subject_ids'] = array_keys($input)
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        foreach ($dmc_data_array as $dmc_data) {
            $student_model->saveDmcMarks($dmc_data);
        }
    }
    public function savedmcinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $dmc_info = $params['myarray'];
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $dmc_info_id = $student_model->saveDmcInfo($dmc_info);
         Zend_Registry::get('logger')->debug($dmc_info_id);
        switch ($format) {
            case 'html':
                if (! empty($dmc_info_id)) {
                    $this->view->assign('dmc_info_id', $dmc_info_id);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($dmc_info_id, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($dmc_info_id);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($dmc_info_id);
                break;
            default:
                ;
                break;
        }
    }
    public function fetchsubjectdmcAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $subject_id = $params['subject_id'];
        $dmc_info_id = $params['dmc_info_id'];
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $dmc_data = self::fetchsubjectDmc($dmc_info_id, $subject_id);
        switch ($format) {
            case 'html':
                if (! empty($dmc_data)) {
                    $this->view->assign('response', $dmc_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($dmc_data, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($dmc_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($dmc_data);
                break;
            default:
                ;
                break;
        }
    }
    public function testingAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $inner_array = array();
        $info = array();
        $class_ids = array();
        $class_semester = array();
        $class_dmc_info_ids = array();
        $dmc_dispatch_dates = array();
        $student = new Acad_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $class_ids = $student->fetchAllClassIds();
        $class = new Acad_Model_Class();
        foreach ($class_ids as $class_id) {
            //for unsetting object properties
            //$class->initsave();
            $class->setClass_id($class_id);
            $class->fetchInfo();
            $semester_id = $class->getSemester_id();
            $class_semester[$class_id] = $semester_id;
        }
        foreach ($class_semester as $class_idA => $sem) {
            $dmc_info_ids = array();
            $dmc_info_ids = $student->fetchDmcInfoIds($class_idA);
            $class_dmc_info_ids[$class_idA] = $dmc_info_ids;
        }
        $dmc_dispatch_dates = $student->fetchDmcInfoIdsByDate(true);
        foreach ($class_dmc_info_ids as $class_idB => $dmc_info_id_array) {
            $semester_idA = $class_semester[$class_idB];
            $inner_array[$semester_idA] = '';
            foreach ($dmc_info_id_array as $dmc_info_id => $dmc_id) {
                $inner_array[$semester_idA][$dmc_info_id]['class_id'] = $class_idB;
                $inner_array[$semester_idA][$dmc_info_id]['dmc_id'] = $dmc_id;
                $inner_array[$semester_idA][$dmc_info_id]['dispatch_date'] = $dmc_dispatch_dates[$dmc_info_id];
            }
        }
        Zend_Registry::get('logger')->debug($inner_array);
    }
}
