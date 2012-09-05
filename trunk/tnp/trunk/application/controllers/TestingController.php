<?php
/**
 * StudentController
 * 
 * @author team eduis
 * @version 3
 */
class TestingController extends Zend_Controller_Action
{
    /**
     * 
     * @var int
     */
    protected $_member_id;
    protected $_user_name;
    protected $_user_type;
    protected $_department_id;
    /**
     * @return the $_member_id
     */
    protected function getMember_id ()
    {
        return $this->_member_id;
    }
    /**
     * @return the $_user_name
     */
    protected function getUser_name ()
    {
        return $this->_user_name;
    }
    /**
     * @return the $_user_type
     */
    protected function getUser_type ()
    {
        return $this->_user_type;
    }
    /**
     * @return the $_department_id
     */
    protected function getDepartment_id ()
    {
        return $this->_department_id;
    }
    /**
     * @param int $_member_id
     */
    protected function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_user_name
     */
    protected function setUser_name ($_user_name)
    {
        $this->_user_name = $_user_name;
    }
    /**
     * @param field_type $_user_type
     */
    protected function setUser_type ($_user_type)
    {
        $this->_user_type = $_user_type;
    }
    /**
     * @param field_type $_department_id
     */
    protected function setDepartment_id ($_department_id)
    {
        $this->_department_id = $_department_id;
    }
    public function indexAction ()
    {}
    public function init ()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $authInfo = Zend_Auth::getInstance()->getStorage()->read();
            $this->setDepartment_id($authInfo['department_id']);
            $this->setUser_name($authInfo['identity']);
            $this->setUser_type($authInfo['userType']);
            $this->setMember_id($authInfo['member_id']);
        }
    }
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
        $critical_data = self::findCriticalInfo($member_id);
        $this->_helper->json($critical_data);
    }
    public function registerAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $student_model = new Tnp_Model_Member_Student();
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
        $critical_data = Zend_Json::decode($response->getBody());
        Zend_Registry::get('logger')->debug($response);
        Zend_Registry::get('logger')->debug($critical_data);
        /*if ($critical_data) {
            $student_model->saveCriticalInfo($critical_data);
        } else {
            $msg = 'PLEASE REGISTER IN CORE MODULE....GOTO core.aceambala.com';
            throw new Exception('$msg');
        }
        $this->_redirect('student/profile');*/
    }
    /* ######################################################################### */
    public function savecertificationAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $certification = $params['myarray']['certification_info'];
        $technical_info = $params['myarray']['technical_info'];
        $student_certification = $params['myarray']['certification_detail'];
        $technical_field_id = $technical_info['technical_field_id'];
        if ($technical_field_id) {
            $certification['technical_field_id'] = $technical_field_id;
        } else {
            $technical_field = new Tnp_Model_TechnicalField();
            $technical_field_id = $technical_field->saveInfo($technical_info);
            $certification['technical_field_id'] = $technical_field_id;
        }
        $certification_id = $this->saveCertificationInfo($certification);
        $student_certification['certification_id'] = $certification_id;
        Zend_Registry::get('logger')->debug($student_certification);
        $this->saveStuCertificationInfo($student_certification);
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
            $technical_field_id = $this->saveTechFieldInfo($technical_info);
            $training_info['technical_field_id'] = $technical_field_id;
        } else {
            $training_info['technical_field_id'] = $technical_field_id;
        }
        if (! $training_id) {
            $training_id = $this->saveTrainingInfo($training_info);
            $training_details['training_id'] = $training_id;
        }
        $this->saveStuTrainingInfo($training_details);
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
            $role_array = array('role_name' => $role_name);
            $role_id = $this->saveRoleInfo($role_array);
            $student_experience['role_id'] = $role_id;
        }
        if ($industry_name) {
            $industry_array = array('industry_name' => $industry_name);
            $industry_id = $this->saveIndustryInfo($industry_array);
            $student_experience['industry_id'] = $industry_id;
        }
        if ($functional_area_name) {
            $functional_array = array(
            'functional_area_name' => $functional_area_name);
            $functional_area_id = $this->saveFunctionalAreaInfo(
            $functional_array);
            $student_experience['functional_area_id'] = $functional_area_id;
        }
        $this->saveExperienceInfo($student_experience);
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
            $lan_data = array('language_name' => $language_info[language_name]);
            /*
             * language id generated for new language and $language id updated
             */
            $language_id = $this->saveLanguageInfo($lan_data);
        }
        $proficiency = array();
        (($member_proficiency['SPEAK'] == 'true') ? ($proficiency[] = 'SPEAK') : null);
        (($member_proficiency['READ'] == 'true') ? ($proficiency[] = 'READ') : null);
        (($member_proficiency['WRITE'] == 'true') ? ($proficiency[] = 'WRITE') : null);
        $mem_lang_info = array('language_id' => $language_id, 
        'proficiency' => implode(',', $proficiency));
        $this->saveStuLanguageInfo($mem_lang_info);
    }
    public function savejobpreferredAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $job_preference = $params['myarray']['job_area_name'];
        $this->saveJobPreferred($job_preference);
    }
    public function savecocurricularAction ()
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
            $this->saveCourricularInfo($member_cocurricular_info);
        }
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
            $skill_data = array('skill_name' => $skill_info['skill_name']);
            $skill_id = $this->saveSkillsInfo($skill_data);
        }
        $mem_skill_info = array('skill_id' => $skill_id, 
        'proficiency' => $member_proficiency);
        $this->saveStuSkillsInfo($mem_skill_info);
    }
    /**
     * Checks if member is registered in the core,
     * @return true if member_id is registered, false otherwise
     */
    private function memberIdCheck ($member_id_to_check)
    {
        $student = new Tnp_Model_Member_Student();
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
    private function findCriticalInfo ($member_id)
    {
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $student = new Tnp_Model_Member_Student();
            $student->setMember_id($member_id);
            $student = $student->fetchCriticalInfo();
            if ($student instanceof Tnp_Model_Member_Student) {
                $critical_data['member_id'] = $this->getMember_id();
                $critical_data['first_name'] = $student->getFirst_name();
                $critical_data['middle_name'] = $student->getMiddle_name();
                $critical_data['last_name'] = $student->getLast_name();
                $critical_data['cast'] = $student->getCast_name();
                $critical_data['nationality'] = $student->getNationality_name();
                $critical_data['religion'] = $student->getReligion_name();
                $critical_data['blood_group'] = $student->getBlood_group();
                $critical_data['dob'] = $student->getDob();
                $critical_data['gender'] = $student->getGender();
                $critical_data['member_type_id'] = $student->getMember_type_id();
                $critical_data['religion_id'] = $student->getReligion_id();
                $critical_data['nationality_id'] = $student->getNationality_id();
                $critical_data['cast_id'] = $student->getCast_id();
                return $critical_data;
            }
        }
    }
    private function findTechnicalFields ()
    {
        $technical_field = new Tnp_Model_TechnicalField();
        $technical_fields = $technical_field->fetchTechnicalFields();
        return $technical_fields;
    }
    /**
     * for testing purposes only
     * Enter description here ...
     */
    public function profileAction ()
    {
        $response = array();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $response['employability_test'] = $this->findEmpTestInfo();
        /*------------------------------------------------------------------------------*/
        $response['certifications'] = $this->findCertificationsInfo();
        /*------------------------------------------------------------------------------*/
        $response['training'] = $this->findTrainingInfo();
        /*------------------------------------------------------------------------------*/
        $response['experience'] = $this->findExperienceInfo();
        /*------------------------------------------------------------------------------*/
        $response['language'] = $this->findLanguageInfo();
        /*------------------------------------------------------------------------------*/
        $response['job_preferred'] = $this->findJobPreferred();
        /*------------------------------------------------------------------------------*/
        $response['co_curricular'] = $this->findCourricularInfo();
        /*------------------------------------------------------------------------------*/
        $response['skills'] = $this->findSkillsInfo();
        /*------------------------------------------------------------------------------*/
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
    /* -------------------------------	EMP TEST -> ACCOMPLISHED ------------------------------------------ */
    public function viewemptestrecordAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $response = array();
        $test_record = $this->generateEmpTestRecords();
        Zend_Registry::get('logger')->debug(
        'Vars assigned to view are : \'test_record\' where the key is the test_record_id');
        Zend_Registry::get('logger')->debug($test_record);
        $this->view->assign('test_record',$test_record);
    }
    /**
     * assigns test and section record for a given employability_test_id of member_id
     * Enter description here ...
     */
    public function editemptestrecordAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $test_record_id = $params['test_record_id'];
        $test_record = $this->getEmpTestRecordInfo($test_record_id);
        $employability_test_id = $test_record['employability_test_id'];
        $test_info = $this->getEmpTestInfo($employability_test_id);
        $test_record['test_name'] = $test_info['test_name'];
        $test_record['date_of_conduct'] = $test_info['date_of_conduct'];
        $section_record = $this->generateSectionScore($employability_test_id);
        Zend_Registry::get('logger')->debug($test_record);
        Zend_Registry::get('logger')->debug($section_record);
        switch ($format) {
            case 'html':
                $this->view->assign('test_record', $test_record);
                $this->view->assign('section_record', $section_record);
                break;
            default:
                ;
                break;
        }
    }
    public function fetchemptestrecordAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $employability_test_id = $params['employability_test_id'];
        $member_id = $this->getMember_id();
        $test_record_id = $this->getEmpTestRecordId($member_id, 
        $employability_test_id);
        $test_record = $this->getEmpTestRecordInfo(array_pop($test_record_id));
        switch ($format) {
            case 'html':
                $this->view->assign('test_record', $test_record);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($test_record, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($test_record);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($test_record);
                break;
            default:
                ;
                break;
        }
    }
    public function fetchsectionrecordAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $format = $this->_getParam('format', 'html');
        $params = array_diff($request->getParams(), $request->getUserParams());
        $employability_test_id = $params['employability_test_id'];
        $section_record = $this->generateSectionScore($employability_test_id);
        Zend_Registry::get('logger')->debug($section_record);
        switch ($format) {
            case 'html':
                $this->view->assign('section_record', $section_record);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' .
                 $this->_helper->json($section_record, false) . ')';
                break;
            case 'json':
                $this->_helper->json($section_record);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($section_record);
                break;
            default:
                ;
                break;
        }
    }
    /**
     * Saves the test record(user point of view)
     * 
     * Enter description here ...
     */
    public function saveemptestrecordAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        Zend_Registry::get('logger')->debug(
        'params required are \'test_info\' ,  \'test_record\' , \'test_section_record\' in myarray ex \'$params[\'myarray\'][\'test_info\']');
        $test_info = $params['myarray']['test_info'];
        $test_score = $params['myarray']['test_record'];
        $section_record = $params['myarray']['test_section_record'];
        $employability_test_id = $this->saveEmpTest($test_info);
        $test_score['employability_test_id'] = $employability_test_id;
        $this->saveEmpTestRecord($test_score);
        foreach ($section_record as $name => $section_score) {
            $section_array = array();
            $this->saveSectionScore($section_score);
        }
    }
    public function viewemptestAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function addemptestAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    /**
     * Saves the new test
     * Enter description here ...
     */
    public function saveemptestAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        Zend_Registry::get('logger')->debug(
        'params required are \'test_info\' myarray[\'test_info\']');
        $test_info = $params['myarray']['test_info'];
        $this->saveEmpTest($test_info);
    }
    public function fetchEmpTestId ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        Zend_Registry::get('logger')->debug(
        'params required are \'test_info\' myarray[\'test_info\']');
        $test_info = $params['myarray']['test_info'];
        $employability_test_id = $this->saveEmpTest($test_info);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('employability_test_id', 
                $employability_test_id);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' .
                 $this->_helper->json($employability_test_id, false) . ')';
                break;
            case 'json':
                $this->_helper->json($employability_test_id);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($employability_test_id);
                break;
            default:
                ;
                break;
        }
    }
    /**
     * Saves the new test
     * Enter description here ...
     */
    public function saveemptestsectionAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        Zend_Registry::get('logger')->debug(
        'params requires are \'section_info\' myarray[\'section_info\']');
        $section_info = $params['myarray']['section_info'];
        foreach ($section_info as $employability_test_id => $section_name) {
            $info['employability_test_id'] = $employability_test_id;
            $info['section_name'] = $section_name;
            $this->saveEmpTestSection($info);
        }
    }
    /* ------------------------------------------------------------------------------------------- */
    /*********************************************************************************************/
    private function getEmpTestRecordInfo ($test_record_id)
    {
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $emp_test_record = array();
        $info = $student->fetchEmpTestRecordInfo($test_record_id);
        if ($info instanceof Tnp_Model_MemberInfo_EmployabilityTestRecord) {
            $emp_test_record['employability_test_id'] = $info->getEmployability_test_id();
            $emp_test_record['test_regn_no'] = $info->getTest_regn_no();
            $emp_test_record['test_total_score'] = $info->getTest_total_score();
            $emp_test_record['test_percentile'] = $info->getTest_percentile();
        } else {
            $emp_test_record = false;
        }
        return $emp_test_record;
    }
    private function getEmpTestInfo ($employability_test_id)
    {
        $emp_test = new Tnp_Model_EmpTestInfo_Test();
        $emp_test_info = array();
        $emp_test->setEmployability_test_id($employability_test_id);
        $info = $emp_test->fetchInfo();
        if ($info instanceof Tnp_Model_EmpTestInfo_Test) {
            $emp_test_info['test_name'] = $info->getTest_name();
            $emp_test_info['date_of_conduct'] = $info->getDate_of_conduct();
        } else {
            $emp_test_info = false;
        }
        return $emp_test_info;
    }
    private function getEmpTestRecordIds ()
    {
        $member_id = $this->getMember_id();
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($member_id);
        return $student->fetchEmpTestRecordIds();
    }
    private function getEmpTestRecordId ($member_id, $employability_test_id)
    {
        $test = new Tnp_Model_MemberInfo_EmployabilityTestRecord();
        $test->setMember_id($member_id);
        $test->setEmployability_test_id($employability_test_id);
        return $test->fetchTestRecordIds(true, true);
    }
    private function generateEmpTestRecords ()
    {
        $record_info = array();
        $record_ids = $this->getEmpTestRecordIds();
        if (! empty($record_ids)) {
            foreach ($record_ids as $key => $test_record_id) {
                $raw_info = $this->getEmpTestRecordInfo($test_record_id);
                $employability_test_id = $raw_info['employability_test_id'];
                $record_info[$test_record_id] = $raw_info;
                $test_info = $this->getEmpTestInfo($employability_test_id);
                $record_info[$test_record_id]['test_name'] = $test_info['test_name'];
                $record_info[$test_record_id]['date_of_conduct'] = $test_info['date_of_conduct'];
            }
        } else {
            $record_info = false;
        }
        return $record_info;
    }
    /*********************************************************************************************/
    private function getTestSectionIds ($employability_test_id)
    {
        $section = new Tnp_Model_EmpTestInfo_Section();
        $section->setEmployability_test_id($employability_test_id);
        return $section->fetchTestSectionIds(true);
    }
    private function getTestSectionInfo ($test_section_id)
    {
        $emp_sec = new Tnp_Model_EmpTestInfo_Section();
        $emp_sec_info = array();
        $emp_sec->setTest_section_id($test_section_id);
        $info = $emp_sec->fetchInfo();
        if ($info instanceof Tnp_Model_EmpTestInfo_Section) {
            $emp_sec_info['test_section_name'] = $info->getTest_section_name();
        } else {
            $emp_sec_info = false;
        }
        return $emp_sec_info;
    }
    private function getTestSectionScoreIds ($employability_test_id)
    {
        $member_id = $this->getMember_id();
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($member_id);
        return $student->fetchEmpTestSectionScoreIds($employability_test_id);
    }
    private function getSectionScoreInfo ($section_score_id)
    {
        $member_id = $this->getMember_id();
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($member_id);
        $info = $student->fetchEmpTestSectionScoreInfo($section_score_id);
        $section_score_info = array();
        if ($info instanceof Tnp_Model_MemberInfo_EmployabilityTestSectionScore) {
            $section_score_info['test_section_id'] = $info->getTest_section_id();
            $section_score_info['section_marks'] = $info->getSection_marks();
            $section_score_info['section_percentile'] = $info->getSection_percentile();
        } else {
            $section_score_info = false;
        }
        return $section_score_info;
    }
    private function generateSectionScore ($employability_test_id)
    {
        $score_info = array();
        $score_ids = $this->getTestSectionScoreIds($employability_test_id);
        if (! empty($score_ids)) {
            foreach ($score_ids as $key => $section_score_id) {
                $raw_info = $this->getSectionScoreInfo($section_score_id);
                $test_section_id = $raw_info['test_section_id'];
                $score_info[$test_section_id] = $raw_info;
                $section_info = $this->getTestSectionInfo($test_section_id);
                $score_info[$test_section_id]['test_section_name'] = $section_info['test_section_name'];
            }
        } else {
            $score_info = false;
        }
        return $score_info;
    }
    private function findCertificationsInfo ()
    {
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $student_certifications = array();
        $student_certification_ids = $student->fetchCertificationIds();
        $certification = new Tnp_Model_Certification();
        if (! empty($student_certification_ids)) {
            foreach ($student_certification_ids as $key => $certification_id) {
                $certification->setCertification_id($certification_id);
                $certification->fetchInfo();
                $student_certifications[$certification_id]['name'] = $certification->getCertification_name();
            }
        } else {
            $student_certifications = false;
        }
        return $student_certifications;
    }
    private function findTrainingInfo ()
    {
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $student_training = array();
        $student_training_ids = $student->fetchTrainingIds();
        $training = new Tnp_Model_MemberInfo_Training();
        $training->setMember_id($this->getMember_id());
        if (! empty($student_training_ids)) {
            foreach ($student_training_ids as $key => $training_id) {
                $training->setTraining_id($training_id);
                $training->fetchInfo();
                $student_training[$training_id]['semester'] = $training->getTraining_semester();
                $student_training[$training_id]['institute'] = $training->getTraining_institute();
            }
        } else {
            $student_training = false;
        }
        return $student_training;
    }
    private function findExperienceInfo ()
    {
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $student_experience = array();
        $student_experience_ids = $student->fetchExperienceIds();
        $experience = new Tnp_Model_MemberInfo_Experience();
        if (! empty($student_experience_ids)) {
            foreach ($student_experience_ids as $key => $student_experience_id) {
                $experience->setStudent_experience_id($student_experience_id);
                $experience->fetchInfo();
                $student_experience[$student_experience_id]['organisation'] = $experience->getOrganisation();
                $student_experience[$student_experience_id]['industry_id'] = $experience->getIndustry_id();
                $student_experience[$student_experience_id]['functional_area_id'] = $experience->getFunctional_area_id();
                $student_experience[$student_experience_id]['role_id'] = $experience->getRole_id();
                $student_experience[$student_experience_id]['experience_months'] = $experience->getExperience_months();
                $student_experience[$student_experience_id]['experience_years'] = $experience->getExperience_years();
                $student_experience[$student_experience_id]['organisation'] = $experience->getOrganisation();
                $student_experience[$student_experience_id]['start_date'] = $experience->getStart_date();
                $student_experience[$student_experience_id]['end_date'] = $experience->getEnd_date();
                $student_experience[$student_experience_id]['is_parttime'] = $experience->getIs_parttime();
                $student_experience[$student_experience_id]['description'] = $experience->getDescription();
            }
        } else {
            $student_experience = false;
        }
        return $student_experience;
    }
    private function findCourricularInfo ()
    {
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $co_curr_array = array();
        $student_co_curr = new Tnp_Model_MemberInfo_CoCurricular();
        $student_co_curr->setMember_id($this->getMember_id());
        $info = $student_co_curr->fetchInfo();
        if (! empty($info)) {
            $co_curr_array['achievements'] = $student_co_curr->getAchievements();
            $co_curr_array['activities'] = $student_co_curr->getActivities();
            $co_curr_array['hobbies'] = $student_co_curr->getHobbies();
        } else {
            $co_curr_array = false;
        }
        return $co_curr_array;
    }
    private function findSkillsInfo ()
    {
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $skill_ids = $student->fetchSkillsIds();
        $skill_info = array();
        if (! empty($skill_ids)) {
            $skill_object = new Tnp_Model_Skill();
            foreach ($skill_ids as $skill_id) {
                $skill_object->setSkill_id($skill_id);
                $prof = $student->fetchSkillInfo($skill_id);
                if ($prof instanceof Tnp_Model_MemberInfo_Skills) {
                    $proficiency = $prof->getProficiency();
                }
                $skill_object->fetchInfo();
                $skill_info[$skill_object->getSkill_name()] = $proficiency;
            }
        } else {
            $skill_info = false;
        }
        return $skill_info;
    }
    private function findLanguageInfo ()
    {
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $mem_language = new Tnp_Model_MemberInfo_Language();
        $mem_language->setMember_id($this->getMember_id());
        $info = $mem_language->fetchLanguagesInfo();
        if (! empty($info)) {
            $lang = new Tnp_Model_Language();
            $languages = $lang->fetchLanguages();
            $student_lan_info = array();
            foreach ($info as $key => $proficiency) {
                $student_lan_info[$languages[$key]] = $proficiency;
            }
        } else {
            $student_lan_info = false;
        }
        return $student_lan_info;
    }
    private function findJobPreferred ()
    {
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $job_preferred = $student->fetchJobPreferred();
        return $job_preferred;
    }
    private function saveEmpTest ($info)
    {
        $emp_test = new Tnp_Model_EmpTestInfo_Test();
        $test_details['test_name'] = $info['test_name'];
        $test_details['date'] = $info['date'];
        return $emp_test->save($test_details);
    }
    private function saveEmpTestSection ($info)
    {
        $test_section = new Tnp_Model_EmpTestInfo_Section();
        $section_array = array();
        $section_array['test_section_name'] = $info['test_section_name'];
        $section_array['employability_test_id'] = $info['employability_test_id'];
        return $test_section->saveInfo($section_array);
    }
    private function saveSectionScore ($info)
    {
        $section_score['test_section_id'] = $info['test_section_id'];
        $section_score['employability_test_id'] = $info['employability_test_id'];
        $section_score['section_marks'] = $info['section_marks'];
        $section_score['section_percentile'] = $info['section_percentile'];
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $student->saveEmpTestSectionScore($section_score);
    }
    private function saveEmpTestRecord ($info)
    {
        $record = array();
        $record['employability_test_id'] = $info['employability_test_id'];
        $record['test_regn_no'] = $info['test_regn_no'];
        $record['test_total_score'] = $info['test_total_score'];
        $record['test_percentile'] = $info['test_percentile'];
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $student->saveEmpTestRecord($record);
    }
    private function saveTechFieldInfo ($info)
    {
        $tech_field = new Tnp_Model_TechnicalField();
        $tech_info = array();
        $tech_info['technical_field_name'] = $info['technical_field_name'];
        $tech_info['technical_sector'] = $info['technical_sector'];
        return $tech_field->saveInfo($tech_info);
    }
    private function saveCertificationInfo ($info)
    {
        $certification = new Tnp_Model_Certification();
        $cert_info = array();
        $cert_info['certification_name'] = $info['certification_name'];
        $cert_info['technical_field_id'] = $info['technical_field_id'];
        return $certification->saveInfo($cert_info);
    }
    private function saveStuCertificationInfo ($info)
    {
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $cert_info = array();
        $cert_info['certification_id'] = $info['certification_id'];
        $cert_info['start_date'] = $info['start_date'];
        $cert_info['complete_date'] = $info['complete_date'];
        return $student->saveCertificationInfo($cert_info);
    }
    private function saveTrainingInfo ($info)
    {
        $training = new Tnp_Model_Training();
        $training_info = array();
        $training_info['technical_field_id'] = $info['technical_field_id'];
        $training_info['training_technology'] = $info['training_technology'];
        return $training->saveInfo($training_info);
    }
    private function saveStuTrainingInfo ($info)
    {
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $training_info = array();
        $training_info['training_id'] = $info['training_id'];
        $training_info['training_institute'] = $info['training_institute'];
        $training_info['start_date'] = $info['start_date'];
        $training_info['completion_date'] = $info['completion_date'];
        $training_info['training_semester'] = $info['training_semester'];
        return $student->saveTrainingInfo($training_info);
    }
    private function saveIndustryInfo ($info)
    {
        $industry = new Tnp_Model_Industry();
        $industry_info = array();
        $industry_info['industry_name'] = $info['industry_name'];
        return $industry->saveInfo($industry_info);
    }
    private function saveFunctionalAreaInfo ($info)
    {
        $functional_area = new Tnp_Model_FunctionalArea();
        $functional_area_info = array();
        $functional_area_info['functional_area_name'] = $info['functional_area_name'];
        return $functional_area->saveInfo($functional_area_info);
    }
    private function saveRoleInfo ($info)
    {
        $role = new Tnp_Model_Role();
        $role_info = array();
        $role_info['role_name'] = $info['role_name'];
        return $role->saveInfo($role_info);
    }
    private function saveExperienceInfo ($info)
    {
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $student_experience = array();
        $student_experience['industry_id'] = $info['industry_id'];
        $student_experience['functional_area_id'] = $info['functional_area_id'];
        $student_experience['role_id'] = $info['role_id'];
        $student_experience['experience_months'] = $info['experience_months'];
        $student_experience['experience_years'] = $info['experience_years'];
        $student_experience['organisation'] = $info['organisation'];
        $student_experience['start_date'] = $info['start_date'];
        $student_experience['end_date'] = $info['end_date'];
        $student_experience['is_parttime'] = $info['is_parttime'];
        $student_experience['description'] = $info['description'];
        return $student->saveExperienceInfo($student_experience);
    }
    private function saveLanguageInfo ($info)
    {
        $lan = new Tnp_Model_Language();
        $lan_info = array();
        $lan_info['language_name'] = $info['language_name'];
        return $lan->saveInfo($lan_info);
    }
    private function saveStuLanguageInfo ($info)
    {
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $lan_info = array();
        $lan_info['language_id'] = $info['language_id'];
        $lan_info['proficiency'] = $info['proficiency'];
        return $student->saveLanguageInfo($lan_info);
    }
    private function saveJobPreferred ($info)
    {
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $job_preferred['job_area'] = $info['job_area'];
        return $student->saveJobAreaPreferred($job_preferred);
    }
    private function saveCourricularInfo ($info)
    {
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $co_curricular_info = array();
        $co_curricular_info['achievements'] = $info['achievements'];
        $co_curricular_info['activities'] = $info['activities'];
        $co_curricular_info['hobbies'] = $info['hobbies'];
        return $student->saveCoCurricularInfo($co_curricular_info);
    }
    private function saveSkillsInfo ($info)
    {
        $skills = new Tnp_Model_Skill();
        $skill_info = array();
        $skill_info['skill_name'] = $info['skill_name'];
        $skill_info['skill_field'] = $info['skill_field'];
        return $skills->saveInfo($skill_info);
    }
    private function saveStuSkillsInfo ($info)
    {
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($this->getMember_id());
        $skill_info = array();
        $skill_info['skill_id'] = $info['skill_id'];
        $skill_info['proficiency'] = $info['proficiency'];
        return $student->saveSkillInfo($skill_info);
    }
    /**
     * @todo view changes no class finder
     * Enter description here ...
     * @param unknown_type $data_to_save
     */
    private function saveClassData ($class_info)
    {
        $member_id = $this->getMember_id();
        $class_info['member_id'] = $member_id;
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id($member_id);
        return $student->saveClassInfo($class_info);
    }
    private function saveCriticalData ($data_to_save)
    {
        /**
         * 
         * static for student
         * @var int
         */
        $member_id = $this->getMember_id();
        $data_to_save['member_type_id'] = 1;
        $student_model = new Tnp_Model_Member_Student();
        $student_model->setMember_id($member_id);
        return $student_model->saveCriticalInfo($data_to_save);
    }
}
?>
    