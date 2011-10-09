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
        // action body
    }
    /*
     * returns whole academic profile of student
     */
    public function getprofileAction ()
    {
        $response = array();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        /*$auth_member_id = $authInfo['member_id'];
        if (isset($auth_member_id) )
        {
            $this->setMember_id($member_id);
        }
        elseif ($this->getRequest()->getParam('roll_no'))
        {
            $model->setStudent_roll_no($this->_roll_no);
            $model->getMember_id();
        }
        else 
        {
           throw new Exception('..................ABE ROLL NUMBER DAAL...........',Zend_Log::ERR);
        }*/
        $this->setMember_id(1);
        /**
         * DEGREE DETAILS
         */
        $degree = new Acad_Model_Course_SubjectDmc();
        $passed_semesters = array();
        $degree->setMember_id($this->getMember_id());
        $passed_semesters = $degree->getPassedSemesters();
        $passed_semesters = array();
        $passed_semesters = $degree->getPassedSemesters();
        $dmc = array();
        foreach ($passed_semesters as $passed_semester) {
            $degree->setSemster_id($passed_semester);
            $degree->initSemesterDmcConsidered();
            $dmc_id = $degree->getDmc_id();
            $marks_obtained = $degree->getMarks_obtained();
            $total_marks = $degree->getTotal_marks();
            $scaled_marks = $degree->getScaled_marks();
            $percentage = ($marks_obtained / $total_marks) * 100;
            $dmc[$passed_semester] = array('dmc_id' => $dmc_id, 
            'semester_id' => $passed_semester, 
            'marks_obtained' => $marks_obtained, 'total_marks' => $total_marks, 
            'scaled_marks' => $scaled_marks, 'percentage' => $percentage);
        }
        $response['degree'] = $dmc;
             Zend_Registry::get('logger')->debug($response['degree'] );
        /**
         * TWELFTH DETAILS
         */
        $twelfth = new Acad_Model_Exam_Aissce();
        $twelfth->setMember_id($this->getMember_id());
        $twelfth->initMemberExamInfo();
        $twelfth_roll_no = $twelfth->getBoard_roll_no();
        $total_marks = $twelfth->getTotal_marks();
        $marks_obtained = $twelfth->getMarks_obtained();
        $percentage = $twelfth->getPercentage();
        $pcm_percentage = $twelfth->getPcm_percent();
        $yop = $twelfth->getPassing_year();
        $city = $twelfth->getInstitution_city();
        $state = $twelfth->getInstitution_state();
        $board = $twelfth->getBoard();
        $institution = $twelfth->getInstitution();
        $twelfthresult = array('twelfth_roll_no' => $twelfth_roll_no, 
        'institution' => $institution, 'board' => $board, 'yop' => $yop, 
        'marks_obtained' => $marks_obtained, 'total_marks' => $total_marks, 
        'percentage' => $percentage, 'pcm_percentage' => $pcm_percentage, 
        'city' => $city, 'state' => $state);
        $response['twelfth'] = $twelfthresult;
        Zend_Registry::get('logger')->debug($response['twelfth'] );
        /**
         * TENTH DETAILS
         */
        $tenthmodel = new Acad_Model_Exam_Aisse();
        $tenthmodel->setMember_id($this->getMember_id());
        $tenthmodel->initMemberExamInfo();
        $tenth_roll_no = $tenthmodel->getBoard_roll_no();
        $tenth_total_marks = $tenthmodel->getTotal_marks();
        $tenth_marks_obtained = $tenthmodel->getMarks_obtained();
        $tenth_percentage = $tenthmodel->getPercentage();
        $state = $twelfth->getInstitution_state();
        $tenth_yop = $tenthmodel->getPassing_year();
        $tenth_board = $tenthmodel->getBoard();
        $city = $tenthmodel->getInstitution_city();
        $tenth_institution = $tenthmodel->getInstitution();
        $tenthresult = array('tenth_roll_no' => $tenth_roll_no, 
        'institution' => $tenth_institution, 'board' => $tenth_board, 
        'yop' => $tenth_yop, 'marks_obtained' => $tenth_marks_obtained, 
        'total_marks' => $tenth_total_marks, 'percentage' => $tenth_percentage, 
        'city' => $city, 'state' => $state);
        $response['tenth'] = $tenthresult;
        Zend_Registry::get('logger')->debug($response['tenth']);
    /**
     * RESPONSE
     */
        //Zend_Registry::get('logger')->debug($response);
    /*$callback = $this->getRequest()->getParam('callback');
        echo $callback.'('.$this->_helper->json($response,false).')';*/
    }
}