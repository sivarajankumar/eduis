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
    public function viewprofileAction()
    {

    	$this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
       /* $request = $this->getRequest();
        $rollno = $request->getparam('rollno');
        
        $model = new Tnp_Model_Profile_Member_Student();
        $model->setStudent_roll_no($rollno);
       */
    }
    
    public function getprofileAction()
    {
    	$response = array();
    	$memberId = $this->_member_id='1';
    	
/*
 * CERTIFICATION DETAILS
 */    	
    	
 $certi_model = new Tnp_Model_Profile_Components_Certification();
    	$certi_model->setMember_id($memberId);
    	$certi_ids = $certi_model->getMemberCertificationIds();
    	
    	$certi_result = array();
   foreach ($certi_ids as $id)
    	{
    	$certi_model->setCertification_id($id);
    	$certi_model->getMemberCertificationDetails();
    	$certi_name = $certi_model->getCertification_name();
    	$certi_field = $certi_model->getTechnical_field_name();
    	$certi_sector = $certi_model->getTechnical_sector();
    	$certi_start_date = $certi_model->getStart_date();
    	$certi_complete_date = $certi_model->getComplete_date();
    	
    	$certi_result[$id] = array( 'certi_name'=>$certi_name,
    								'certi_field'=>$certi_field,
    								'certi_field'=>$certi_field,
    								'certi_sector'=>$certi_sector,
    								'certi_start_date'=>$certi_start_date,
    								'certi_complete_date'=>$certi_complete_date);
        }
        $response['certifications'] = $certi_result;
        
 /*
 * EXPERIENCE DETAILS
 */    	
           
$exp_model = new Tnp_Model_Profile_Components_Experience();
$exp_result = array();
		
		$exp_model->setMember_id($memberId);
		$exp_ids = $exp_model->getMemberExperienceIds();
		
	foreach ($exp_ids as $id)
	{	
		$exp_model->setStudent_experience_id($id);
		$exp_model->getExperienceDetails();
		$industry = $exp_model->getIndustry_name();
		$functional_area = $exp_model->getFunctional_area_name();
		$role = $exp_model->getRole_name();
		$exp_months = $exp_model->getExperience_months();
		$exp_years = $exp_model->getExperience_years();
		$exp_organisation = $exp_model->getOrganisation();
		$exp_start = $exp_model->getStart_date();
		$exp_compeltion = $exp_model->getEnd_date();
		$part_time = $exp_model->getIs_parttime();
		$exp_result[$id] = array(
							'$industry'=>$industry,
							'$functional_area'=>$functional_area,
							'$role'=>$role,
							'$exp_months'=>$exp_months,
							'$exp_years'=>$exp_years,
							'$exp_organisation'=>$exp_organisation,
							'$exp_start'=>$exp_start,
							'$exp_compeltion'=>$exp_compeltion,
							'$part_time'=>$part_time);
	}	
		
$response['experience'] = $exp_result;

print_r($response);
        
  }
}

