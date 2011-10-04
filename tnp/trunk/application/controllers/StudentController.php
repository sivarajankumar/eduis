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
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $model = new Tnp_Model_Profile_Components_Experience();
        $ind = $model->getIndury_id();
        //$this->view->assign('ind',$ind);
        echo $ind;
        echo '567';
    }
    public function viewprofileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        /* $request = $this->getRequest();
        $rollno = $request->getparam('rollno');
        
        $model = new Tnp_Model_Profile_Member_Student();
        $model->setStudent_roll_no($rollno);
       */
    }
    public function getprofileAction ()
    {
        $response = array();
        $memberId = $this->_member_id = '1';
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        /*
 * CERTIFICATION DETAILS
 */
        $certi_model = new Tnp_Model_Profile_Components_Certification();
        $certi_model->setMember_id($memberId);
        $certi_ids = $certi_model->getMemberCertificationIds();
        $certi_result = array();
        foreach ($certi_ids as $id) {
            $certi_model->setCertification_id($id);
            $certi_model->getMemberCertificationDetails();
            $certi_name = $certi_model->getCertification_name();
            $certi_field = $certi_model->getTechnical_field_name();
            $certi_sector = $certi_model->getTechnical_sector();
            $certi_start_date = $certi_model->getStart_date();
            $certi_complete_date = $certi_model->getComplete_date();
            $certi_result[$id] = array('certi_name' => $certi_name, 
            'certi_field' => $certi_field, 'certi_field' => $certi_field, 
            'certi_sector' => $certi_sector, 
            'certi_start_date' => $certi_start_date, 
            'certi_complete_date' => $certi_complete_date);
        }
        $response['certifications'] = $certi_result;
        /*
 * EXPERIENCE DETAILS
 */
        $exp_model = new Tnp_Model_Profile_Components_Experience();
        $exp_result = array();
        $exp_model->setMember_id($memberId);
        $exp_ids = $exp_model->getMemberExperienceIds();
        foreach ($exp_ids as $id) {
            $exp_model->setStudent_experience_id($id);
            $exp_model->getMemberExperienceDetails();
            $industry = $exp_model->getIndustry_name();
            $functional_area = $exp_model->getFunctional_area_name();
            $role = $exp_model->getRole_name();
            $exp_months = $exp_model->getExperience_months();
            $exp_years = $exp_model->getExperience_years();
            $exp_organisation = $exp_model->getOrganisation();
            $exp_start = $exp_model->getStart_date();
            $exp_compeltion = $exp_model->getEnd_date();
            $part_time = $exp_model->getIs_parttime();
            $exp_result[$id] = array('industry' => $industry, 
            'functional_area' => $functional_area, 'role' => $role, 
            'exp_months' => $exp_months, 'exp_years' => $exp_years, 
            'exp_organisation' => $exp_organisation, 'exp_start' => $exp_start, 
            'exp_compeltion' => $exp_compeltion, 'part_time' => $part_time);
        }
        Zend_Registry::get('logger')->debug($exp_result);
        $response['experience'] = $exp_result;
        /*
 * TRAINING DETAILS
 */
        $tr_model = new Tnp_Model_Profile_Components_Training();
        $tr_result = array();
        $tr_model->setMember_id($memberId);
        $tr_ids = $tr_model->getMemberTrainingIds();
        foreach ($tr_ids as $id) {
            $tr_model->setTraining_id($id);
            $tr_model->getMemberTrainingDetails();
            $tr_field = $tr_model->getTechnical_field_name();
            $tr_sector = $tr_model->getTechnical_sector();
            $tr_technology = $tr_model->getTraining_technology();
            $tr_inst = $tr_model->getTraining_institute();
            $tr_start = $tr_model->getStart_date();
            $tr_end = $tr_model->getCompletion_date();
            $tr_sem = $tr_model->getTraining_semester();
            $tr_result[$id] = array('tr_field' => $tr_field, 
            'tr_sector' => $tr_sector, 'tr_sector' => $tr_sector, 
            'tr_technology' => $tr_technology, 'tr_inst' => $tr_inst, 
            'tr_start' => $tr_start, 'tr_end' => $tr_end, 'tr_sem' => $tr_sem);
        }
        $response['training'] = $tr_result;
        /*
         * EMPLOYIBILITY TEST
         */
        $section_result = array();
        $test_result = array();
        $test_model = new Tnp_Model_Test_Employability();
        $test_model->setMember_id($memberId);
        $test_ids = $test_model->getMemberTestIds();
        foreach ($test_ids as $test_id) {
            $test_model->setEmployability_test_id($test_id);
            $section_ids = $test_model->getMemberTestSectionIds();
            foreach ($section_ids as $section_id) {
                $test_model->setTest_section_id($section_id);
                $test_model->initSectionRecord();
                $section_marks = $test_model->getSection_marks();
                $section_name = $test_model->getTest_section_name();
                $section_percentile = $test_model->getSection_percentile();
                $section_result[$section_id] = array(
                'section_name' => $section_name, 
                'section_marks' => $section_marks, 
                'section_percentile' => $section_percentile);
            }
            $test_model->getMemberTestRecord();
            $test_name = $test_model->getTest_name();
            $test_marks = $test_model->getTest_total_score();
            $test_percentile = $test_model->getTest_percentile();
            $test_reg_no = $test_model->getTest_regn_no();
            $test_result[$test_id] = array('test_name' => $test_name, 
            'test_marks' => $test_marks, 'test_percentile' => $test_percentile, 
            'test_reg_no' => $test_reg_no, 'sections' => $section_result);
        }
        $response['test'] = $test_result;
        /*
         * LANGUAGE KNOWN DETAILS
         */
        $stu_model = new Tnp_Model_Profile_Member_Student();
        $stu_model->setMember_id($memberId);
        $lang_result = array();
        $langIds = $stu_model->getMemberLanguageKnownIds();
        foreach ($langIds as $id) {
            $stu_model->setLanguage_id($id);
            $stu_model->initLanguageDescription();
            $lang_name = $stu_model->getLanguage_name();
            $lang_prof = $stu_model->getLanguage_proficiency();
            $lang_result[$id] = array('lang_name' => $lang_name, 
            'lang_prof' => $lang_prof);
        }
        $response['languages'] = $lang_result;
        /*
         * SKILL DETAILS
         */
        $skill_result = array();
        $skill_ids = $stu_model->getMemberSkillIds();
        foreach ($skill_ids as $id) {
            $stu_model->setSkill_id($id);
            $stu_model->initSkillDescription();
            $skill_name = $stu_model->getSkill_name();
            $skill_prof = $stu_model->getSkill_proficiency();
            $skill_field = $stu_model->getSkill_field();
            $skill_result[$id] = array('skill_name' => $skill_name, 
            'skill_prof' => $skill_prof, 'skill_field' => $skill_field);
        }
        $response['skillset'] = $skill_result;
        Zend_Registry::get('logger')->debug($response);
        
        $callback = $this->getRequest()->getParam('callback');
        echo $callback.'('.$this->_helper->json($response,false).')';
    }
}

