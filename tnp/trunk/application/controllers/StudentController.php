<?php
/**
 * StudentController
 * 
 * @author team eduis
 * @version 3
 */
class StudentController extends Zend_Controller_Action
{
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
        //action body
    }
    function registerAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $student_model = new Tnp_Model_Member_Student();
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
    public function profileAction ()
    {
        $response = array();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Tnp_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $student_emp_test = array();
        $student_test_ids = $student_model->fetchEmpTestRecordIds();
        $emp_model = new Tnp_Model_EmpTestInfo_Test();
        if (! empty($student_test_ids)) {
            foreach ($student_test_ids as $key => $test_id) {
                $emp_model->setEmployability_test_id($test_id);
                $emp_model->fetchInfo();
                $student_emp_test[$test_id]['test_name'] = $emp_model->getTest_name();
                $student_emp_test[$test_id]['date'] = $emp_model->getDate_of_conduct();
            }
        }
        $student_certifications = array();
        $student_certification_ids = $student_model->fetchCertificationIds();
        $certification_model = new Tnp_Model_Certification();
        if (! empty($student_certification_ids)) {
            foreach ($student_certification_ids as $key => $certification_id) {
                $certification_model->setCertification_id($certification_id);
                $certification_model->fetchInfo();
                $student_certifications[$certification_id]['name'] = $certification_model->getCertification_name();
            }
        }
        $student_training = array();
        $student_training_ids = $student_model->fetchTrainingIds();
        $training_model = new Tnp_Model_MemberInfo_Training();
        $training_model->setMember_id($this->getMember_id());
        if (! empty($student_training_ids)) {
            foreach ($student_training_ids as $key => $training_id) {
                $training_model->setTraining_id($training_id);
                $training_model->fetchInfo();
                $student_training[$training_id]['semester'] = $training_model->getTraining_semester();
                $student_training[$training_id]['institute'] = $training_model->getTraining_institute();
            }
        }
        $student_experience = array();
        $student_experience_ids = $student_model->fetchExperienceIds();
        $experience_model = new Tnp_Model_MemberInfo_Experience();
        if (! empty($student_experience_ids)) {
            foreach ($student_experience_ids as $key => $student_experience_id) {
                $experience_model->setStudent_experience_id(
                $student_experience_id);
                $experience_model->fetchInfo();
                $student_experience[$student_experience_id]['organisation'] = $experience_model->getOrganisation();
            }
        }
        $student_languages = $student_model->fetchLanguagesKnown();
        if (! empty($student_languages)) {
            $response['languages_known'] = true;
        } else {
            $response['languages_known'] = false;
        }
        $student_job_preferred = $student_model->fetchJobPreferred();
        if (! empty($student_job_preferred)) {
            $response['job_preferred'] = true;
        } else {
            $response['job_preferred'] = false;
        }
        $co_curr_array = array();
        $student_co_curr = new Tnp_Model_MemberInfo_CoCurricular();
        $student_co_curr->setMember_id($this->getMember_id());
        $student_co_curr->fetchInfo();
        $co_curr_array['achievements'] = $student_co_curr->getAchievements();
        $co_curr_array['activities'] = $student_co_curr->getActivities();
        $co_curr_array['hobbies'] = $student_co_curr->getHobbies();
        if (isset($co_curr_array)) {
            $response['co_curricular'] = true;
        } else {
            $response['co_curricular'] = false;
        }
        $skills_array = array();
        $student_skills = $student_model->fetchSkills();
        if (! empty($student_skills)) {
            $response['skills'] = true;
        } else {
            $response['skills'] = false;
        }
        $response['employability_test'] = $student_emp_test;
        $response['certifications'] = $student_certifications;
        $response['training'] = $student_training;
        $response['experience'] = $student_experience;
        Zend_Registry::get('logger')->debug($response);
        switch ($format) {
            case 'html':
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
            case 'test':
                Zend_Registry::get('logger')->debug($response);
                break;
            default:
                ;
                break;
        }
    }
    public function edittestinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $response_names = array();
        $response_sections = array();
        $test_model = new Tnp_Model_EmpTestInfo_Test();
        $test_ids = $test_model->fetchTestsIds();
        foreach ($test_ids as $key => $test_id) {
            $test_model->setEmployability_test_id($test_id);
            $test_model->fetchInfo();
            $test_name = $test_model->getTest_name();
            $response_names[$test_id] = $test_name;
        }
        $test_names = array_unique($response_names);
        $test_section_model = new Tnp_Model_EmpTestInfo_Section();
        $test_section_ids = $test_section_model->fetchTestSectionIds();
        foreach ($test_section_ids as $key => $test_section_id) {
            $test_section_model->setTest_section_id($test_section_id);
            $test_section_model->fetchInfo();
            $test_section_name = $test_section_model->getTest_section_name();
            $response_sections[$test_section_id] = $test_section_name;
        }
        $test_sections = array_unique($response_sections);
         Zend_Registry::get('logger')->debug($test_names);
          Zend_Registry::get('logger')->debug($test_sections);
        $this->view->assign('test_names', $test_names);
        $this->view->assign('test_sections', $test_sections);
    }
    public function saveemployabilitytest ()
    {
        $response = array();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $test_info = $params['myarray']['test_info'];
        $test_score = $params['myarray']['test_marks'];
        $section_info = $params['myarray']['section_info'];
        $section_marks = $params['myarray']['section_marks'];
        $student = new Tnp_Model_Member_Student();
        $student->saveEmpTestRecord($data_array);
        $student->setMember_id($this->getMember_id());
        $test_model = new Tnp_Model_EmpTestInfo_Test();
        $employability_test_id = $test_model->saveInfo($test_info);
        $test_score['employability_test_id'] = $employability_test_id;
        $test_score['member_id'] = $this->getMember_id();
        $test_model->save($test_score);
        $test_section_model = new Tnp_Model_EmpTestInfo_Section();
        $section_info['employability_test_id'] = $employability_test_id;
        $test_section_model->save();
    }
}
?>
    