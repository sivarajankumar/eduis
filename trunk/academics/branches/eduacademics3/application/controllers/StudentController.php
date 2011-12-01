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
        $degree = new Acad_Model_Course_Dmc();
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
        $city = $twelfth->getCity_name();
        $state = $twelfth->getState_name();
        $board = $twelfth->getBoard();
        $institution = $twelfth->getInstitution();
        $twelfthresult = array('twelfth_roll_no' => $twelfth_roll_no, 
        'institution' => $institution, 'board' => $board, 'yop' => $yop, 
        'marks_obtained' => $marks_obtained, 'total_marks' => $total_marks, 
        'percentage' => $percentage, 'pcm_percentage' => $pcm_percentage, 
        'city' => $city, 'state' => $state);
        $response['twelfth'] = $twelfthresult;
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
        $state = $twelfth->getState_name();
        $tenth_yop = $tenthmodel->getPassing_year();
        $tenth_board = $tenthmodel->getBoard();
        $city = $tenthmodel->getCity_name();
        $tenth_institution = $tenthmodel->getInstitution();
        $tenthresult = array('tenth_roll_no' => $tenth_roll_no, 
        'institution' => $tenth_institution, 'board' => $tenth_board, 
        'yop' => $tenth_yop, 'marks_obtained' => $tenth_marks_obtained, 
        'total_marks' => $tenth_total_marks, 'percentage' => $tenth_percentage, 
        'city' => $city, 'state' => $state);
        $response['tenth'] = $tenthresult;
        /**
         * RESPONSE
         */
        $callback = $this->getRequest()->getParam('callback');
        echo $callback . '(' . $this->_helper->json($response, false) . ')';
    }
    public function saveprofileAction ()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $stu_sem_data = array('member_id' => $params['member_id'], 
        'department_id' => $params['department_id'], 
        'programme_id' => $params['programme_id'], 
        'semester_id' => $params['semester_id'], 'roll_no' => $params['roll_no']);
        $model = new Acad_Model_Member_StudentSemester();
        $model->initSave();
        $model->enroll($stu_sem_data);
        //
        $model->initSave();
        $model->setSave_student(true);
        $data = array('member_id' => $params['member_id']);
        $model->save($data);
        //
        $twelfth_data = array();
        $tenth_data = array();
        $diploma_data = array();
        $aieee_data = array();
        foreach ($params as $key => $value) {
            $element_id = substr($key, 0, 1);
            switch ($element_id) {
                case ('1'):
                    $twelfth_data[substr($key, 1)] = $value;
                    break;
                case ('2'):
                    $tenth_data[substr($key, 1)] = $value;
                    break;
                case ('3'):
                    $diploma_data[substr($key, 1)] = $value;
                    break;
                case ('4'):
                    $aieee_data[substr($key, 1)] = $value;
                    break;
            }
        }
        if (sizeof($tenth_data) != 0) {
            $tenth_data['member_id'] = $params['member_id'];
            $tenth_model = new Acad_Model_Exam_Aisse();
            $tenth_model->initSave();
            $tenth_model->save($tenth_data);
        }
        if (sizeof($diploma_data) != 0) {
            $diploma_data['member_id'] = $params['member_id'];
            $diploma_model = new Acad_Model_Programme_Diploma();
            $diploma_model->initSave();
            $diploma_model->save($diploma_data);
        }
        if (sizeof($twelfth_data) != 0) {
            $twelfth_data['member_id'] = $params['member_id'];
            $twelfth_model = new Acad_Model_Exam_Aissce();
            $twelfth_model->initSave();
            $twelfth_model->save($twelfth_data);
        }
        if (sizeof($aieee_data) != 0) {
            $aieee_data['member_id'] = $params['member_id'];
            $aieee_data['exam_id'] = '1';
            $aieee_model = new Acad_Model_Exam_Competitive();
            $aieee_model->initSave();
            $aieee_model->save($aieee_data);
        }
    }
    public function testAction ()
    {
        $stu_sem_data = array('member_id' => 123, 'department_id' => 'cse', 
        'programme_id' => 'btech', 'semester_id' => 46, 'roll_no' => 547886);
        $model = new Acad_Model_Member_StudentSemester();
        $model->initSave();
        $model->enroll($stu_sem_data);
        //
        $model->initSave();
        $model->setSave_student(true);
        $data = array('member_id' => 123);
        $model->save($data);
    }
}