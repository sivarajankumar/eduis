<?php
class StudentController extends Zend_Controller_Action
{
    protected $_member_id;
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
    {
        /* Initialize action controller here */
    }
    public function indexAction ()
    {
        // action body
    }
    /**
     * 
     *to show the form on view for personal information
     */
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
        //print_r($params);
        $critical_data = array('programme_id' => 'mtech', 
        'department_id' => 'cse', 'semester_id' => '8', 'roll_no' => '2308009', 
        'registration_id' => '08-ECA-238', 'first_name' => 'harsh', 
        'middle_name' => 'kumar', 'last_name' => 'yadav', 'dob' => '1990-01-11', 
        'gender' => 'MALE', 'nationality_id' => '1', 'blood_group' => 'A+', 
        'religion_id' => '1', 'cast_id' => '1', 'email' => 'mtech');
        $relative_data = array(
        '1' => array('name' => 'lal singh', 'office_add' => '123,hmt', 
        'landline_no' => '263923', 'occupation' => 'emp', 
        'designation' => 'manager', 'contact' => '9416375238'), 
        '2' => array('name' => 'susheela', 'office_add' => '147,hmt', 
        'landline_no' => '263923', 'occupation' => 'hf', 'designation' => '', 
        'contact' => '123456789'), 
        '3' => array('name' => 'anon', 'office_add' => '567,hmt', 
        'landline_no' => '879', 'occupation' => 'sssdd', 
        'designation' => 'aaaaa', 'contact' => '769089'));
        $address = array(
        'MAILING/POSTAL/CORRESPONDENCE' => array('postal_code' => '134101', 
        'state' => 'haryana', 'district' => 'pkl', 'city' => 'pinjore', 
        'address' => '147,hmt'), 
        'RESIDENTIAL' => array('postal_code' => '134101', 'state' => 'haryana', 
        'district' => 'pkl', 'city' => 'pinjore', 'address' => '147,hmt'));
        $contacts = array('1' => array('contact_details' => '8901010445'), 
        '2' => array('contact_details' => '263923'));
        $dummy_data = array(
        'myarray' => array('critical_data' => $critical_data, 
        'relative_data' => $relative_data, 'address' => $address, 
        'contact' => $contacts));
        print_r($dummy_data);
      
        /**
         * @todo DB CHANGE ----CAST TO CATEGORY
         * @todo  passing any of array or element in Registration
         * @todo  view --remove urban from form
         * @todo view --add group_id to form
         * @todo view --add contacts 
         */
        $model = new Core_Model_Member_Student();
        foreach ($dummy_data['myarray'] as $category => $value_array) {
            switch ($category) {
                case 'critical_data':
                    /**
                     * 
                     * static for student
                     * @var int
                     */
                    $value_array['member_type_id'] = 1;                        
                    $model->initSave();
                    $this->_member_id = $model->saveCriticalInfo($value_array);
                    /**
                     * @todo define dynamically member_id
                     */
                    $this->setMember_id(1);
                    $model->setMember_id($this->getMember_id());
                    $registration_array['reg_id'] = $value_array['registration_id'];
                    $model->initSave();
                    $model->saveRegistrationInfo($registration_array);
                    break;
                case 'relative_data':
                    foreach ($value_array as $relative_id => $relative_info) {
                        $relative_info['member_id'] = $this->getMember_id();
                        $relative_info['relation_id'] = $relative_id;
                        $model->initSave();
                        $model->saveRelativesInfo($relative_info);
                    }
                    break;
                case 'address':
                    foreach ($value_array as $address_type => $address_fields) {
                        $address_fields['member_id'] = $this->getMember_id();
                        $address_fields['address_type'] = $address_type;
                        $model->initSave();
                        $model->saveAddressInfo($address_fields);
                    }
                    break;
                case 'contact':
                    foreach ($value_array as $contact_type => $contact_data) {
                        $contact_data['member_id'] = $this->getMember_id();
                        $contact_data['contact_type_id'] = $contact_type;
                        $model->initSave();
                        $model->saveContactsInfo($contact_data);
                        break ;
                    }
                default:
                    echo $category;
            }
        }
    }
    public function viewprofileAction ()
    {}
}

