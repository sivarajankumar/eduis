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
    protected $_member_id = 3;
    /**
     * The default action - show the home page
     */
    public function init ()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $authInfo = Zend_Auth::getInstance()->getStorage()->read();
            $this->department_id = $authInfo['department_id'];
            $this->identity = $authInfo['identity'];
            $this->setMember_id($authInfo['member_id']);
        }
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
    {}
    public function memberidcheckAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $member_id_to_check = $this->getMember_id();
        $member_id_exists = $this->memberIdCheck($member_id_to_check);
        $this->_helper->json($member_id_exists);
    }
    public function fetchcriticalinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        $member_id = $this->getMember_id();
        $critical_data = self::fetchcriticalinfo($member_id);
        $this->_helper->json($critical_data);
    }
    public function fetchsubjectsAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request_object = $this->getRequest();
        $params = array_diff($request_object->getParams(), 
        $request_object->getUserParams());
        ($class_id = $params['myarray']['class_id']) ||
         ($class_id = $params['class_id']);
        Zend_Registry::get('logger')->debug($class_id);
        $student_subjects = $this->fetchStudentSubjects($class_id);
        $response['subject_info'] = $student_subjects;
        Zend_Registry::get('logger')->debug($response);
        $format = $this->_getParam('format', 'html');
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('response', $response);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($response, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($response);
                break;
            default:
                ;
                break;
        }
    }
    public function registerAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $student_model = new Acad_Model_Member_Student();
        $member_id_to_check = $this->getMember_id();
        $member_exists_in_acad = $this->memberIdCheck($member_id_to_check);
        /*
         * dont use this if statement because user may have updated the data in core
         * and the old data may still exist in academics database .thus in the case
         * of old data member_id still exists that is member_id_check will return true.
         * so drop the if statement
         */
        //if ($member_exists_in_acad == false) {
        $client = new Zend_Http_Client();
        $client->setUri('http://' . CORE_SERVER . '/student/fetchpersonalinfo');
        $client->setCookie('PHPSESSID', $_COOKIE['PHPSESSID']);
        $response = $client->request();
        if ($response->isError()) {
            $remoteWARN = 'REMOTE WARNOR: (' . $response->getStatus() . ') ' .
             $response->getMessage() . $response->getBody();
            throw new Zend_Exception($remoteWARN, Zend_Log::WARN);
        }
        //$critical_data = Zend_Json::decode($response->getBody());
        Zend_Registry::get('logger')->debug($response);
         //Zend_Registry::get('logger')->debug($critical_data);
    /*if ($critical_data) {
            $student_model->saveCriticalInfo($critical_data);
        } else {
            $msg = 'PLEASE REGISTER IN CORE MODULE....GOTO core.aceambala.com';
            throw new Exception('$msg');
        }*/
    //}
    // $this->_redirect('student/profile');
    }
    public function createprofileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
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
                break;
            default:
                ;
                break;
        }
    }
    public function viewmtechinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_data = self::fetchMtechData();
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($qualification_data)) {
                    $this->view->assign('mtech', $qualification_data);
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
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $exam_name = 'LEET';
        $exam_model = new Acad_Model_CompetitiveExam();
        $exams = $exam_model->fetchExams();
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
                break;
            default:
                ;
                break;
        }
    }
    public function savebtechinfoAction ()
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
                break;
            default:
                ;
                break;
        }
    }
    public function savemtechinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $qualification_id = $this->fetchQualificationId('MTECH');
        $save_data = $params['myarray']['qualification_data'];
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
                break;
            default:
                ;
                break;
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
                break;
            default:
                ;
                break;
        }
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
                break;
            default:
                ;
                break;
        }
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
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function editmtechinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_data = self::fetchMtechData();
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
                break;
            default:
                ;
                break;
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
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $exam_name = 'AIEEE';
        $exams_names = $this->getCompetitiveExams();
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $exam_ids = $student_model->fetchCompetitveExamIds();
        if (! empty($exam_ids)) {
            $exam_id = array_search($exam_name, $exams_names);
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
        $exam_name = 'GATE';
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
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function createdmcAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function fetchacademicinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format');
        /* --------------------------------------------------------------------------- */
        /*
         * All Class ids of student
         */
        $student_class_ids = $this->getAllClassIds();
        $class = new Acad_Model_Class();
        /* --------------------------------------------------------------------------- */
        /*
         * Class_info for all batches to which the student belongs student
         */
        $all_class_batch = array();
        $httpClient = new Zend_Http_Client();
        $httpClient->setUri('http://' . ACADEMIC_SERVER . '/class/getclassinfo');
        $httpClient->setMethod('POST');
        foreach ($student_class_ids as $class_id) {
            $httpClient->setParameterPost(
            array('class_id' => $class_id, 'format' => 'json'));
            $response = $httpClient->request();
            if ($response->isError()) {
                $class_info = false;
                $error = 'ERROR: (' . $response->getStatus() . ') ' .
                 $response->getHeader('Message') . $response->getBody();
                throw new Zend_Exception($error, Zend_Log::ERR);
            } else {
                $jsonContent = $response->getBody($response);
                $class_info = Zend_Json::decode($jsonContent);
                $all_class_batch[$class_id] = $class_info['class_info']['batch_id'];
                $r[$class_id][] = $class_info['class_info']['semester_id'];
            }
        }
        /*echo "<pre>";
        print_r($r);
        echo "</pre>";*/
        $student_batches = array();
        $student_batches = array_unique($all_class_batch);
        /* --------------------------------------------------------------------------- */
        /*
         * dep prog batch_start of student
         */
        $batch_info = array();
        $batch_sems = array();
        $batch_class_ids = array();
        $httpClient->setUri('http://' . ACADEMIC_SERVER . '/batch/getbatchinfo');
        foreach ($student_batches as $classid => $bath_id) {
            $class->setBatch_id($bath_id);
            $temp = $class->fetchClassIds(true);
            foreach ($temp as $key => $clss_id) {
                if (array_search($clss_id, $student_class_ids)) {} else {
                    unset($temp[$key]);
                }
            }
            $temp = array_flip($temp);
            $class_semesters = array();
            foreach ($temp as $id => $junk_key) {
                $class->setClass_id($id);
                $classinfo = $class->fetchInfo();
                if ($classinfo instanceof Acad_Model_Class) {
                    $sem_id = $classinfo->getSemester_id();
                    $class_semesters[$id] = $sem_id;
                }
            }
            $batch_info[$bath_id]['class_ids'] = $class_semesters;
            $httpClient->setParameterPost(
            array('batch_id' => $bath_id, 'format' => 'json'));
            $response = $httpClient->request();
            if ($response->isError()) {
                $class_info = false;
                $error = 'ERROR: (' . $response->getStatus() . ') ' .
                 $response->getHeader('Message') . $response->getBody();
                throw new Zend_Exception($error, Zend_Log::ERR);
            } else {
                $jsonContent = $response->getBody($response);
                $info = Zend_Json::decode($jsonContent);
                $batch_info[$bath_id]['batch_info'] = $info['batch_info'];
            }
        }
        /* --------------------------------------------------------------------------- */
        /*
         * roll num, group of  student
         */
        $stu_cl_inf = array();
        foreach ($student_batches as $classid => $batch_id) {
            $stu_cl_inf[$classid] = $this->getClassInfo($classid);
        }
        $response = array();
        $response['student_class_info'] = $stu_cl_inf;
        $response['batch_display'] = $batch_info;
        switch ($format) {
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($response, false) .
                 ')';
                break;
            case 'json':
                /*echo "<pre>";
                print_r($response);
                echo "</pre>";
                Zend_Registry::get('logger')->debug($response);*/
                $this->_helper->json($response);
                break;
            default:
                ;
                break;
        }
    }
    public function viewdmcAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $dmc_info_id = $params['dmc_info_id'];
        $response = self::fetchclassdmc($dmc_info_id);
        switch ($format) {
            case 'html':
                if (! empty($response)) {
                    $this->view->assign('response', $response);
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
        if (! $params['dmc_info_id']) {
            $response = self::fetchclassdmc($params['class_id'], 
            $params['dmc_view_type']);
        } else {
            $response = self::fetchclassdmc($params['class_id'], 
            $this->_getParam('dmc_view_type', 'latest'), $params['dmc_info_id']);
        }
        switch ($format) {
            case 'html':
                if (! empty($response)) {
                    $this->view->assign('response', $response);
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
                break;
            default:
                ;
                break;
        }
    }
    public function savedmcAction ()
    {
        $dmc_data_array = array();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $dmc_info = $params['myarray']['dmc_data'];
        $dmc_data_array = $params['myarray']['dmc_info_data'];
        $dmc_id = $dmc_info['dmc_id'];
        $class_id = $dmc_info['class_id'];
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $dmc_info_id = $student_model->saveDmcInfo($dmc_info);
        /*$dmc_data_value = array_values($dmc_data_array);
        $subject_ids = array_keys($dmc_data_array);
        $student_subject_model = new Acad_Model_StudentSubject();
        $student_subject_model->setMember_id($this->getMember_id());
        $student_subject_model->setClass_id($class_id);
        $student_subject_id = array();
        foreach ($dmc_data_array as $subject_id => $data_array) {
            $student_subject_model->setSubject_id($subject_id);
            $student_subject_id = $student_subject_model->fetchStudentSubjectId();
            $data_array['student_subject_id'] = $student_subject_id['student_subject_id'];
            $data_array['dmc_info_id'] = $dmc_info_id;
            $dmc_data_array[$subject_id] = $data_array;
        }
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        foreach ($dmc_data_array as $dmc_data) {
            $student_model->saveDmcMarks($dmc_data);
        }*/
    }
    public function fetchdmcinfoidsAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request_object = $this->getRequest();
        $params = array_diff($request_object->getParams(), 
        $request_object->getUserParams());
        Zend_Registry::get('logger')->debug('Parameter recieved from view :');
        Zend_Registry::get('logger')->debug($params);
        $member_id = $this->getMember_id();
        $class_id = $params['class_id'];
        $student_class_ids = $this->getAllClassIds();
        Zend_Registry::get('logger')->debug('Student_class_ids : ');
        Zend_Registry::get('logger')->debug($student_class_ids);
        $class_enroll_check = array_keys($student_class_ids, $class_id);
        if (! empty($class_enroll_check)) {
            $response['class_info']['class_id'] = $class_id;
            $format = $this->_getParam('format', 'html');
            $dmc_info_ids = $this->fetchAllDmcInfoIds($class_id);
            foreach ($dmc_info_ids as $dmc_info_id => $dmc_id) {
                $response['dmc_info'][$dmc_info_id] = $dmc_id;
            }
            Zend_Registry::get('logger')->debug('Response : ');
            Zend_Registry::get('logger')->debug($response);
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    $this->view->assign('response', $response);
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' . $this->_helper->json($response, 
                    false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($response);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function viewdmcinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function editdmcinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $member_id = $this->getMember_id();
        $class_ids = $this->getAllClassIds();
        if (empty($class_ids)) {
            $this->view->assign('class_info', false);
        } else {
            $class_info = array();
            foreach ($class_ids as $class_id) {
                $info = $this->getClassInfo($class_id);
                foreach ($info as $class_id => $semester_id) {
                    $class_info[$class_id] = $semester_id;
                }
            }
            $this->view->assign('class_info', $class_info);
        }
    }
    public function savedmcinfoAction ()
    {
        $dmc_data_array = array();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $dmc_info = $params['myarray']['dmc_info'];
        $class_id = null;
        if (empty($params['myarray']['class_finder'])) {
            if (empty($dmc_info['class_id'])) {
                throw new Exception(
                'Class_Id is required to save Dmc Information.None provided', 
                Zend_Log::WARN);
            } else {
                $this->saveDmcInfo($dmc_info);
                Zend_Registry::get('logger')->debug('DMC information saved : ');
                Zend_Registry::get('logger')->debug($dmc_info);
            }
        } else {
            $class_finder = $params['myarray']['class_finder'];
            $batch_start = $class_finder['batch_start'];
            $programme_id = $class_finder['programme_id'];
            $department_id = $class_finder['department_id'];
            $semester_id = $class_finder['semester_id'];
            $batch_ids = $this->getBatchIds($batch_start, $department_id, 
            $programme_id);
            $batch_id = $batch_ids[0];
            $class_ids = $this->getClassIds($batch_id, $semester_id);
            $class_id = $class_ids[0];
            $dmc_info['class_id'] = $class_id;
            $this->saveDmcInfo($dmc_info);
            Zend_Registry::get('logger')->debug('DMC information saved : ');
            Zend_Registry::get('logger')->debug($dmc_info);
        }
    }
    public function viewdmcsubjectmarksAction ()
    {}
    public function editdmcsubjectmarksAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function savedmcsubjectmarksAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        Zend_Registry::get('logger')->debug($params);
        $subject_marks_info = $params['myarray']['subject_marks_info'];
        $dmc_info = $params['myarray']['dmc_info'];
        $dmc_info_id = $dmc_info['dmc_info_id'];
        foreach ($subject_marks_info as $stu_sub_id => $dmc_subject_marks) {
            $dmc_subject_marks['dmc_info_id'] = $dmc_info_id;
            $dmc_subject_marks['student_subject_id'] = $stu_sub_id;
            $this->savedmcsubjectmarks($dmc_subject_marks);
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
        $dmc_data = self::fetchDmcSubjectMarks($dmc_info_id, $subject_id);
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
                break;
            default:
                ;
                break;
        }
    }
    public function aclconfigAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $methods = get_class_methods('StudentController');
        $actions = array();
        foreach ($methods as $value) {
            $actions[] = substr("$value", 0, strpos($value, 'Action'));
        }
        foreach ($actions as $key => $value) {
            if ($value == null) {
                unset($actions[$key]);
            }
        }
        $db = new Zend_Db_Table();
        $delete2 = 'DELETE FROM `academics`.`mod_role_resource` WHERE `module_id`=? AND `controller_id`=?';
        $db->getAdapter()->query($delete2, array('academic', 'student'));
        $delete1 = 'DELETE FROM `academics`.`mod_action` WHERE `module_id`=? AND `controller_id`=?';
        $db->getAdapter()->query($delete1, array('academic', 'student'));
        print_r(sizeof($actions));
        $sql = 'INSERT INTO `academics`.`mod_action`(`module_id`,`controller_id`,`action_id`) VALUES (?,?,?)';
        foreach ($actions as $action) {
            $bind = array('academic', 'student', $action);
            $db->getAdapter()->query($sql, $bind);
        }
        $sql = 'INSERT INTO `academics`.`mod_role_resource`(`role_id`,`module_id`,`controller_id`,`action_id`) VALUES (?,?,?,?)';
        foreach ($actions as $action) {
            $bind = array('student', 'academic', 'student', $action);
            $db->getAdapter()->query($sql, $bind);
        }
        /*foreach ($actions as $action) {
            echo '<pre>';
            print_r($action);
            echo '</pre>';
        }*/
        Zend_Registry::get('logger')->debug($actions);
    }
    /**
     * Checks if member is registered in the core,
     * @return true if member_id is registered, false otherwise
     */
    private function memberIdCheck ($member_id_to_check)
    {
        $student = new Acad_Model_Member_Student();
        $student->setMember_id($member_id_to_check);
        $member_id_exists = $student->memberIdCheck();
        if (! $member_id_exists) {
            Zend_Registry::get('logger')->debug(
            'Member with member_id : ' . $member_id_to_check .
             ' is not registered in CORE');
        }
        return $member_id_exists;
    }
    /**
     * before calling this function use memberidcheck function
     * Enter description here ...
     * @param int $member_id
     */
    private function fetchcriticalinfo ($member_id)
    {
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $student = new Acad_Model_Member_Student();
            $student->setMember_id($member_id);
            $student_model = $student->fetchCriticalInfo();
            if ($student_model instanceof Acad_Model_Member_Student) {
                $critical_data['member_id'] = $this->getMember_id();
                $critical_data['first_name'] = $student_model->getFirst_name();
                $critical_data['middle_name'] = $student_model->getMiddle_name();
                $critical_data['last_name'] = $student_model->getLast_name();
                $critical_data['cast'] = $student_model->getCast_name();
                $critical_data['nationality'] = $student_model->getNationality_name();
                $critical_data['religion'] = $student_model->getReligion_name();
                $critical_data['blood_group'] = $student_model->getBlood_group();
                $critical_data['dob'] = $student_model->getDob();
                $critical_data['gender'] = $student_model->getGender();
                $critical_data['member_type_id'] = $student_model->getMember_type_id();
                $critical_data['religion_id'] = $student_model->getReligion_id();
                $critical_data['nationality_id'] = $student_model->getNationality_id();
                $critical_data['cast_id'] = $student_model->getCast_id();
                return $critical_data;
            }
        }
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
    /**
     * returns btech data of student
     * Enter description here ...
     * @param int qualification_id 
     * @todo no need of qualification id.. must work only for btech.. get id from model 
     * @return array $btech return array of present data of student in qualification table
     *
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
            $btech_data['institution'] = $qualification_model->getInstitution();
            $btech_data['roll_no'] = $qualification_model->getRoll_no();
             // $btech_data['unv_regn_no'] = $qualification_model->getUniversityRegisrtationNo();
        }
        return $btech_data;
    }
    /**
     * returns mtech data of student
     * Enter description here ...
     * @param int qualification_id 
     * @return array $mtech return array of present data of student in qualification table
     *
     */
    private function fetchMtechData ()
    {
        $qualification_id = $this->fetchQualificationId('MTECH');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification = $student_model->fetchQualificationInfo(
        $qualification_id);
        $mtech_data = array();
        if ($qualification instanceof Acad_Model_Qualification_Mtech) {
            $mtech_data['university'] = $qualification->getUniversity();
            $mtech_data['city_name'] = $qualification->getCity_name();
            $mtech_data['marks_obtained'] = $qualification->getMarks_obtained();
            $mtech_data['passing_year'] = $qualification->getPassing_year();
            $mtech_data['percentage'] = $qualification->getPercentage();
            $mtech_data['state_name'] = $qualification->getState_name();
            $mtech_data['total_marks'] = $qualification->getTotal_marks();
            $mtech_data['discipline_id'] = $qualification->getDiscipline_id();
            $mtech_data['institution'] = $qualification->getInstitution();
            $mtech_data['roll_no'] = $qualification->getRoll_no();
        }
        return $mtech_data;
    }
    private function fetchQualificationId ($qualification_name)
    {
        $qualification_model = new Acad_Model_Qualification();
        $qualifications = $qualification_model->fetchQualifications();
        if ($qualifications == false) {
            throw new Exception('Qualifications table is empty', Zend_Log::WARN);
        }
        $qualifications = array_flip($qualifications);
        if (empty($qualifications[$qualification_name])) {
            throw new Exception(
            'Qualifications with name : ' . $qualification_name .
             ' not in database', Zend_Log::WARN);
        } else {
            return $qualifications[$qualification_name];
        }
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
            $exam_data['all_india_rank'] = $student_exam_model->getAll_india_rank();
            $exam_data['roll_no'] = $student_exam_model->getRoll_no();
            $exam_data['date'] = $student_exam_model->getDate();
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
            $dmc_info = self::getDmcInfo($specific_dmc_info_id);
            return $dmc_info;
        }
        if ($class_specific) {
            $dmc_info_ids = $student_model->fetchDmcInfoIds(true, null, null, 
            null, null);
            $dmc_info = self::getDmcInfo($dmc_info_ids);
            return $dmc_info;
        }
        if ($result_type_specific) {
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, true, null, 
            null, true);
            $dmc_info = self::getDmcInfo($dmc_info_ids);
            return $dmc_info;
        }
        if ($all) {
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, null, true, 
            null, null);
            $dmc_info = self::getDmcInfo($dmc_info_ids);
            return $dmc_info;
        }
        if ($considered_only) {
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, null, null, 
            true, null);
            $dmc_info = self::getDmcInfo($dmc_info_ids);
            return $dmc_info;
        }
        if ($ordered_by_date) {
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, null, null, 
            null, true);
            $dmc_info = self::getDmcInfo($dmc_info_ids);
            return $dmc_info;
        }
    }
    private function getDmcInfo ($dmc_info_ids)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        if (is_array($dmc_info_ids) and ! empty($dmc_info_ids)) {
            $dmc_info_data = array();
            foreach ($dmc_info_ids as $dmc_info_id => $dmc_id) {
                $dmc_info_data[$dmc_info_id] = $this->createDmcInfoArray(
                $dmc_info_id);
            }
        } else {
            $dmc_info_data[$dmc_info_ids] = $this->createDmcInfoArray(
            $dmc_info_ids);
        }
        return $dmc_info_data;
    }
    private function createDmcInfoArray ($dmc_info_id)
    {
        $student = new Acad_Model_Member_Student();
        $dmc_info = $student->fetchDmcInfo($dmc_info_id);
        if ($dmc_info instanceof Acad_Model_Course_DmcInfo) {
            $info['dmc_id'] = $dmc_info->getDmc_id();
            $info['class_id'] = $dmc_info->getClass_id();
            $info['result_type_id'] = $dmc_info->getResult_type_id();
            $info['is_considered'] = $dmc_info->getIs_considered();
            $info['examination'] = $dmc_info->getExamination();
            $info['custody_date'] = $dmc_info->getCustody_date();
            $info['is_granted'] = $dmc_info->getIs_granted();
            $info['grant_date'] = $dmc_info->getGrant_date();
            $info['is_copied'] = $dmc_info->getIs_copied();
            $info['dispatch_date'] = $dmc_info->getDispatch_date();
            $info['marks_obtained'] = $dmc_info->getMarks_obtained();
            $info['total_marks'] = $dmc_info->getTotal_marks();
            $info['scaled_marks'] = $dmc_info->getScaled_marks();
            $info['percentage'] = $dmc_info->getPercentage();
            return $info;
        } else {
            throw new Exception('Dmc_info does not exist', Zend_Log::WARN);
        }
    }
    private function fetchDmcSubjectMarks ($dmc_info_id, $subject_ids)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $dmc_subject_marks = array();
        if (is_array($subject_ids)) {
            foreach ($subject_ids as $key => $subject_id) {
                $dmc_subject_marks[$subject_id] = $this->getDmcSubjectMarks(
                $dmc_info_id, $subject_id);
            }
        } else {
            $dmc_subject_marks = $this->getDmcSubjectMarks($dmc_info_id, 
            $subject_id);
        }
        return $dmc_subject_marks;
    }
    private function getDmcSubjectMarks ($dmc_info_id, $subject_id)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $info = $student_model->fetchDmc($dmc_info_id, $subject_id);
        if ($info instanceof Acad_Model_Course_DmcMarks) {
            $info->setStudent_subject_id($subject_id);
            $dmc_subject_marks = array();
            $dmc_subject_marks['date'] = $info->getDate();
            $dmc_subject_marks['external'] = $info->getExternal();
            $dmc_subject_marks['internal'] = $info->getInternal();
            $dmc_subject_marks['percentage'] = $info->getPercentage();
            $dmc_subject_marks['is_pass'] = $info->getIs_pass();
            $dmc_subject_marks['date'] = $info->getDate();
            return $dmc_subject_marks;
        } elseif ($info == false) {
            throw new Exception(
            'Subject Marks were not submitted for dmc_info_id : ' . $dmc_info_id .
             ' and subject_id : ' . $subject_id, Zend_Log::WARN);
        }
    }
    private function fetchStudentSubjects ($class_id)
    {
        $member_id = $this->getMember_id();
        $student = new Acad_Model_Member_Student();
        $student->setMember_id($member_id);
        $student_subject_ids = $student->fetchClassSubjects($class_id);
        if (empty($student_subject_ids)) {
            throw new Exception(
            'No Subjects reported for Member_id : ' . $member_id, Zend_Log::WARN);
        }
        $subject_data = array();
        foreach ($student_subject_ids as $student_subject_id => $subject_id) {
            $info = $this->fetchSubjectInfo($subject_id);
            if ($info == false) {
                throw new Exception(
                'Subjects details for subject_id : ' . $subject_id .
                 ' does not exist', Zend_Log::WARN);
            } else {
                $subject_data[$student_subject_id]['name'] = $info['name'];
                $subject_data[$student_subject_id]['code'] = $info['code'];
            }
        }
        return $subject_data;
    }
    private function fetchSubjectInfo ($subject_id)
    {
        $subject = new Acad_Model_Subject();
        $subject->setSubject_id($subject_id);
        $info = $subject->fetchInfo();
        if ($info == false) {
            $subject_info = false;
        } elseif ($info instanceof Acad_Model_Subject) {
            $subject_info = array();
            $subject_info['name'] = $subject->getSubject_name();
            $subject_info['code'] = $subject->getSubject_code();
        }
        return $subject_info;
    }
    private function savedmcsubjectmarks ($marks_info)
    {
        $member_id = $this->getMember_id();
        $student = new Acad_Model_Member_Student();
        $student->setMember_id($member_id);
        $dmc_subject_marks['dmc_info_id'] = $marks_info['dmc_info_id'];
        $dmc_subject_marks['student_subject_id'] = $marks_info['student_subject_id'];
        $dmc_subject_marks['external'] = $marks_info['external'];
        $dmc_subject_marks['internal'] = $marks_info['internal'];
        $dmc_subject_marks['percentage'] = $marks_info['percentage'];
        $dmc_subject_marks['is_pass'] = $marks_info['is_pass'];
        $dmc_subject_marks['is_verified'] = $marks_info['is_verified'];
        $dmc_subject_marks['date'] = $marks_info['date'];
        return $student->saveDmcMarks($dmc_subject_marks);
    }
    private function fetchAllDmcInfoIds ($class_id)
    {
        $member_id = $this->getMember_id();
        $student = new Acad_Model_Member_Student();
        $student->setMember_id($member_id);
        $dmc_info_ids = $student->fetchDmcInfoIds($class_id);
        if (is_array($dmc_info_ids)) {
            Zend_Registry::get('logger')->debug('Dmc_info_ids : ');
            Zend_Registry::get('logger')->debug($dmc_info_ids);
            return $dmc_info_ids;
        } else {
            if ($dmc_info_ids == false) {
                throw new Exception(
                'Student with member_id : ' . $member_id .
                 ' has no DMC information in database ', Zend_Log::WARN);
            }
        }
    }
    private function fetchclassdmc ($dmc_info_id)
    {
        $subject_data = array();
        $dmc_info_raw = array();
        $dmc_info_raw = self::fetchDmcInfo($dmc_info_id);
        $student_subject = new Acad_Model_StudentSubject();
        $student_subject->setMember_id($this->getMember_id());
        $dmc_info_data = array_pop($dmc_info_raw);
        $class_id = $dmc_info_data['class_id'];
        $student_subject->setClass_id($class_id);
        $student_subject_ids = $student_subject->fetchSubjects();
        $dmc_subject_data = self::fetchDmcSubjectMarks($dmc_info_id, 
        $student_subject_ids);
        $subject_data = $this->fetchStudentSubjects($class_id);
        $response = array('dmc_info_data' => $dmc_info_data, 
        'dmc_data' => $dmc_subject_data, 'subject_data' => $subject_data);
        Zend_Registry::get('logger')->debug($response);
        return $response;
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
    private function getCompetitiveExams ()
    {
        $exams = new Acad_Model_CompetitiveExam();
        return $exams->fetchExams();
    }
    /**
     * gets the class information of student
     * Enter description here ...
     * @param int $class_id
     */
    private function getClassInfo ($class_id)
    {
        $member_id = $this->getMember_id();
        $student = new Acad_Model_Member_Student();
        $student->setMember_id($member_id);
        $info = $student->fetchClassInfo($class_id);
        if ($info instanceof Acad_Model_StudentClass) {
            array('member_id', 'class_id', 'group_id', 'roll_no', 'start_date', 
            'completion_date', 'is_initial_batch_identifier');
            $class_info = array();
            $class_info['group_id'] = $info->getGroup_id();
            $class_info['roll_no'] = $info->getRoll_no();
            $class_info['start_date'] = $info->getStart_date();
            $class_info['completion_date'] = $info->getCompletion_date();
            $class_info['is_initial_batch_identifier'] = $info->getIs_initial_batch_identifier();
            return $class_info;
        } else {
            return flase;
        }
    }
    private function getActiveClassIds ()
    {
        $member_id = $this->getMember_id();
        $student = new Acad_Model_Member_Student();
        $student->setMember_id($member_id);
        return $student->fetchActiveClassIds();
    }
    private function getAllClassIds ()
    {
        $member_id = $this->getMember_id();
        $student = new Acad_Model_Member_Student();
        $student->setMember_id($member_id);
        $class_ids = $student->fetchAllClassIds();
        if (is_array($class_ids)) {
            return $class_ids;
        } else {
            if ($class_ids == false) {
                throw new Exception(
                'Student with member_id : ' . $member_id .
                 ' has not been registered in any Acdemic Class ', 
                Zend_Log::WARN);
            }
        }
    }
    /**
     * fetches batch_id on the basis of batch info given
     * 
     * @param string $department_id
     * @param string $programme_id
     * @param date $batch_start
     * @return array|false
     */
    private function getBatchIds ($batch_start = null, $department_id = null, 
    $programme_id = null)
    {
        $batch_start_basis = null;
        $department_id_basis = null;
        $programme_id_basis = null;
        $batch = new Acad_Model_Batch();
        if ($batch_start) {
            $batch_start_basis = true;
            $batch->setBatch_start($batch_start);
        }
        if ($department_id) {
            $department_id_basis = true;
            $batch->setDepartment_id($department_id);
        }
        if ($programme_id) {
            $programme_id_basis = true;
            $batch->setProgramme_id($programme_id);
        }
        $batch_ids = $batch->fetchBatchIds($batch_start_basis, 
        $department_id_basis, $programme_id_basis);
        Zend_Registry::get('logger')->debug('Batch Ids : ');
        Zend_Registry::get('logger')->debug($batch_ids);
        if (is_array($batch_ids)) {
            return $batch_ids;
        } else {
            if ($batch_ids == false) {
                throw new Exception(
                'No batch id exists for batch_start year : ' . $batch_start .
                 ' department_id : ' . $department_id . ' and programme_id : ' .
                 $programme_id, Zend_Log::WARN);
            }
        }
    }
    /**
     * fetches $class_id on the basis of class info given
     * Enter description here ...
     * @param int $class_id
     * @param int $semester_id
     * @param bool $is_active
     */
    private function getClassIds ($batch_id = null, $semester_id = null, 
    $is_active = null)
    {
        $batch_id_basis = null;
        $semester_id_basis = null;
        $is_active_basis = null;
        $class = new Acad_Model_Class();
        if ($batch_id) {
            $batch_id_basis = true;
            $class->setBatch_id($batch_id);
        }
        if ($semester_id) {
            $semester_id_basis = true;
            $class->setSemester_id($semester_id);
        }
        if ($is_active) {
            $is_active_basis = true;
            $class->setIs_active($is_active);
        }
        $class_ids = $class->fetchClassIds($batch_id_basis, $semester_id_basis, 
        $is_active_basis);
        if (is_array($class_ids)) {
            return $class_ids;
        } else {
            if ($class_ids == false) {
                throw new Exception(
                'No class id exists for batch_id : ' . $batch_id .
                 ' semester_id : ' . $semester_id, Zend_Log::WARN);
            }
        }
    }
    private function saveDmcInfo ($dmc_info)
    {
        $member_id = $this->getMember_id();
        $student = new Acad_Model_Member_Student();
        $student->setMember_id($member_id);
        $save_info['dmc_id'] = $dmc_info['dmc_id'];
        $save_info['class_id'] = $dmc_info['class_id'];
        $save_info['result_type_id'] = $dmc_info['result_type_id'];
        $save_info['is_considered'] = $dmc_info['is_considered'];
        $save_info['examination'] = $dmc_info['examination'];
        $save_info['custody_date'] = $dmc_info['custody_date'];
        $save_info['is_granted'] = $dmc_info['is_granted'];
        $save_info['grant_date'] = $dmc_info['grant_date'];
        $save_info['receiving_date'] = $dmc_info['receiving_date'];
        $save_info['is_copied'] = $dmc_info['is_copied'];
        $save_info['dispatch_date'] = $dmc_info['dispatch_date'];
        $save_info['marks_obtained'] = $dmc_info['marks_obtained'];
        $save_info['total_marks'] = $dmc_info['total_marks'];
        $save_info['scaled_marks'] = $dmc_info['scaled_marks'];
        $save_info['percentage'] = $dmc_info['percentage'];
        return $student->saveDmcInfo($save_info);
    }
}
