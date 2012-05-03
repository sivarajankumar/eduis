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
     * returns whole academic profile of student
     */
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
            $student_model->saveCriticalInfo($critical_data);
        }
        $this->_redirect('student/checkstatus');
    }
    /**
     * @todo check status of profile in auth that it is filled or not
     * Enter description here ...
     */
    public function checkstatusAction ()
    {
        $profile_present = 1;
        if ($profile_present) {
            $this->_redirect('student/viewprofile');
        } else {
            $this->_redirect('student/createprofile');
        }
    }
    public function viewprofileAction ()
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_data = array();
        $qualfication_ids = $student_model->fetchQualificationsIds();
        foreach ($qualfication_ids as $qualfication_id) {
            $qualfication_model = $student_model->fetchQualifiactionInfo(
            $qualfication_id);
            if ($qualfication_model instanceof Acad_Model_Qualification) {
                $qualification_data[$qualfication_id]['name'] = $qualfication_model->getQualification_name();
                $qualification_data[$qualfication_id]['id'] = $qualfication_id;
            }
        }
        $class_ids = $student_model->fetchAllClassIds();
        $model_member_id = $student_model->getMember_id();
        $dmc_data = array();
        //Zend_Registry::get('logger')->debug($model_member_id);
        foreach ($class_ids as $class_id) {
            $class_model = new Acad_Model_Class();
            $class_model->setClass_id($class_id);
            $class_model->fetchInfo();
            $semester_id = $class_model->getSemester_id();
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, null, true, 
            null);
            Zend_Registry::get('logger')->debug($dmc_info_ids);
            foreach ($dmc_info_ids as $dmc_info_id) {
                $dmc_object = $student_model->fetchDmcInfo($dmc_info_id);
                if ($dmc_object instanceof Acad_Model_Course_DmcInfo) {
                    $dmc_data[$semester_id][$dmc_info_id]['dmc_id'] = $dmc_object->getDmc_id();
                    $dmc_data[$semester_id][$dmc_info_id]['dispatch_date'] = $dmc_object->getDispatch_date();
                }
            }
        }
        $response = array('qualification_data' => $qualification_data, 
        'dmc_data' => $dmc_data);
        Zend_Registry::get('logger')->debug($response);
    }
    public function viewmatricinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_model = $student_model->fetchQualifiactionInfo(
        $params['qualification_id']);
        if ($qualification_model instanceof Acad_Model_Qualification_Matric) {
            $matric_data['board'] = $qualification_model->getBoard();
            $matric_data['boardroll_no'] = $qualification_model->getBoard_roll_no();
            $matric_data['city_name'] = $qualification_model->getCity_name();
            $matric_data['institution'] = $qualification_model->getInstitution();
            $matric_data['marks_obtained'] = $qualification_model->getMarks_obtained();
            $matric_data['passing_year'] = $qualification_model->getPassing_year();
            $matric_data['percentage'] = $qualification_model->getPercentage();
            $matric_data['remarks'] = $qualification_model->getRemarks();
            $matric_data['school_ramk'] = $qualification_model->getSchool_rank();
            $matric_data['state_name'] = $qualification_model->getState_name();
            $matric_data['total_marks'] = $qualification_model->getTotal_marks();
        }
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($matric_data)) {
                    $this->view->assign('matric', $matric_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($matric_data, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($matric_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($matric_data);
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
        $qualification_model = $student_model->fetchQualifiactionInfo(
        $params['qualification_id']);
        if ($qualification_model instanceof Acad_Model_Qualification_Twelfth) {
            $twelfth_data['board'] = $qualification_model->getBoard();
            $twelfth_data['board_roll_no'] = $qualification_model->getBoard_roll_no();
            $twelfth_data['city_name'] = $qualification_model->getCity_name();
            $twelfth_data['institution'] = $qualification_model->getInstitution();
            $twelfth_data['marks_obtained'] = $qualification_model->getMarks_obtained();
            $twelfth_data['passing_year'] = $qualification_model->getPassing_year();
            $twelfth_data['percentage'] = $qualification_model->getPercentage();
            $twelfth_data['remarks'] = $qualification_model->getRemarks();
            $twelfth_data['school_ramk'] = $qualification_model->getSchool_rank();
            $twelfth_data['state_name'] = $qualification_model->getState_name();
            $twelfth_data['total_marks'] = $qualification_model->getTotal_marks();
            $twelfth_data['discipline_id'] = $qualification_model->getDiscipline_id();
            $twelfth_data['pcm_percentage'] = $qualification_model->getPcm_percent();
            ;
        }
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($twelfth_data)) {
                    $this->view->assign('matric', $twelfth_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($twelfth_data, 
                false) . ')';
                break;
            case 'json':
                $this->_helper->json($twelfth_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($twelfth_data);
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
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
    }
    public function viewbtechinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
    }
    public function viewleetinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
    }
    public function viewaieeeinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
    }
    public function viewgateinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
    }
    public function savematricinfoAction ()
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
    }
    public function savetwelfthinfoAction ()
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
    }
    public function savediplomainfoAction ()
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
    }
    public function savebtechinfoAction ()
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
    }
    public function saveleetinfoAction ()
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
    }
    public function saveaieeeinfoAction ()
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
    }
    public function savegateinfoAction ()
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
    }
    public function competitiveAction ()
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        //competitive exam data
        $competitive_exam_data = array();
        $competitive_exam_ids = $student_model->fetchCompetitveExamIds();
        {
            foreach ($competitive_exam_ids as $competitive_exam_id) {
                $exam_model = $student_model->fetchCompetitveExamInfo(
                $competitive_exam_id);
                if ($exam_model instanceof Acad_Model_Exam_Competitive) {
                    $competitive_exam_data['name'] = $exam_model->getName();
                    $competitive_exam_data['air'] = $exam_model->getAll_india_rank();
                    $competitive_exam_data['date'] = $exam_model->getDate();
                    $competitive_exam_data['abbr'] = $exam_model->getAbbr();
                    $competitive_exam_data['roll_no'] = $exam_model->getRoll_no();
                }
            }
        }
    }
    public function programmedetailsAction ()
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $class_ids = $student_model->fetchAllClassIds();
        $model_member_id = $student_model->getMember_id();
        $dmc_data = array();
        //Zend_Registry::get('logger')->debug($model_member_id);
        foreach ($class_ids as $class_id) {
            $class_model = new Acad_Model_Class();
            $class_model->setClass_id($class_id);
            $class_model->fetchInfo();
            $semester_id = $class_model->getSemester_id();
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, null, true, 
            null);
            Zend_Registry::get('logger')->debug($dmc_info_ids);
            foreach ($dmc_info_ids as $dmc_info_id) {
                $dmc_object = $student_model->fetchDmcInfo($dmc_info_id);
                if ($dmc_object instanceof Acad_Model_Course_DmcInfo) {
                    $dmc_data[$semester_id][$dmc_info_id]['dmc_id'] = $dmc_object->getDmc_id();
                    $dmc_data[$semester_id][$dmc_info_id]['dispatch_date'] = $dmc_object->getDispatch_date();
                }
            }
        }
        Zend_Registry::get('logger')->debug($dmc_data);
    }
    public function createprofileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
}
