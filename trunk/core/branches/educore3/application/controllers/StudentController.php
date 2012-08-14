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
    private function saveRelativeInfo ($data_to_save)
    {
        $member_id = $this->getMember_id();
        $student_model = new Core_Model_Member_Student();
        foreach ($data_to_save as $relative_id => $relative_info) {
            $relative_info['member_id'] = $member_id;
            $student_model->setMember_id($member_id);
            return $student_model->saveRelativesInfo($relative_info);
        }
    }
    private function saveAddressData ($address_info)
    {
        $member_id = $this->getMember_id();
        $student_model = new Core_Model_Member_Student();
        $student_model->setMember_id($member_id);
        return $student_model->saveAddressInfo($address_info);
    }
    private function saveContactsInfo ($data_to_save)
    {
        $member_id = $this->getMember_id();
        $student_model = new Core_Model_Member_Student();
        foreach ($data_to_save as $contact_type => $contact_data) {
            $contact_data['member_id'] = $member_id;
            $student_model->setMember_id($member_id);
            return $student_model->saveContactsInfo($contact_data);
        }
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
    private function fetchClassInfo ($class_id)
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
                return $stu_class_info;
            } else {
                $message = 'No member_class info for class_id ' . $class_id;
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);
            }
        }
    }
    private function fetchCriticalInfo ()
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
                $critical_data['cast'] = $info->getCast_name();
                $critical_data['nationality'] = $info->getNationality_name();
                $critical_data['religion'] = $info->getReligion_name();
                $critical_data['blood_group'] = $info->getBlood_group();
                $critical_data['dob'] = $info->getDob();
                $critical_data['gender'] = $info->getGender();
                foreach ($critical_data as $key => $value) {
                    if ($value == null) {
                        unset($critical_data[$key]);
                    }
                }
                return $critical_data;
            } else {
                $message = 'Personal info for member id : ' . $member_id .
                 ' not present.';
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);
            }
        }
    }
    private function fetchAddressInfo ()
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
                return $address_info;
            } else {
                $message = 'Address info for member id : ' . $member_id .
                 ' not present.';
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);
            }
        }
    }
    private function fetchContactsInfo ()
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
                        $contact_type_name = $info->getContact_type_name();
                        $contact_info[$contact_type_name]['contact_details'] = $info->getContact_details();
                        foreach ($contact_info as $key => $array) {
                            foreach ($array as $value) {
                                if ($value == null) {
                                    unset($contact_info[$key]);
                                }
                            }
                        }
                    }
                }
                return $contact_info;
            } else {
                $message = 'Contact info for member id : ' . $member_id .
                 ' not present.';
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);
            }
        }
    }
    private function fetchRelativesInfo ()
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
                        $relation_name = $info->getRelation_name();
                        $relatives_info[$relation_name]['contact_details'] = $info->getContact_details();
                        foreach ($relatives_info as $key => $array) {
                            foreach ($array as $value) {
                                if ($value == null) {
                                    unset($relatives_info[$key]);
                                }
                            }
                        }
                    }
                }
                return $relatives_info;
            } else {
                $message = 'Relative\'s info for member id : ' . $member_id .
                 ' not present.';
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);
            }
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
    }
    public function fetchclassinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $class_info = $params['myarray']['class_info'];
        $class_id = $class_info['class_id'];
        $stu_class_info = $this->fetchClassInfo($class_id);
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
            if ($info instanceof Core_Model_StudentRegistration) {
                $registration_info = array();
                $registration_info['registration_id'] = $info->getRegistration_id();
            }
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
        $personal_info = $this->fetchCriticalInfo();
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
        return $this->saveCriticalData($critical_info);
    }
    public function fetchaddressinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $address_info = $this->fetchAddressInfo();
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
            $this->saveAddressData($address_info);
        }
    }
    public function fetchcontactinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $contact_info = $this->fetchContactsInfo();
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
            $this->saveContactsInfo($contact_info);
        }
    }
    public function fetchrelativesinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $relative_info = $this->fetchRelativesInfo();
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
            $this->saveRelativeInfo($relatives_info);
        }
    }
}