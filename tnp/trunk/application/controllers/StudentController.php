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
    public function viewprofileAction ()
    {
        /* $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $rollno = $request->getparam('rollno');
        
        $model = new Tnp_Model_Profile_Member_Student();
        $model->setStudent_roll_no($rollno);*/
    }
    public function getprofileAction ()
    {
        $response = array();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->setMember_id(1);
        $memberId = $this->getMember_id();
        /**
         * CERTIFICATION DETAILS
         */
        $certification = new Tnp_Model_Profile_Components_Certification();
        $certification->setMember_id($memberId);
        $certification_ids = $certification->getMemberCertificationIds();
        $certification_result = array();
        foreach ($certification_ids as $id) {
            $certification->setCertification_id($id);
            $certification->initMemberCertificationInfo();
            //as far member_certification details are concerned ,it includes only period details
            // certication name etc are all certification details... same goes for technical_field details 
            $certification_start_date = $certification->getStart_date();
            $certification_complete_date = $certification->getComplete_date();
            $certification->initCertificationInfo();
            $certification->initTechnicalFieldInfo();
            $certification_name = $certification->getCertification_name();
            $technical_field_name = $certification->getTechnical_field_name();
            $technical_sector = $certification->getTechnical_sector();
            $certification_result[$id] = array(
            'certification_name' => $certification_name, 
            'certification_start_date' => $certification_start_date, 
            'certification_complete_date' => $certification_complete_date, 
            'technical_field_name' => $technical_field_name, 
            'technical_sector' => $technical_sector);
        }
        $response['certifications'] = $certification_result;
        /**
         * EXPERIENCE DETAILS
         */
        $experience = new Tnp_Model_Profile_Components_Experience();
        $experience_result = array();
        $experience->setMember_id($memberId);
        $experience_ids = $experience->getMemberExperienceIds();
        foreach ($experience_ids as $id) {
            $experience->setStudent_experience_id($id);
            $experience->initMemberExperienceDetails();
            $experience->initIndustryInfo();
            $experience->initFunctionalAreaInfo();
            $experience->initRoleInfo();
            $experience_months = $experience->getExperience_months();
            $experience_years = $experience->getExperience_years();
            $organisation = $experience->getOrganisation();
            $start_date = $experience->getStart_date();
            $end_date = $experience->getEnd_date();
            $was_part_time = $experience->getIs_parttime();
            $industry_name = $experience->getIndustry_name();
            $functional_area_name = $experience->getFunctional_area_name();
            $role_name = $experience->getRole_name();
            $experience_result[$id] = array('industry_name' => $industry_name, 
            'functional_area' => $functional_area_name, 'role' => $role_name, 
            'experience_months' => $experience_months, 
            'experience_years' => $experience_years, 
            'experience_organisation' => $organisation, 
            'start_date' => $start_date, 'end_date' => $end_date, 
            'was_part_time' => $was_part_time);
        }
        $response['experience'] = $experience_result;
        /**
         *TRAINING DETAILS 
         *
         */
        $training = new Tnp_Model_Profile_Components_Training();
        $training_result = array();
        $training->setMember_id($memberId);
        $training_ids = $training->getMemberTrainingIds();
        foreach ($training_ids as $id) {
            $training->setTraining_id($id);
            $training->initMemberTrainingInfo();
            $training->initTrainingInfo();
            $training->initTechnicalFieldInfo();
            $training_technology = $training->getTraining_technology();
            $training_field = $training->getTechnical_field_name();
            $training_sector = $training->getTechnical_sector();
            $training_inst = $training->getTraining_institute();
            $training_start = $training->getStart_date();
            $training_end = $training->getCompletion_date();
            $training_sem = $training->getTraining_semester();
            $training_result[$id] = array('training_field' => $training_field, 
            'training_sector' => $training_sector, 
            'training_sector' => $training_sector, 
            'training_technology' => $training_technology, 
            'training_inst' => $training_inst, 
            'training_start' => $training_start, 'training_end' => $training_end, 
            'training_sem' => $training_sem);
        }
        $response['training'] = $training_result;
        /**
         * EMPLOYIBILITY TEST
         */
        $test_result = array();
        $section_result = array();
        $test = new Tnp_Model_Test_Employability();
        $test->setMember_id($memberId);
        $test_ids = array();
        $test_ids = $test->getMemberTestIds();
        foreach ($test_ids as $test_id) {
            $test->setEmployability_test_id($test_id);
            $test->initMemberTestRecord();
            $test->initTestInfo();
            $test_name = $test->getTest_name();
            $test_marks = $test->getTest_total_score();
            $test_percentile = $test->getTest_percentile();
            $test_reg_no = $test->getTest_regn_no();
            $section_ids = array();
            $section_ids = $test->getMemberTestSectionIds();
            foreach ($section_ids as $section_id) {
                $test->setTest_section_id($section_id);
                $test->initMemberSectionRecord();
                $section_marks = $test->getSection_marks();
                $section_percentile = $test->getSection_percentile();
                $test->initTestSectionInfo();
                $section_name = $test->getTest_section_name();
                $section_result[$section_id] = array(
                'section_name' => $section_name, 
                'section_marks' => $section_marks, 
                'section_percentile' => $section_percentile);
            }
            $test_result[$test_id] = array('test_name' => $test_name, 
            'test_marks' => $test_marks, 'test_percentile' => $test_percentile, 
            'test_reg_no' => $test_reg_no, 'sections_info' => $section_result);
        }
        $response['test'] = $test_result;
        /*
         * LANGUAGE KNOWN DETAILS
         */
        $student = new Tnp_Model_Profile_Member_Student();
        $student->setMember_id($memberId);
        $language_result = array();
        $langIds = array();
        $langIds = $student->getMemberLanguageKnownIds();
        foreach ($langIds as $id) {
            $student->setLanguage_id($id);
            $student->initMemberLanguageInfo();
            $language_prof = $student->getLanguage_proficiency();
            $student->initLanguageInfo();
            $language_name = $student->getLanguage_name();
            $language_result[$id] = array('lang_name' => $language_name, 
            'lang_prof' => $language_prof);
        }
        $response['language'] = $language_result;
        /*
         * SKILL DETAILS
         */
        $skill_result = array();
        $skill_ids = $student->getMemberSkillIds();
        foreach ($skill_ids as $id) {
            $student->setSkill_id($id);
            $student->initMemberSkillInfo();
            $student->initSkillInfo();
            $skill_name = $student->getSkill_name();
            $skill_prof = $student->getSkill_proficiency();
            $skill_field = $student->getSkill_field();
            $skill_result[$id] = array('skill_name' => $skill_name, 
            'skill_prof' => $skill_prof, 'skill_field' => $skill_field);
        }
        $response['skillset'] = $skill_result;
        $callback = $this->getRequest()->getParam('callback');
        echo $callback . '(' . $this->_helper->json($response, false) . ')';
    }
    public function searchAction ()
    {}
    
    public function saveprofileAction()
    {
    	
    }
}
