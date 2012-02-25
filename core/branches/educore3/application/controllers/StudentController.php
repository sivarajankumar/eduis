<?php
class StudentController extends Corez_Base_BaseController
{
    protected $_roll_no;
    protected $_member_id;
    /**
     * @return the $_roll_no
     */
    public function getRoll_no ()
    {
        return $this->_roll_no;
    }
    /**
     * @return the $_member_id
     */
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    /**
     * @param field_type $_roll_no
     */
    public function setRoll_no ($_roll_no)
    {
        $this->_roll_no = $_roll_no;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /*
     * @about Interface.
     */
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->view->assign('controller', $this->_request->getControllerName());
        $this->view->assign('module', $this->_request->getModuleName());
    }
    public function getinfoAction ()
    {
        /*   $request = $this->getRequest();
        $roll_no = $this->getRequest()->getParam('roll_no');
        $department_id = $this->getRequest()->getParam('department_id');
        $programme_id = $this->getRequest()->getParam('programme_id');
        $semester_id = $this->getRequest()->getParam('semester_id');*/
        $model = new Core_Model_Member_Student();
        $model->setRoll_no(2308010);
        $model->setDepartment_id('cse');
        $model->setProgramme_id('btech');
        $model->setSemester_id(6);
        $model->findMemberId();
        $member_id = $model->getMember_id();
        $callback = $this->getRequest()->getParam('callback');
        echo $callback . '(' . $this->_helper->json($member_id, false) . ')';
        //$this->_helper->json($member_id);
        /* $request = $this->getRequest();
        $format = $request->getParam('format', 'json');
        $rollno = $request->getParam('rollno');
        if (isset($rollno)) {
            $result = Core_Model_DbTable_Student::getStudentInfo($rollno);
            switch (strtolower($format)) {
                case 'json':
                    $this->_helper->json($result);
                    return;
                case 'select' :
					echo '<select>';
					echo '<option>Select one</option>';
					foreach ( $result as $key => $row ) {
						echo '<option value="' . $row ['batch_start'] . '">' . $row ['batch_start'] . '</option>';
					}
					echo '</select>';
					
					return;
                case 'xml':
                    return;
                default:
                    $this->getResponse()
                        ->setException('Unsupported format request')
                        ->setHttpResponseCode(400);
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
        }*/
    }
    /**
     * @todo incomplete. the sources of information are not defined
     * @todo must be renamed to getInfoAction($personal = false,$basic = false)
     * this action returns the profile solely on the basis of Member_Id
     */
    public function getprofileAction ()
    {
        $model = new Core_Model_Member_Student();
        $member_id = '1';
        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $model->setMember_id($member_id);
        $model->initStudentInfo();
        $info = array('roll_no' => $model->getRoll_no(), 
        'regn_no' => $model->getReg_no(), 
        'first_name' => $model->getFirst_name(), 
        'middle_name' => $model->getMiddle_name(), 
        'last_name' => $model->getLast_name(), 'gender' => $model->getGender(), 
        'phone_no' => $model->getContact_no(), 'dob' => $model->getDob(), 
        'email' => $model->getE_mail());
        $callback = $this->getRequest()->getParam('callback');
        echo $callback . '(' . $this->_helper->json($info, false) . ')';
         //$this->_helper->json($info);        
    }
    public function searchAction ()
    {
        /*$student = new Core_Model_Member_Student();
        $dob_range = array('from' => 1, 'to' => 2);
        $rel_range = array('from' => 1, 'to' => 3);
        $nat_range = array('from' => 1, 'to' => 3);
        $r = array('check5'=>5,'cast_id' => $dob_range, 'check3' => 3, 
        'religion_id' => $rel_range,'nationality_id'=>$nat_range);
        $test = array('check4'=>5,'first_name' => 'AMRIT','nationality_id'=>1,'check1' => 2, 'check2' => 3);
        echo "<pre>";
        print_r($student->search($test, $r));
        echo "</pre>";*/
        $address = new Core_Model_Address();
        $address->setMember_id(1);
        $address->setAdress_type('COMMUNICATION');
        $address->initAddressInfo();
        $test = array('check4' => 5, 'adress_type' => 'COMMUNICATION', 
        'nationality_id' => 1, 'check1' => 2, 'check2' => 3);
        echo $address->getCity();
        echo "<pre>";
        print_r($address->search($test, null));
        echo "</pre>";
    }
    public function saveprofileAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $model = new Core_Model_Member_Student();
        $model->initSave();
        $model->setSave_stu_dep(true);
        $model->save($params);
        $model->initSave();
        $model->setSave_stu_per(true);
        $model->save($params);
    }
    public function enrollAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        $model = new Core_Model_Member_Student();
        $model->initSave();
        $model->enroll($params);
        $model->setRoll_no($params['roll_no']);
        $model->setDepartment_id($params['department_id']);
        $model->setProgramme_id($params['programme_id']);
        $model->setSemester_id($params['semester_id']);
        $model->findMemberID();
        $member_id = $model->getMember_id();
        $this->_helper->json($member_id);
    }
    /**
     * 
     * in our project member_id works as identifying
     */
    public function getIdentityAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        $model = new Core_Model_Member_Student();
    }
    /**
     * 
     * for testing
     */
    public function testAction ()
    {
        $model = new Core_Model_Member_Student();
        //$options = array('department_id' => 'cse', 'member_id' => 90);
        $options = array('reg_no' => '9-a-2', 'first_name' => 'A', 
        'last_name' => 'S', 'dob' => '2012-02-20', 'gender' => 'MALE', 
        'nationality_id' => 1, 'blood_group_id' => 'A+', 'religion_id' => 1, 
        'cast_id' => 0, 'e_mail' => 'a@a.com', 'member_id' => 1, 
        'programme_id' => 'btech', 'department_id' => 'cse');
        $model->initSave();
        $model->setSave_stu_dep(true);
        $model->save($options);
        $model->initSave();
        $model->setSave_stu_per(true);
        $model->save($options);
        /*$options['member_id'] = 90;
        $options['reg_no'] = 70;
        $options['religion_id'] = 1;
        $options['cast_id'] = 1;
        $options['nationality_id'] = 1;
        $model->save($options);*/
    }
}

   

