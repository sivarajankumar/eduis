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
    private function fetchTechnicalFields ()
    {
        $technical_field = new Tnp_Model_TechnicalField();
        $technical_fields = $technical_field->fetchTechnicalFields();
        return $technical_fields;
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
        $student_skills = $student_model->fetchSkillsIds();
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
        $test_score = $params['myarray']['test_score'];
        $section_info = $params['myarray']['section_score'];
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $test_model = new Tnp_Model_EmpTestInfo_Test();
        $employability_test_id = $test_model->saveInfo($test_info);
        $test_score['employability_test_id'] = $employability_test_id;
        $student->saveEmpTestRecord($test_score);
        $test_section_model = new Tnp_Model_EmpTestInfo_Section();
        foreach ($section_info as $name => $section_score) {
            $section_array = array();
            $section_array['test_section_name'] = $name;
            $section_array['employability_test_id'] = $employability_test_id;
            $test_section_id = $test_section_model->saveInfo($section_array);
            $section_score['test_section_id'] = $test_section_id;
            $section_score['employability_test_id'] = $employability_test_id;
            $student->saveEmpTestSectionScore($section_score);
        }
    }
    public function savecertificationAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $certification = $params['myarray']['certification_info'];
        $technical_info = $params['myarray']['technical_field_info'];
        $student_certification = $params['myarray']['certification_details'];
        $certification_model = new Tnp_Model_Certification();
        $technical_field_id = $technical_info['technical_field_id'];
        if ($technical_field_id) {
            $certification['technical_field_id'] = $technical_field_id;
        } else {
            $technical_field = new Tnp_Model_TechnicalField();
            $technical_field_id = $technical_field->saveInfo($technical_info);
            $certification['technical_field_id'] = $technical_field_id;
        }
        $certification_id = $certification_model->saveInfo($certification);
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $student->saveCertificationInfo($student_certification);
    }
    public function editcertificationAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $technical_fields = self::fetchTechnicalFields();
        Zend_Registry::get('logger')->debug($technical_fields);
        $this->view->assign('test_names', $technical_fields);
    }
    public function edittrainingAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $technical_fields = self::fetchTechnicalFields();
        $this->view->assign('test_names', $technical_fields);
        $training_model = new Tnp_Model_Training();
        Zend_Registry::get('logger')->debug($technical_fields);
        $technologies = $training_model->fetchTechnologies();
        $this->view->assign('technologies', $technologies);
        Zend_Registry::get('logger')->debug($technologies);
    }
    public function savetrainingAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $training_info = $params['myarray']['training_info'];
        $training_details = $params['myarray']['training_details'];
        $technical_info = $params['myarray']['technical_info'];
        $technical_field_id = $training_info['technical_field_id'];
        $training_id = $training_info['training_id'];
        if (! $technical_field_id) {
            $technical_field = new Tnp_Model_TechnicalField();
            $technical_field_id = $technical_field->saveInfo($technical_info);
            $training_info['technical_field_id'] = $technical_field_id;
        }
        if (! $training_id) {
            $training = new Tnp_Model_Training();
            $training_id = $training->saveInfo($training_info);
            $training_details['training_id'] = $training_id;
        }
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $student->saveTrainingInfo($training_details);
    }
    public function editexperienceAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $industry_model = new Tnp_Model_Industry();
        $role_model = new Tnp_Model_Role();
        $functional_model = new Tnp_Model_FunctionalArea();
        $industries = $industry_model->fetchIndustries();
        $roles = $role_model->fetchRoles();
        $functional_areas = $functional_model->fetchFunctionalAreas();
        $this->view->assign('industries', $industries);
        $this->view->assign('roles', $roles);
        $this->view->assign('functional_areas', $functional_areas);
        Zend_Registry::get('logger')->debug($industries);
        Zend_Registry::get('logger')->debug($roles);
        Zend_Registry::get('logger')->debug($functional_areas);
    }
    public function saveexperienceAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $experience_info = $params['experience_info'];
        $student_experience = $params['student_experience'];
        $role_name = $experience_info['role_name'];
        $industry_name = $experience_info['industry_name'];
        $functional_area_name = $experience_info['functional_area_name'];
        if ($role_name) {
            $role_model = new Tnp_Model_Role();
            $role_array = array($role_name);
            $role_id = $role_model->saveInfo($role_array);
            $student_experience['role_id'] = $role_id;
        }
        if ($industry_name) {
            $industry_model = new Tnp_Model_Industry();
            $industry_array = array($industry_name);
            $industry_id = $industry_model->saveInfo($industry_array);
            $student_experience['industry_id'] = $industry_id;
        }
        if ($functional_area_name) {
            $functional_model = new Tnp_Model_FunctionalArea();
            $functional_array = array($functional_area_name);
            $functional_area_id = $functional_model->saveInfo($role_array);
            $student_experience['functional_area_id'] = $functional_area_id;
        }
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $student->saveExperienceInfo($student_experience);
    }
    public function viewskillsAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $skills = $student->fetchSkillsIds();
        Zend_Registry::get('logger')->debug($skills);
    }
    public function viewjobpreferredAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $job_preferred = $student->fetchJobPreferred();
        $this->view->assign('job_preferred', $job_preferred);
        Zend_Registry::get('logger')->debug($job_preferred);
    }
    public function viewcocurricularAction ()
    {
        $cocurricular = array();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $cocurricular_model = $student->fetchCoCurricularInfo();
        if ($cocurricular_model instanceof Tnp_Model_MemberInfo_CoCurricular) {
            $cocurricular_model->fetchInfo();
            $cocurricular['achievements'] = $cocurricular_model->getAchievements();
            $cocurricular['activities'] = $cocurricular_model->getActivities();
            $cocurricular['hobbies'] = $cocurricular_model->getHobbies();
        }
        $this->view->assign('cocurricular', $cocurricular);
        Zend_Registry::get('logger')->debug($cocurricular);
    }
    public function viewtestinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $employability_test_id = 1; //$params['employability_test_id'];
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $test_record = new Tnp_Model_MemberInfo_EmployabilityTestRecord();
        $test_record->setEmployability_test_id($employability_test_id);
        $test_record->setMember_id($this->getMember_id());
        $record_ids = $test_record->fetchTestRecordIds(true, true);
        $response = array();
        foreach ($record_ids as $key => $record_id) {
            $test_record->setTest_record_id($record_id);
            $test_record->fetchInfo();
            $response['test_percentile'] = $test_record->getTest_percentile();
            $response['test_regn_no'] = $test_record->getTest_regn_no();
            $response['test_total_score'] = $test_record->getTest_total_score();
        }
          $this->view->assign('test_info', $response);
        Zend_Registry::get('logger')->debug($response);
    }
}
?>
    