<?php

class StudentController extends Zend_Controller_Action
{

    protected $_member_id;
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function getprofileAction()
    
    {
$response = array();
         $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        /*$authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $member_id = $authInfo['member_id']; */
       /* 
       if (isset($member_id) 
        {
           
            $degreemodel->setMember_id($member_id);

            
        }
        elseif ($this->getRequest()->getParam('roll_no'))
        {
            $degreemodel->setStudent_roll_no($this->_roll_no);
            $degreemodel->getMember_id();
            
        }
        else 
        {
           throw new Exception('..................ABE ROLL NUMBER DAAL...........',Zend_Log::ERR);
        }
        */
       $degreemodel = new Acad_Model_Course_SubjectDmc();
       $member_id = $this->_member_id = '1'; 
       $degreemodel->setMember_id($member_id);
       $PassedSemestersInfo= $degreemodel->getPassedSemestersDmcIds();
       $PassedSemestersDmcIds = $PassedSemestersInfo['passedSemestersDmcIds'];
       $PassedSemesters = $PassedSemestersInfo['passedSemesters'];
       //print_r($PassedSemestersDmcIds);
       $result = array();
       for ($i=0;$i<sizeof($PassedSemesters);$i++)
       {
           $dmc_id = $PassedSemestersDmcIds[$i];
           $sem = $PassedSemesters[$i];
               $degreemodel->setDmc_id($dmc_id);
               $degreemodel->setSemster_id($sem);
               $degreemodel->getSemesterDmc();
           $total_marks = $degreemodel->getTotal_marks();
           $marks_obtained = $degreemodel->getMarks_obtained();
           $scaled_marks = $degreemodel->getScaled_marks();
           $percentage = ($marks_obtained/$total_marks)*100;
           $result[$sem]= array(
           						'dmc_id'=>$dmc_id,
           						'semester_id'=>$sem,
           						'marks_obtained'=>$marks_obtained,
           						'total_marks'=>$total_marks,
           						'scaled_marks'=>$scaled_marks,
           						'percentage'=>$percentage
                                );
       }
       
$response['degree'] = $result;
       
$twelfthmodel = new Acad_Model_Exam_Aissce();
           $twelfthmodel->setMember_id($member_id);
           $twelfthmodel->getMemberExamDetails();
           
       $twelfth_roll_no = $twelfthmodel->getBoard_roll();
       $total_marks = $twelfthmodel->getTotal_marks();
       $marks_obtained = $twelfthmodel->getMarks_obtained();
       $percentage = $twelfthmodel->getPercentage();
       $pcm_percentage = $twelfthmodel->getPcm_percent();
       $yop = $twelfthmodel->getPassing_year();
       $board = $twelfthmodel->getBoard();
       $institution = $twelfthmodel->getInstitution();
       
       $twelfthresult = array(
       'twelfth_roll_no'=>$twelfth_roll_no,
       'institution'=>$institution,
       'board'=>$board,
       'yop'=>$yop,
       'marks_obtained'=>$marks_obtained,
       'total_marks'=>$total_marks,
       'percentage'=>$percentage,
       'pcm_percentage'=>$pcm_percentage
       );
       
$response['twelfth'] = $twelfthresult;

$tenthmodel = new Acad_Model_Exam_Aisse();
           $tenthmodel->setMember_id($member_id);
           $tenthmodel->getMemberExamDetails();
           
       $tenth_roll_no = $tenthmodel->getMatric_roll_no();
       $total_marks = $tenthmodel->getMatric_total_marks();
       $marks_obtained = $tenthmodel->getMatric_marks_obtained();
       $percentage = $tenthmodel->getMatric_percentage();
       $yop = $tenthmodel->getMatric_passing_year();
       $board = $tenthmodel->getMatric_board();
       $institution = $tenthmodel->getMatric_institution();
       
       $tenthresult = array(
       'twelfth_roll_no'=>$twelfth_roll_no,
       'institution'=>$institution,
       'board'=>$board,
       'yop'=>$yop,
       'marks_obtained'=>$marks_obtained,
       'total_marks'=>$total_marks,
       'percentage'=>$percentage,
       );
       
$response['tenth'] = $tenthresult;

print_r($response);
echo '<br>';
print_r($response);
///$this->_helper->json($response);
echo '<br>';
       
       
;}

}