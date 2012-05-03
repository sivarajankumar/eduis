<?php
class StudentController extends Zend_Controller_Action
{
    /**
     * 
     * pick from auth
     * @var unknown_type
     */
    protected $_member_id = 1;
    /**
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
    public function init ()
    {}
    public function indexAction ()
    {
        // action body
    }
    /**
     * 
     *to show the form on view for personal information
     */
    
public function getinfoAction ()
    {
        /*   $request = $this->getRequest();
        //the basic vars like roll dep prog sem mem_id must be saved in session vars 
        */
        $roll_no = $this->getRequest()->getParam('roll_no');
        $department_id = $this->getRequest()->getParam('department_id');
        $programme_id = $this->getRequest()->getParam('programme_id');
        $semester_id = $this->getRequest()->getParam('semester_id');
        $model = new Core_Model_Member_Student();
        $model->setRoll_no($roll_no);
        $model->setDepartment_id($department_id);
        $model->setProgramme_id($programme_id);
        $model->setSemester_id($semester_id);
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
                        ->setHttpResponseCode(400);*/
            }
        
    public function createprofileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
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
        $student_model = new Core_Model_Member_Student();
        foreach ($params['myarray'] as $category => $value_array) {
            switch ($category) {
                case 'critical_data':
                    /**
                     * 
                     * static for student
                     * @var int
                     */
                    $value_array['member_type_id'] = 1;
                    $student_model->initSave();
                    $this->_member_id = $student_model->saveCriticalInfo(
                    $value_array);
                    $member_id = $student_model->getMember_id();
                    $this->setMember_id($member_id);
                    /**
                     * @todo define dynamically member_id
                     */
                    $registration_array = array(
                    'member_id' => $this->getMember_id(), 
                    'registration_id' => $value_array['registration_id']);
                    $admission = array('member_id' => $this->getMember_id(), 
                    'alloted_branch' => $value_array['department_id']);
                    $student_model->initSave();
                    $student_model->saveAdmissionInfo($admission);
                    $student_model->initSave();
                    $student_model->saveRegistrationInfo($registration_array);
                    if ($value_array['semester_id'] == 1) {
                        $batch_identifier = 1;
                    } else {
                        $batch_identifier = 0;
                    }
                    $student_model->setMember_id($this->getMember_id());
                    $class_id = $student_model->fetchClassId(
                    $value_array['semester_id']);
                    $class_array = array('member_id' => $this->getMember_id(), 
                    'class_id' => $class_id, 
                    'group_id' => $value_array['group_id'], 
                    'roll_no' => $value_array['roll_no'], 
                    'is_initial_batch_identifier' => $batch_identifier);
                    $student_model->saveClassInfo($class_array);
                    break;
                case 'relative_data':
                    foreach ($value_array as $relative_id => $relative_info) {
                        $relative_info['member_id'] = $this->getMember_id();
                        $student_model->initSave();
                        $student_model->saveRelativesInfo($relative_info);
                    }
                    break;
                case 'address':
                    foreach ($value_array as $address_type => $address_fields) {
                        $address_fields['member_id'] = $this->getMember_id();
                        $student_model->initSave();
                        $student_model->saveAddressInfo($address_fields);
                    }
                    break;
                case 'contact':
                    foreach ($value_array as $contact_type => $contact_data) {
                        $contact_data['member_id'] = $this->getMember_id();
                        $student_model->initSave();
                        $student_model->saveContactsInfo($contact_data);
                    }
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
        //critical info
        $raw_critical_data = self::fetchcriticalinfo();
        $name['first_name'] = $raw_critical_data['first_name'];
        $name['middle_name'] = $raw_critical_data['middle_name'];
        $name['last_name'] = $raw_critical_data['last_name'];
        $critical_data['name'] = implode(' ', $name);
        $critical_data['cast'] = $raw_critical_data['cast'];
        $critical_data['nationality'] = $raw_critical_data['nationality'];
        $critical_data['religion'] = $raw_critical_data['religion'];
        $critical_data['blood_group'] = $raw_critical_data['blood_group'];
        $critical_data['dob'] = $raw_critical_data['dob'];
        $critical_data['gender'] = $raw_critical_data['gender'];
        //registration info
        $student_model = new Core_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $student_model->fetchCriticalInfo();
        $registration_model = $student_model->fetchRegistrationInfo();
        if ($registration_model instanceof Core_Model_StudentRegistration) {
            $registration_id = $registration_model->getRegistration_id();
        }
        //class info
        $current_class_ids = $student_model->fetchActiveClassIds();
        foreach ($current_class_ids as $current_class_id) {
            $student_class_model = $student_model->fetchClassInfo(
            $current_class_id);
            if ($student_class_model instanceof Core_Model_StudentClass) {
                $page_header['roll_no'] = $student_class_model->getRoll_no();
                $page_header['group_id'] = $student_class_model->getGroup_id();
            }
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
            
            if ($relative_model instanceof Core_Model_MemberRelatives) {
                $relative_data[$relative_model->getRelation_name()]['name'] = $relative_model->getName();
                $relative_data[$relative_model->getRelation_name()]['contact'] = $relative_model->getContact();
                $relative_data[$relative_model->getRelation_name()]['designation'] = $relative_model->getDesignation();
                $relative_data[$relative_model->getRelation_name()]['email'] = $relative_model->getEmail();
                $relative_data[$relative_model->getRelation_name()]['occupation'] = $relative_model->getOccupation();
                $relative_data[$relative_model->getRelation_name()]['office_add'] = $relative_model->getOffice_add();
                $relative_data[$relative_model->getRelation_name()]['landline_no'] = $relative_model->getLandline_no();
               
                
            } elseif (! $relative_model) {
                //relation info not found
            }
        }
        //for address info
        $address_data = array();
        $address_types = $student_model->fetchAddressTypes();
        foreach ($address_types as $address_type) {
            $address_model = $student_model->fetchAddressInfo($address_type);
            if ($address_model instanceof Core_Model_MemberAddress) {
                $address_data[$address_type]['address'] = $address_model->getAddress();
                $address_data[$address_type]['city'] = $address_model->getCity();
                $address_data[$address_type]['district'] = $address_model->getDistrict();
                $address_data[$address_type]['code'] = $address_model->getPostal_code();
                $address_data[$address_type]['state'] = $address_model->getState();
            } elseif (! $address_model) {
                //address info not found
            }
        }
        $contact_data = array();
        $contact_type_ids = $student_model->fetchContactTypeIds();
        foreach ($contact_type_ids as $contact_type_id) {
            $contact_model = $student_model->fetchContactInfo($contact_type_id);
            if ($contact_model instanceof Core_Model_MemberContacts) {
                $contact_data[$contact_type_id]['contact_details'] = $contact_model->getContact_details();
                $contact_data[$contact_type_id]['contact_type_name'] = $contact_model->getContact_type_name();
            } elseif (! $contact_model) {
                //contact info not found
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
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                Zend_Registry::get('logger')->debug($response);
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
                Zend_Registry::get('logger')->debug($response);
                break;
            default:
                ;
                break;
        }
    }
    private function fetchcriticalinfo ()
    {
        $student_model = new Core_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $student_model->fetchCriticalInfo();
        $critical_data['member_id'] = $this->getMember_id();
        $critical_data['first_name'] = $student_model->getFirst_name();
        $critical_data['middle_name'] = $student_model->getMiddle_name();
        $critical_data['last_name'] = $student_model->getLast_name();
        $critical_data['cast'] = $student_model->getCast_name();
        $critical_data['nationality'] = $student_model->getNationality_name();
        $critical_data['religion'] = $student_model->getReligion_name();
        $critical_data['blood_group'] = $student_model->getBlood_group();
        $critical_data['dob'] = $student_model->getDob();
        $critical_data['gender'] = $student_model->getGender();
        $critical_data['member_type_id'] = $student_model->getMember_type_id();
        $critical_data['religion_id'] = $student_model->getReligion_id();
        $critical_data['nationality_id'] = $student_model->getNationality_id();
        $critical_data['cast_id'] = $student_model->getCast_id();
        return $critical_data;
    }
    
    public function fetchcriticalinfoAction()
    {
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        $critical_data = self::fetchcriticalinfo();
        $this->_helper->json($critical_data);
     }
}