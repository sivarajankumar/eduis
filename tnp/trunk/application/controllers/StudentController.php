<?php
/**
 * StudentController
 * 
 * @author team eduis
 * @version 3
 */
class StudentController extends Zend_Controller_Action
{
    protected $_member_id;
    /**
     * The default action - show the home page
     */
    public function init ()
    {
        /* Initialize action controller here */
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $authInfo = Zend_Auth::getInstance()->getStorage()->read();
            $this->department_id = $authInfo['department_id'];
            $this->identity = $authInfo['identity'];
            $this->setMember_id($authInfo['member_id']);
             //$staff_id = $authInfo['member_id'];
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
        /*$student_languages = $student_model->fetchLanguagesInfo();
        if (! empty($student_languages)) {
            $response['languages_known'] = true;
        } else {
            $response['languages_known'] = false;
        }*/
        $student_lang = new Tnp_Model_MemberInfo_Language();
        $student_lang->setMember_id($this->getMember_id());
        $stu_lang = $student_lang->fetchLanguagesInfo();
        $lang = new Tnp_Model_Language();
        $languages = $lang->fetchLanguages();
        $newarray = array();
        foreach ($stu_lang as $key => $proficiency) {
            $newarray[$languages[$key]] = $proficiency;
        }
        $response['language'] = $newarray;
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
        $skill_ids = $student_model->fetchSkillsIds();
        if (! empty($skill_ids)) {
            $skill_info = array();
            $skill_object = new Tnp_Model_Skill();
            foreach ($skill_ids as $skill_id) {
                $skill_object->setSkill_id($skill_id);
                $skill_object->fetchInfo();
                $skill_info[$skill_object->getSkill_name()] = $skill_object->getSkill_field();
            }
            $response['skills'] = $skill_info;
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
    public function saveemployabilitytestAction ()
    {
        $response = array();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $test_info = $params['myarray']['test_info'];
        $test_score = $params['myarray']['test_score'];
        $section_info = $params['myarray']['test_section_info'];
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $test_model = new Tnp_Model_EmpTestInfo_Test();
        Zend_Registry::get('logger')->debug($test_info);
        $employability_test_id = $test_model->saveInfo($test_info);
        $test_score['employability_test_id'] = $employability_test_id;
        $student->saveEmpTestRecord($test_score);
        $test_section_model = new Tnp_Model_EmpTestInfo_Section();
        Zend_Registry::get('logger')->debug($section_info);
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
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $certification = $params['myarray']['certification_info'];
        $technical_info = $params['myarray']['technical_info'];
        $student_certification = $params['myarray']['certification_detail'];
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
        $student_certification['certification_id'] = $certification_id;
        Zend_Registry::get('logger')->debug($student_certification);
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
        $training_details = $params['myarray']['training_detail'];
        $technical_info = $params['myarray']['technical_info'];
        $technical_field_id = $technical_info['technical_field_id'];
        $training_id = $training_info['training_id'];
        if (! $technical_field_id) {
            $technical_field = new Tnp_Model_TechnicalField();
            $technical_field_id = $technical_field->saveInfo($technical_info);
            $training_info['technical_field_id'] = $technical_field_id;
        } else {
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
        Zend_Registry::get('logger')->debug($params);
        $experience_info = $params['myarray']['experience_info'];
        $student_experience = $params['myarray']['student_experience'];
        $role_name = $experience_info['role_name'];
        $industry_name = $experience_info['industry_name'];
        $functional_area_name = $experience_info['functional_area_name'];
        if ($role_name) {
            $role_model = new Tnp_Model_Role();
            $role_array = array('role_name' => $role_name);
            Zend_Registry::get('logger')->debug($role_array);
            $role_id = $role_model->saveInfo($role_array);
            $student_experience['role_id'] = $role_id;
        }
        if ($industry_name) {
            $industry_model = new Tnp_Model_Industry();
            $industry_array = array('industry_name' => $industry_name);
            Zend_Registry::get('logger')->debug($industry_array);
            $industry_id = $industry_model->saveInfo($industry_array);
            $student_experience['industry_id'] = $industry_id;
        }
        if ($functional_area_name) {
            $functional_model = new Tnp_Model_FunctionalArea();
            $functional_array = array(
            'functional_area_name' => $functional_area_name);
            $functional_area_id = $functional_model->saveInfo($functional_array);
            $student_experience['functional_area_id'] = $functional_area_id;
        }
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $student->saveExperienceInfo($student_experience);
    }
    /**
     * Gets All skills from database
     * 
     * @throws Exception
     */
    public function editskillsetAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $skill = new Tnp_Model_Skill();
        $skill_ids = $skill->fetchSkillIds();
        if (is_array($skill_ids)) {
            $all_skills = array();
            foreach ($skill_ids as $skill_id) {
                $skill->setSkill_id($skill_id);
                $skill->fetchInfo();
                $skill_name = $skill->getSkill_name();
                $skill_field = $skill->getSkill_field();
                $all_skills[$skill_id] = array('skill_name' => $skill_name, 
                'skill_field' => $skill_field);
            }
        } else {
            throw new Exception('Skills table empty', Zend_Log::WARN);
        }
        $this->view->assign('all_skills', $all_skills);
    }
    /*
     * save new skills to database
     */
    public function saveskillsetAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $skill_info = $params['myarray']['skill_info'];
        $skill = new Tnp_Model_Skill();
        $skill_data = array('skill_name' => $skill_info['skill_name'], 
        'skill_field' => $skill_info['skill_field']);
        $skill_id = $skill->saveInfo($skill_data);
    }
    /**
     * Enables user to view his skills
     * @deprecated coded inline inside profile action
     */
    /*public function viewskillsAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $skill_info = array();
        $skill_ids = $student->fetchSkillsIds();
        $skill_object = new Tnp_Model_Skill();
        foreach ($skill_ids as $skill_id) {
            $skill_object->setSkill_id($skill_id);
            $skill_object->fetchInfo();
            $skill_info[$skill_object->getSkill_name()] = $skill_object->getSkill_field();
        }
        Zend_Registry::get('logger')->debug($skill_ids);
    }*/
    /**
     * Enables the user add edit existing skills or add new skills to database
     * 
     */
    public function editskillsAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function saveskillsAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $is_new_skill = $params['myarray']['new_skill'];
        $skill_info = $params['myarray']['skill_info'];
        $member_proficiency = $params['myarray']['member_proficiency'];
        /*
         * skill id sent by user
         */
        if (! empty($skill_info['skill_id'])) {
            $skill_id = $skill_info['skill_id'];
        }
        /*
         * if skill does not exist in databse add it, otherwise update member's proficiency
         */
        if ($is_new_skill == 'true') {
            /*
             * redirect to saveskillset
             */
        }
        $member_id = $this->getMember_id();
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($member_id);
        $mem_skill_info = array('skill_id' => $skill_id, 
        'proficiency' => $member_proficiency);
        $student->saveSkillInfo($mem_skill_info);
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
    public function editcocurricularAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function updatecocurricularAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $cocurricular_info = array();
        $cocurricular_info = $params['myarray']['cocurricular'];
        if (! empty($cocurricular_info)) {
            $achievements = $cocurricular_info['achievements'];
            $activities = $cocurricular_info['activities'];
            $hobbies = $cocurricular_info['hobbies'];
            $member_cocurricular_info['achievements'] = $achievements;
            $member_cocurricular_info['activities'] = $activities;
            $member_cocurricular_info['hobbies'] = $hobbies;
            $student = new Tnp_Model_Member_Student();
            $student->setMember_id($this->getMember_id());
            $student->saveCoCurricularInfo($member_cocurricular_info);
        }
    }
    public function viewtestinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $employability_test_id = $params['employability_test_id'];
        $test_name = $params['test_name'];
        $date_of_conduct = $params['date_of_conduct'];
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
            $response['test_name'] = $test_name;
            $response['date_of_conduct'] = $date_of_conduct;
        }
        $this->view->assign('test_info', $response);
        Zend_Registry::get('logger')->debug($response);
    }
    public function viewsectionscoreAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $employability_test_id = $params['employability_test_id'];
        $test_name = $params['test_name'];
        $date_of_conduct = $params['date_of_conduct'];
        $section_score = new Tnp_Model_MemberInfo_EmployabilityTestSectionScore();
        $section_score->setEmployability_test_id($employability_test_id);
        $section_score->setMember_id($this->getMember_id());
        $section_score_ids = $section_score->fetchSectionScoreIds(true, true);
        $test = new Tnp_Model_EmpTestInfo_Section();
        $response = array();
        foreach ($section_score_ids as $key => $section_score_id) {
            $section_score->setSection_score_id($section_score_id);
            $section_score->fetchInfo();
            $section_marks = $section_score->getSection_marks();
            $section_percentile = $section_score->getSection_percentile();
            $test_section_id = $section_score->getTest_section_id();
            $test->setTest_section_id($test_section_id);
            $test->fetchInfo();
            $section_name = $test->getTest_section_name();
            $response[$section_score_id]['section_name'] = $section_name;
            $response[$section_score_id]['section_marks'] = $section_marks;
            $response[$section_score_id]['section_percentile'] = $section_percentile;
        }
        $this->_helper->json($response);
         //$this->view->assign('section_score', $response);
    //Zend_Registry::get('logger')->debug($response);
    }
    public function viewcertificationAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $certification_id = $params['certification_id'];
        $student_certification = new Tnp_Model_MemberInfo_Certification();
        $student_certification->setMember_id($this->getMember_id());
        $student_certification->setCertification_id($certification_id);
        $student_certification->fetchInfo();
        $start_date = $student_certification->getStart_date();
        $complete_date = $student_certification->getComplete_date();
        $certification = new Tnp_Model_Certification();
        $certification->setCertification_id($certification_id);
        $certification->fetchInfo();
        $name = $certification->getCertification_name();
        $technical_field_id = $certification->getTechnical_field_id();
        $technical = new Tnp_Model_TechnicalField();
        $technical->setTechnical_field_id($technical_field_id);
        $technical->fetchInfo();
        $technical_field_name = $technical->getTechnical_field_name();
        $technical_field_sector = $technical->getTechnical_sector();
        $certification = array('certification_name' => $name, 
        'start_date' => $start_date, 'complete_date' => $complete_date, 
        'technical_field_name' => $technical_field_name, 
        'technical_field_sector' => $technical_field_sector);
        $this->view->assign('certification', $certification);
        Zend_Registry::get('logger')->debug($certification);
    }
    public function viewexperienceAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $student_experience_id = $params['experience_id'];
        $student_experience = new Tnp_Model_MemberInfo_Experience();
        $student_experience->setMember_id($this->getMember_id());
        $student_experience->setStudent_experience_id($student_experience_id);
        $student_experience->fetchInfo();
        $industry_id = $student_experience->getIndustry_id();
        $role_id = $student_experience->getRole_id();
        $functional_area_id = $student_experience->getFunctional_area_id();
        $industry = new Tnp_Model_Industry();
        $industry->setIndustry_id($industry_id);
        $industry->fetchInfo();
        $industry_name = $industry->getIndustry_name();
        $role = new Tnp_Model_Role();
        $role->setRole_id($role_id);
        $role->fetchInfo();
        $role_name = $role->getRole_name();
        $func_area = new Tnp_Model_FunctionalArea();
        $func_area->setFunctional_area_id($functional_area_id);
        $func_area->fetchInfo();
        $func_area_name = $func_area->getFunctional_area_name();
        $organisation = $student_experience->getOrganisation();
        $start_date = $student_experience->getStart_date();
        $end_date = $student_experience->getEnd_date();
        $months = $student_experience->getExperience_months();
        $years = $student_experience->getExperience_years();
        $description = $student_experience->getDescription();
        $experience = array('organisation' => $organisation, 
        'start_date' => $start_date, 'end_date' => $end_date, 
        'experience_months' => $months, 'experience_years' => $years, 
        'description' => $description, 'functional_area_name' => $func_area_name, 
        'role_name' => $role_name, 'industry_name' => $industry_name);
        $this->view->assign('experience', $experience);
        Zend_Registry::get('logger')->debug($experience);
    }
    public function viewtrainingAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $training_id = $params['training_id'];
        $student_trainng = new Tnp_Model_MemberInfo_Training();
        $student_trainng->setMember_id($this->getMember_id());
        $student_trainng->setTraining_id($training_id);
        $student_trainng->fetchInfo();
        $training = new Tnp_Model_Training();
        $training->setTraining_id($training_id);
        $training->fetchInfo();
        $technical_field_id = $training->getTechnical_field_id();
        $training_technology = $training->getTraining_technology();
        $training_institute = $student_trainng->getTraining_institute();
        $start_date = $student_trainng->getStart_date();
        $complete_date = $student_trainng->getCompletion_date();
        $semester = $student_trainng->getTraining_semester();
        $technical = new Tnp_Model_TechnicalField();
        $technical->setTechnical_field_id($technical_field_id);
        $technical->fetchInfo();
        $technical_field_name = $technical->getTechnical_field_name();
        $technical_field_sector = $technical->getTechnical_sector();
        $training_info = array('training_institute' => $training_institute, 
        'training_technology' => $training_technology, 
        'start_date' => $start_date, 'complete_date' => $complete_date, 
        'semester' => $semester, 'technical_field_name' => $technical_field_name, 
        'technical_field_sector' => $technical_field_sector);
        $this->view->assign('training_info', $training_info);
        Zend_Registry::get('logger')->debug($training_info);
    }
    public function viewlanguagesknownAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $student_lang = new Tnp_Model_MemberInfo_Language();
        $student_lang->setMember_id($this->getMember_id());
        $language_ids = $student_lang->fetchLanguagesKnown();
        $language = new Tnp_Model_Language();
        $languages = array();
        foreach ($language_ids as $key => $language_id) {
            $language->setLanguage_id($language_id);
            $language->fetchInfo();
            $languages[$language_id]['name'] = $language->getLanguage_name();
            $languages[$language_id]['proficiency'] = $student_lang->getProficiency();
        }
        $this->view->assign('languages', $languages);
        Zend_Registry::get('logger')->debug($languages);
    }
    public function editlanguagesknownAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $language_object = new Tnp_Model_Language();
        $language_ids = $language_object->fetchLanguages();
        $this->view->assign('languages', $language_ids);
    }
    public function savelanguagesknownAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $is_new_language = $params['myarray']['new_language'];
        $language_info = $params['myarray']['language_info'];
        $member_proficiency = $params['myarray']['member_proficiency'];
        /*
         * language id sent by user
         */
        if (! empty($language_info['language_id'])) {
            $language_id = $language_info['language_id'];
        }
        /*
         * if language does not exist in databse add it, otherwise update member's proficiency
         */
        if ($is_new_language == 'true') {
            $language = new Tnp_Model_Language();
            $lan_data = array('language_name' => $language_info[language_name]);
            /*
             * language id generated for new language and $language id updated
             */
            $language_id = $language->saveInfo($lan_data);
        }
        $member_id = $this->getMember_id();
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($member_id);
        $proficiency = array();
        $can_speak = (($member_proficiency['SPEAK'] == 'true') ? ($proficiency[] = 'SPEAK') : null);
        $can_read = (($member_proficiency['READ'] == 'true') ? ($proficiency[] = 'READ') : null);
        $can_write = (($member_proficiency['WRITE'] == 'true') ? ($proficiency[] = 'WRITE') : null);
        $mem_lang_info = array('language_id' => $language_id, 
        'proficiency' => implode(',', $proficiency));
        $student->saveLanguageInfo($mem_lang_info);
    }
    public function testAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        Zend_Registry::get('logger')->debug($params);
        $member_id = $this->getMember_id();
        $is_new_language = $params['myarray']['new_language'];
        Zend_Registry::get('logger')->debug($is_new_language);
        $language_info = $params['myarray']['language_info'];
        Zend_Registry::get('logger')->debug($language_info);
        $member_proficiency = $params['myarray']['member_proficiency'];
        Zend_Registry::get('logger')->debug($member_proficiency);
        /*
             * if language does not exist in databse add it, otherwise update member's proficiency
             */
        if ($is_new_language == 'true') {
            $language = new Tnp_Model_Language();
            $language_id = $language->saveInfo($language_info);
        } else {
            $student = new Tnp_Model_Member_Student();
            $student->setMember_id($member_id);
            $language_id = $language_info['language_id'];
            $proficiency = array();
            $can_speak = (($member_proficiency['SPEAK'] == 'true') ? ($proficiency[] = 'SPEAK') : null);
            $can_read = (($member_proficiency['READ'] == 'true') ? ($proficiency[] = 'READ') : null);
            $can_write = (($member_proficiency['WRITE'] == 'true') ? ($proficiency[] = 'WRITE') : null);
            $proficiency = array($can_read, $can_write, $can_speak);
            $mem_lang_info = array('language_id' => $language_id, 
            'proficiency' => implode(',', $proficiency));
            Zend_Registry::get('logger')->debug($mem_lang_info);
            $student->saveLanguageInfo($language_info);
        }
    }
}
?>
    