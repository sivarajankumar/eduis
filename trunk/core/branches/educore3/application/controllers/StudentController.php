<?php
class StudentController extends Zend_Controller_Action
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
    /**
     * Checks if member is registered in the core,
     * @return true if member_id is registered, false otherwise
     */
    private function memberIdCheck ($member_id_to_check)
    {
        $student = new Core_Model_Member_Student();
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
     * @todo view changes no class finder
     * Enter description here ...
     * @param unknown_type $data_to_save
     */
    private function saveClassInfo ($class_info)
    {
        $member_id = $this->getMember_id();
        $class_info['member_id'] = $member_id;
        $student = new Core_Model_Member_Student();
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
        $student_model = new Core_Model_Member_Student();
        $student_model->setMember_id($member_id);
        return $student_model->saveCriticalInfo($data_to_save);
    }
    private function saveRelativeInfo ($relative_info)
    {
        $member_id = $this->getMember_id();
        $student_model = new Core_Model_Member_Student();
        $relative_info['member_id'] = $member_id;
        $student_model->setMember_id($member_id);
        return $student_model->saveRelativesInfo($relative_info);
    }
    private function saveAddressData ($address_info)
    {
        $member_id = $this->getMember_id();
        $student_model = new Core_Model_Member_Student();
        $student_model->setMember_id($member_id);
        return $student_model->saveAddressInfo($address_info);
    }
    private function saveContactsInfo ($contact_info)
    {
        $member_id = $this->getMember_id();
        $student_model = new Core_Model_Member_Student();
        $student_model->setMember_id($member_id);
        return $student_model->saveContactsInfo($contact_info);
    }
    private function saveAdmissionData ($data_to_save)
    {
        /**
         * 
         * static for student
         * @var int
         */
        $member_id = $this->getMember_id();
        $department_id = $data_to_save['department_id'];
        $student_model = new Core_Model_Member_Student();
        $admission = array('member_id' => $member_id, 
        'alloted_branch' => $department_id);
        $student_model->setMember_id($member_id);
        return $student_model->saveAdmissionInfo($admission);
    }
    private function saveRegistrationInfo ($data_to_save)
    {
        /**
         * 
         * static for student
         * @var int
         */
        $member_id = $this->getMember_id();
        $student_model = new Core_Model_Member_Student();
        $registration_id = $data_to_save['registration_id'];
        $registration_array = array('member_id' => $member_id, 
        'registration_id' => $registration_id);
        $student_model->setMember_id($member_id);
        return $student_model->saveRegistrationInfo($registration_array);
    }
    /**
     * fetches students information for an acdemic class
     * Enter description here ...
     * @param int $class_id
     */
    private function findStuClassInfo ($class_id)
    {
        $member_id = $this->getMember_id();
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $student = new Core_Model_Member_Student();
            $student->setMember_id($member_id);
            $info = $student->fetchClassInfo($class_id);
            if ($info instanceof Core_Model_StudentClass) {
                $stu_class_info = array();
                $stu_class_info['roll_no'] = $info->getRoll_no();
                $stu_class_info['group_id'] = $info->getGroup_id();
                $stu_class_info['start_date'] = $info->getStart_date();
                $stu_class_info['completion_date'] = $info->getCompletion_date();
                foreach ($stu_class_info as $key => $value) {
                    if ($value == null) {
                        unset($stu_class_info[$key]);
                    }
                }
            } else {
                $stu_class_info = false;
                /*$message = 'No member_class info for class_id ' . $class_id;
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);*/
            }
            return $stu_class_info;
        }
    }
    private function findCriticalInfo ()
    {
        $member_id = $this->getMember_id();
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $student = new Core_Model_Member_Student();
            $student->setMember_id($member_id);
            $info = $student->fetchCriticalInfo();
            if ($info instanceof Core_Model_Member_Student) {
                $critical_data['first_name'] = $info->getFirst_name();
                $critical_data['middle_name'] = $info->getMiddle_name();
                $critical_data['last_name'] = $info->getLast_name();
                $critical_data['cast_id'] = $info->getCast_id();
                $critical_data['nationality_id'] = $info->getNationality_id();
                $critical_data['religion_id'] = $info->getReligion_id();
                $critical_data['blood_group'] = $info->getBlood_group();
                $critical_data['dob'] = $info->getDob();
                $critical_data['gender'] = $info->getGender();
                foreach ($critical_data as $key => $value) {
                    if ($value == null) {
                        unset($critical_data[$key]);
                    }
                }
            } else {
                $critical_data = false;
                /*$message = 'Personal info for member id : ' . $member_id .
                 ' not present.';
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);*/
            }
            return $critical_data;
        }
    }
    private function findAddressInfo ()
    {
        $member_id = $this->getMember_id();
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $address = new Core_Model_Mapper_MemberAddress();
            $address_types = $address->fetchAddressTypes($member_id);
            $student = new Core_Model_Member_Student();
            $student->setMember_id($member_id);
            if (is_array($address_types)) {
                $address_info = array();
                foreach ($address_types as $address_type) {
                    $info = $student->fetchAddressInfo($address_type);
                    if ($info instanceof Core_Model_MemberAddress) {
                        $address_info[$address_type]['postal_code'] = $info->getPostal_code();
                        $address_info[$address_type]['city'] = $info->getCity();
                        $address_info[$address_type]['district'] = $info->getDistrict();
                        $address_info[$address_type]['state'] = $info->getState();
                        $address_info[$address_type]['address'] = $info->getAddress();
                        foreach ($address_info as $key => $value) {
                            if ($value == null) {
                                unset($address_info[$key]);
                            }
                        }
                    }
                }
            } else {
                $address_info = false;
                /*$message = 'Address info for member id : ' . $member_id .
                 ' not present.';
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);*/
            }
            return $address_info;
        }
    }
    private function findContactsInfo ()
    {
        $member_id = $this->getMember_id();
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $contact = new Core_Model_Mapper_MemberContacts();
            $contact_type_ids = $contact->fetchContactTypeIds($member_id);
            $student = new Core_Model_Member_Student();
            $student->setMember_id($member_id);
            if (is_array($contact_type_ids)) {
                $contact_info = array();
                foreach ($contact_type_ids as $contact_type_id) {
                    $info = $student->fetchContactInfo($contact_type_id);
                    if ($info instanceof Core_Model_MemberContacts) {
                        $contact_info[$contact_type_id]['contact_details'] = $info->getContact_details();
                        foreach ($contact_info as $key => $array) {
                            foreach ($array as $value) {
                                if ($value == null) {
                                    unset($contact_info[$key]);
                                }
                            }
                        }
                    }
                }
            } else {
                $contact_info = false;
                /*$message = 'Contact info for member id : ' . $member_id .
                 ' not present.';
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);*/
            }
            return $contact_info;
        }
    }
    private function findRelativesInfo ()
    {
        $member_id = $this->getMember_id();
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $relative = new Core_Model_Mapper_MemberRelatives();
            $relation_ids = $relative->fetchRelationIds($member_id);
            $student = new Core_Model_Member_Student();
            $student->setMember_id($member_id);
            if (is_array($relation_ids)) {
                $relatives_info = array();
                foreach ($relation_ids as $relation_id) {
                    $info = $student->fetchRelativeInfo($relation_id);
                    if ($info instanceof Core_Model_MemberRelatives) {
                        $relatives_info[$relation_id]['occupation'] = $info->getOccupation();
                        $relatives_info[$relation_id]['designation'] = $info->getDesignation();
                        $relatives_info[$relation_id]['office_add'] = $info->getOffice_add();
                        $relatives_info[$relation_id]['name'] = $info->getName();
                        $relatives_info[$relation_id]['contact'] = $info->getContact();
                        $relatives_info[$relation_id]['annual_income'] = $info->getAnnual_income();
                        $relatives_info[$relation_id]['landline_no'] = $info->getLandline_no();
                        $relatives_info[$relation_id]['email'] = $info->getEmail();
                        foreach ($relatives_info as $key => $array) {
                            foreach ($array as $k => $value) {
                                if ($value == null) {
                                    unset($relatives_info[$key][$k]);
                                }
                            }
                        }
                    }
                }
            } else {
                $relatives_info = false;
                /*$message = 'Relative\'s info for member id : ' . $member_id .
                 ' not present.';
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);*/
            }
            return $relatives_info;
        }
    }
    private function getActiveClassIds ()
    {
        $member_id = $this->getMember_id();
        $student = new Core_Model_Member_Student();
        $student->setMember_id($member_id);
        $class_ids = $student->fetchActiveClassIds();
        //if (is_array($class_ids)) {
        return $class_ids;
        /*        } else {
            if ($class_ids == false) {
                throw new Exception(
                'Student with member_id : ' . $member_id .
                 ' has not been registered in any Acdemic Class ', 
                Zend_Log::WARN);
            }
        }*/
    }
    private function getAllClassIds ()
    {
        $member_id = $this->getMember_id();
        $student = new Core_Model_Member_Student();
        $student->setMember_id($member_id);
        $class_ids = $student->fetchAllClassIds();
        //if (is_array($class_ids)) {
        return $class_ids;
        /*  } else {
            if ($class_ids == false) {
                throw new Exception(
                'Student with member_id : ' . $member_id .
                 ' has not been registered in any Acdemic Class ', 
                Zend_Log::WARN);
            }
        }*/
    }
    private function findClassInfo ($class_id)
    {
        $httpClient = new Zend_Http_Client();
        $httpClient->setUri('http://' . CORE_SERVER . '/class/getclassinfo');
        $httpClient->setMethod('POST');
        $httpClient->setParameterPost(
        array('class_id' => $class_id, 'format' => 'json'));
        $response = $httpClient->request();
        if ($response->isError()) {
            $class_info = false;
            /*$error = 'ERROR: (' . $response->getStatus() . ') ' .
             $response->getHeader('Message');
            throw new Zend_Exception($error, Zend_Log::ERR);*/
        } else {
            $jsonContent = $response->getBody($response);
            $class_info = Zend_Json::decode($jsonContent);
            return $class_info;
        }
    }
    private function findBatchInfo ($batch_id)
    {
        $httpClient = new Zend_Http_Client();
        $httpClient->setUri('http://' . CORE_SERVER . '/batch/getbatchinfo');
        $httpClient->setMethod('POST');
        $httpClient->setParameterPost(
        array('batch_id' => $batch_id, 'format' => 'json'));
        $response = $httpClient->request();
        if ($response->isError()) {
            $batch_info = false;
            /*$error = 'ERROR: (' . $response->getStatus() . ') ' .
             $response->getHeader('Message');
            throw new Zend_Exception($error, Zend_Log::ERR);*/
        } else {
            $jsonContent = $response->getBody($response);
            $batch_info = Zend_Json::decode($jsonContent);
            return $batch_info;
        }
    }
    /**
     * All links are here
     */
    public function createprofileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function viewclassinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->view->assign('department_id', $this->getDepartment_id());
        $class_ids = $this->getAllClassIds();
        if ($class_ids == false) {
            $this->view->assign('student_class_info', false);
        } else {
            $member_id = $this->getMember_id();
            $student = new Core_Model_Member_Student();
            $student->setMember_id($member_id);
            $raw_class_info = array();
            foreach ($class_ids as $class_id) {
                $info = $this->findStuClassInfo($class_id);
                $class_info = $this->findClassInfo($class_id);
                $batch_id = $class_info['class_info']['batch_id'];
                $raw_class_info[$batch_id] = $info['roll_no'];
            }
            $stu_class_info = array();
            foreach ($raw_class_info as $batch_id => $roll_num) {
                $batch_info = $this->findBatchInfo($batch_id);
                $batch_start = $batch_info['batch_info']['batch_start'];
                $stu_class_info[$batch_start] = $roll_num;
            }
            Zend_Registry::get('logger')->debug(
            'Name of varibale assigned to view is : student_class_info');
            Zend_Registry::get('logger')->debug($stu_class_info);
            $this->view->assign('student_class_info', $stu_class_info);
        }
    }
    public function fetchclassinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $class_info = $params['myarray']['class_info'];
        $class_id = $class_info['class_id'];
        $stu_class_info = $this->findStuClassInfo($class_id);
        Zend_Registry::get('logger')->debug($stu_class_info);
        $this->_helper->json($stu_class_info);
    }
    public function editclassinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $department_id = $this->getDepartment_id();
        $this->view->assign('department_id', $department_id);
    }
    public function saveclassinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $my_array = $params['myarray'];
        $student_class_info = $my_array['class_info'];
        return $this->saveClassInfo($student_class_info);
    }
    public function fetchunvregistrationinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $member_id = $this->getMember_id();
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $student = new Core_Model_Member_Student();
            $student->setMember_id($member_id);
            $info = $student->fetchRegistrationInfo();
            $registration_info = array();
            if ($info instanceof Core_Model_StudentRegistration) {
                $registration_info['registration_id'] = $info->getRegistration_id();
            }
            $registration_info = false;
            Zend_Registry::get('logger')->debug($registration_info);
            $this->_helper->json($registration_info);
        }
    }
    public function viewunvregistrationinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function editunvregistrationinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function saveunvregistrationinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $my_array = $params['myarray'];
        $reg_info = $my_array['registration_info'];
        return $this->saveRegistrationInfo($reg_info);
    }
    /**
     * before calling this function use memberidcheck function
     * Enter description here ...
     * @param int $member_id
     */
    public function fetchpersonalinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $personal_info = $this->findCriticalInfo();
        Zend_Registry::get('logger')->debug($personal_info);
        $this->_helper->json($personal_info);
    }
    public function viewpersonalinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function editpersonalinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function savepersonalinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $my_array = $params['myarray'];
        $critical_info = $my_array['personal_info'];
        Zend_Registry::get('logger')->debug($params);
        return $this->saveCriticalData($critical_info);
    }
    public function fetchaddressinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $address_info = $this->findAddressInfo();
        $this->_helper->json($address_info);
    }
    public function viewaddressinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function editaddressinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function saveaddressinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $my_array = $params['myarray'];
        $all_address_info = $my_array['address_info'];
        foreach ($all_address_info as $address_type => $address_info) {
            $address_info['address_type'] = $address_type;
            $this->saveAddressData($address_info);
        }
    }
    public function fetchcontactinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $contact_info = $this->findContactsInfo();
        $this->_helper->json($contact_info);
    }
    public function viewcontactinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function editcontactinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function savecontactinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $my_array = $params['myarray'];
        $all_contact_info = $my_array['contact_info'];
        foreach ($all_contact_info as $contact_type => $contact_info) {
            $contact_info['contact_type_id'] = $contact_type;
            $this->saveContactsInfo($contact_info);
        }
    }
    public function fetchrelativesinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $relative_info = $this->findRelativesInfo();
        $this->_helper->json($relative_info);
    }
    public function viewrelativesinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function editrelativesinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function saverelativesinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $my_array = $params['myarray'];
        $all_relatives_info = $my_array['relatives_info'];
        foreach ($all_relatives_info as $relatives_type => $relatives_info) {
            $relatives_info['relation_id'] = $relatives_type;
            $this->saveRelativeInfo($relatives_info);
        }
    }
    public function aclconfigAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $o = Zend_Auth::getInstance()->getIdentity();
        $this->_helper->json($o);
        //Zend_Registry::get('logger')->debug($o);
        /*$methods = get_class_methods('StudentController');
        $actions = array();
        foreach ($methods as $value) {
            $actions[] = substr("$value", 0, strpos($value, 'Action'));
        }
        foreach ($actions as $key => $value) {
            if ($value == null) {
                unset($actions[$key]);
            }
        }
        $db = new Zend_Db_Table();
        $delete2 = 'DELETE FROM `core`.`mod_role_resource` WHERE `module_id`=? AND `controller_id`=?';
        $db->getAdapter()->query($delete2, array('main', 'student'));
        $delete1 = 'DELETE FROM `core`.`mod_action` WHERE `module_id`=? AND `controller_id`=?';
        $db->getAdapter()->query($delete1, array('main', 'student'));
        print_r(sizeof($actions));
        $sql = 'INSERT INTO `core`.`mod_action`(`module_id`,`controller_id`,`action_id`) VALUES (?,?,?)';
        foreach ($actions as $action) {
            $bind = array('main', 'student', $action);
            $db->getAdapter()->query($sql, $bind);
        }
        $sql = 'INSERT INTO `core`.`mod_role_resource`(`role_id`,`module_id`,`controller_id`,`action_id`) VALUES (?,?,?,?)';
        foreach ($actions as $action) {
            $bind = array('student', 'main', 'student', $action);
            $db->getAdapter()->query($sql, $bind);
        }*/
    /*foreach ($actions as $action) {
            echo '<pre>';
            print_r($action);
            echo '</pre>';
        }*/
    //Zend_Registry::get('logger')->debug($actions);
    }
}