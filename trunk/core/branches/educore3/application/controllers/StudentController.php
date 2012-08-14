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
     * @deprecated
     * Enter description here ...
     */
    public function createprofileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    ////////////////////////////////////////////////////
    /**
     * finds the class_id according to given data
     * Enter description here ...
     * @deprecated in class controller already done
     * @param int $batch_id
     * @param int $semester_id
     */
    private function getClassId ($batch_id, $semester_id)
    {
        $class = new Core_Model_Class();
        $class->setBatch_id($batch_id);
        $class->setSemester_id($semester_id);
        $class_ids = $class->fetchClassIds(true, true);
        if (is_array($class_ids)) {
            return array_pop($class_ids);
        } else {
            $message = 'No class info for batch_id ' . $batch_id .
             ' and semester_id ' . $semester_id;
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        }
    }
    /**
     * 
     * finds the batch_id according to given data
     * @deprecated in class controller already done
     * @param int $department_id
     * @param int $programme_id
     * @param int $batch_start
     */
    private function getBatchId ($department_id, $programme_id, $batch_start)
    {
        $batch = new Core_Model_Batch();
        $batch->setDepartment_id($department_id);
        $batch->setProgramme_id($programme_id);
        $batch->setBatch_start($batch_start);
        $batch_ids = $batch->fetchBatchIds(true, true, true);
        if (is_array($batch_ids)) {
            return array_pop($batch_ids);
        } else {
            $message = 'No batch info for department_id ' . $department_id .
             ' and programme_id ' . $programme_id . ' and batch_start ' .
             $batch_start;
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        }
    }
    /**
     * fetches students information for an acdemic class
     * Enter description here ...
     * @param int $class_id
     */
    private function fetchClassInfo ($class_id)
    {
        $member_id = $this->getMember_id();
        $student = new Core_Model_Member_Student();
        $student->setMember_id($member_id);
        $info = $student->fetchClassInfo($class_id);
        if ($info instanceof Core_Model_StudentClass) {
            $stu_class_info = array();
            $stu_class_info['roll_no'] = $info->getRoll_no();
            $stu_class_info['group_id'] = $info->getGroup_id();
            $stu_class_info['start_date'] = $info->getStart_date();
            $stu_class_info['completion_date'] = $info->getCompletion_date();
            return $stu_class_info;
        } else {
            $message = 'No member_class info for class_id ' . $class_id;
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        }
    }
    public function viewclassinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function fetchclassinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $class_info = $params['myarray']['class_info'];
        $class_id = $class_info['class_id'];
        $stu_class_info = $this->fetchClassInfoAction($class_id);
        $format = $this->_getParam('format', 'html');
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('student_class_info', $stu_class_info);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' .
                 $this->_helper->json($stu_class_info, false) . ')';
                break;
            case 'json':
                $this->_helper->json($stu_class_info);
                break;
            default:
                ;
                break;
        }
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
        $student_class_info = $my_array['student_class_info'];
        return $this->saveClassInfo($student_class_info);
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
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
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
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
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
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
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
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
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
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    ///////////////////////////////////////////////////////
    /**
     * 
     *to save profile of student
     */
    public function saveprofileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        /**
         * @todo DB CHANGE ----CAST TO CATEGORY
         * @todo  passing any of array or element in Registration
         * @todo  view --remove urban from form
         * @todo view --add group_id to form
         * @todo view --add contacts 
         * @todo view --remove email from critical and add in contacts
         */
        $member_id = $this->getMember_id();
        Zend_Registry::get('logger')->debug($member_id);
        $student_model = new Core_Model_Member_Student();
        foreach ($params['myarray'] as $category => $value_array) {
            switch ($category) {
                case 'critical_data':
                    $this->saveCriticalData($value_array);
                    $this->saveClassInfo($value_array);
                    break;
                case 'relative_data':
                    $this->saveRelativeData($value_array);
                    break;
                case 'address_data':
                    $this->saveAddressData($value_array);
                    break;
                case 'contact_data':
                    $this->saveContactsData($value_array);
                    break;
                default:
                    echo $category;
            }
        }
    }
    /**
     * to view personal profile of student
     * @return html,json,jsonp as requested
     */
    public function viewprofileAction ()
    {
        $response = array();
        $format = $this->_getParam('format', 'html');
        $critical_data = array();
        $member_id = $this->getMember_id();
        //critical info
        $raw_critical_data = self::fetchCriticalInfo($member_id);
        $name['first_name'] = $raw_critical_data['first_name'];
        $name['middle_name'] = $raw_critical_data['middle_name'];
        $name['last_name'] = $raw_critical_data['last_name'];
        $critical_data['name'] = implode(' ', $name);
        $cast_id = $raw_critical_data['cast_id'];
        $nationality_id = $raw_critical_data['nationality_id'];
        $religion_id = $raw_critical_data['religion_id'];
        $cast = new Core_Model_Cast();
        $cast->setCast_id($cast_id);
        $cast->fetchInfo();
        $cast_name = $cast->getCast_name();
        $critical_data['cast'] = $cast_name;
        $nationality = new Core_Model_Nationality();
        $nationality->setNationality_id($nationality_id);
        $nationality->fetchInfo();
        $nationality_name = $nationality->getNationality_name();
        $critical_data['nationality'] = $nationality_name;
        $religion = new Core_Model_Religion();
        $religion->setReligion_id($religion_id);
        $religion->fetchInfo();
        $religion_name = $religion->getReligion_name();
        $critical_data['religion'] = $religion_name;
        $critical_data['blood_group'] = $raw_critical_data['blood_group'];
        $critical_data['dob'] = $raw_critical_data['dob'];
        $critical_data['gender'] = $raw_critical_data['gender'];
        //registration info
        $student_model = new Core_Model_Member_Student();
        $student_model->setMember_id($member_id);
        $registration_model = $student_model->fetchRegistrationInfo();
        if ($registration_model instanceof Core_Model_StudentRegistration) {
            $registration_id = $registration_model->getRegistration_id();
        } else {
            $message = 'Registration info for member id : ' . $member_id .
             ' not present.';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        }
        //class info
        $current_class_ids = $student_model->fetchActiveClassIds();
        if (! empty($current_class_ids)) {
            foreach ($current_class_ids as $current_class_id) {
                $student_class_model = $student_model->fetchClassInfo(
                $current_class_id);
                if ($student_class_model instanceof Core_Model_StudentClass) {
                    $page_header['roll_no'] = $student_class_model->getRoll_no();
                    $page_header['group_id'] = $student_class_model->getGroup_id();
                } elseif ($student_class_model == false) {
                    $message = 'Class info for member id : ' . $member_id .
                     ' not present.';
                    $code = Zend_Log::ERR;
                    throw new Exception($message, $code);
                }
            }
        } else {
            $message = 'Member id : ' . $member_id .
             ' not currently active in any class.';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        }
        //student_class info
        $class_model = new Core_Model_Class();
        $class_model->setClass_id($current_class_id);
        $class_model->fetchInfo();
        $page_header['semester_id'] = $class_model->getSemester_id();
        $batch_id = $student_model->fetchBatchId();
        $batch_model = new Core_Model_Batch();
        $batch_model->setBatch_id($batch_id);
        $batch_model->fetchInfo();
        $page_header['department_id'] = $batch_model->getDepartment_id();
        $page_header['programme_id'] = $batch_model->getProgramme_id();
        //for relative info
        $relative_data = array();
        $relationIds = $student_model->fetchRelationIds();
        foreach ($relationIds as $relation_id) {
            $relative_model = $student_model->fetchRelativeInfo($relation_id);
            if ($relative_model == false) {
                $message = 'Relative\'s info for member id : ' . $member_id .
                 ' not present.';
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);
            } elseif ($relative_model instanceof Core_Model_MemberRelatives) {
                $relative_data[$relative_model->getRelation_name()]['name'] = $relative_model->getName();
                $relative_data[$relative_model->getRelation_name()]['contact'] = $relative_model->getContact();
                $relative_data[$relative_model->getRelation_name()]['designation'] = $relative_model->getDesignation();
                $relative_data[$relative_model->getRelation_name()]['email'] = $relative_model->getEmail();
                $relative_data[$relative_model->getRelation_name()]['occupation'] = $relative_model->getOccupation();
                $relative_data[$relative_model->getRelation_name()]['office_add'] = $relative_model->getOffice_add();
                $relative_data[$relative_model->getRelation_name()]['landline_no'] = $relative_model->getLandline_no();
            }
        }
        //for address info
        $address_data = array();
        $address_types = $student_model->fetchAddressTypes();
        foreach ($address_types as $address_type) {
            $address_model = $student_model->fetchAddressInfo($address_type);
            if ($address_model == false) {
                $message = 'Address info for member id : ' . $member_id .
                 ' not present.';
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);
            } elseif ($address_model instanceof Core_Model_MemberAddress) {
                $address_data[$address_type]['address'] = $address_model->getAddress();
                $address_data[$address_type]['city'] = $address_model->getCity();
                $address_data[$address_type]['district'] = $address_model->getDistrict();
                $address_data[$address_type]['code'] = $address_model->getPostal_code();
                $address_data[$address_type]['state'] = $address_model->getState();
            }
        }
        $contact_data = array();
        $contact_type_ids = $student_model->fetchContactTypeIds();
        foreach ($contact_type_ids as $key => $contact_type_id) {
            $contact_info = $student_model->fetchContactInfo($contact_type_id);
            if ($contact_info instanceof Core_Model_MemberContacts) {
                $contact_type_name = $contact_info->getContact_type_name();
                $contact_data[$contact_type_name]['details'] = $contact_info->getContact_details();
            } elseif ($contact_info == false) {
                $message = 'Contact info for member id : ' . $member_id .
                 ' not present.';
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);
            }
        }
        if (! empty($critical_data)) {
            $response['critical_data'] = $critical_data;
        }
        if (! empty($relative_data)) {
            $response['relative_data'] = $relative_data;
        }
        if (! empty($address_data)) {
            $response['address'] = $address_data;
        }
        if (! empty($contact_data)) {
            $response['contact_data'] = $contact_data;
        }
        if (! empty($page_header)) {
            $response['page_header'] = $page_header;
        }
        Zend_Registry::get('logger')->debug($response);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($critical_data)) {
                    $this->view->assign('critical_data', $critical_data);
                }
                if (! empty($page_header)) {
                    $this->view->assign('page_header', $page_header);
                }
                if (! empty($relative_data)) {
                    $this->view->assign('relative_data', $relative_data);
                }
                if (! empty($address_data)) {
                    $this->view->assign('address', $address_data);
                }
                if (! empty($contact_data)) {
                    $this->view->assign('contact', $contact_data);
                }
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
                break;
            default:
                ;
                break;
        }
    }
    /**
     * can be called from within the core or from outside the core,needs re-designing, member id may be passes explicitly(external call case) or extracted from session (internal call case)
     * Enter description here ...
     */
    public function fetchcriticalinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        $member_id = $this->getMember_id();
        $critical_data = self::fetchCriticalInfo($member_id);
        $this->_helper->json($critical_data);
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
     * before calling this function use memberidcheck function
     * Enter description here ...
     * @param int $member_id
     */
    private function fetchCriticalInfo ($member_id)
    {
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $student = new Core_Model_Member_Student();
            $student->setMember_id($member_id);
            $info = $student->fetchCriticalInfo();
            if ($info == false) {
                $message = 'Critical info for member id : ' . $member_id .
                 ' not present.';
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);
            } else {
                if ($info instanceof Core_Model_Member_Student) {
                    $critical_data['member_id'] = $this->getMember_id();
                    $critical_data['first_name'] = $info->getFirst_name();
                    $critical_data['middle_name'] = $info->getMiddle_name();
                    $critical_data['last_name'] = $info->getLast_name();
                    $critical_data['cast'] = $info->getCast_name();
                    $critical_data['nationality'] = $info->getNationality_name();
                    $critical_data['religion'] = $info->getReligion_name();
                    $critical_data['blood_group'] = $info->getBlood_group();
                    $critical_data['dob'] = $info->getDob();
                    $critical_data['gender'] = $info->getGender();
                    $critical_data['member_type_id'] = $info->getMember_type_id();
                    $critical_data['religion_id'] = $info->getReligion_id();
                    $critical_data['nationality_id'] = $info->getNationality_id();
                    $critical_data['cast_id'] = $info->getCast_id();
                    return $critical_data;
                }
            }
        }
    }
    /**
     * @todo view changes no class finder
     * Enter description here ...
     * @param unknown_type $data_to_save
     */
    private function saveClassInfo ($data_to_save)
    {
        $member_id = $this->getMember_id();
        $class_info = array('member_id' => $member_id, 
        'class_id' => $data_to_save['class_id'], 
        'group_id' => $data_to_save['group_id'], 
        'roll_no' => $data_to_save['roll_no'], 
        'start_date' => $data_to_save['start_date'], 
        'completion_date' => $data_to_save['completion_date']);
        $student = new Core_Model_Member_Student();
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
        $student_model->saveCriticalInfo($data_to_save);
    }
    private function saveRelativeData ($data_to_save)
    {
        $member_id = $this->getMember_id();
        $student_model = new Core_Model_Member_Student();
        foreach ($data_to_save as $relative_id => $relative_info) {
            $relative_info['member_id'] = $member_id;
            $student_model->setMember_id($member_id);
            $student_model->saveRelativesInfo($relative_info);
        }
    }
    private function saveAddressData ($data_to_save)
    {
        $member_id = $this->getMember_id();
        $student_model = new Core_Model_Member_Student();
        foreach ($data_to_save as $address_type => $address_fields) {
            $address_fields['member_id'] = $member_id;
            $student_model->setMember_id($member_id);
            $student_model->saveAddressInfo($address_fields);
        }
    }
    private function saveContactsData ($data_to_save)
    {
        $member_id = $this->getMember_id();
        $student_model = new Core_Model_Member_Student();
        foreach ($data_to_save as $contact_type => $contact_data) {
            $contact_data['member_id'] = $member_id;
            $student_model->setMember_id($member_id);
            $student_model->saveContactsInfo($contact_data);
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
        $student_model->saveAdmissionInfo($admission);
    }
    private function saveRegistrationData ($data_to_save)
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
        $student_model->saveRegistrationInfo($registration_array);
    }
}