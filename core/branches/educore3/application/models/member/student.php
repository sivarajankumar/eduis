<?php
class Core_Model_Member_Student
{
    protected $_member_id;
    protected $_reg_no;
    protected $_cast_id;
    protected $_nationality_id;
    protected $_religion_id;
    protected $_first_name;
    protected $_middle_name;
    protected $_last_name;
    protected $_dob;
    protected $_gender;
    protected $_contact_no;
    protected $_e_mail;
    protected $_marital_status;
    protected $_councelling_no;
    protected $_admission_date;
    protected $_alloted_category;
    protected $_alloted_branch;
    protected $_state_of_domicile;
    protected $_urban;
    protected $_hostel;
    protected $_bus;
    protected $_image_no;
    protected $_blood_group;
    //
    protected $_student_roll_no;
    protected $_department_id;
    protected $_prgramme_id;
    protected $_batch_start;
    protected $_group_id;
    //
    protected $_semster_id;
    //
    protected $_mapper;
    protected $_class_properties = array('member_id', 'reg_no', 'cast_id', 
    'nationality_id', 'religion_id', 'first_name', 'middle_name', 'last_name', 
    'dob', 'gender', 'contact_no', 'e_mail', 'marital_status', 'councelling_no', 
    'admission_date', 'alloted_category', 'alloted_branch', 'state_of_domicile', 
    'urban', 'hostel', 'bus', 'image_no', 'blood_group', 'student_roll_no', 
    'department_id', 'prgramme_id', 'batch_start', 'group_id', 'semster_id');
    public function getBlood_group ()
    {
        return $this->_blood_group;
    }
    public function setBlood_group ($_blood_group)
    {
        $this->_blood_group = $_blood_group;
    }
    public function getClass_properties ()
    {
        return $this->_class_properties;
    }
    public function setClass_properties ($_class_properties)
    {
        $this->_class_properties = $_class_properties;
    }
    /**
     * @return the $_member_id
     */
    public function getMember_id ()
    {
        if (! isset($this->_member_id)) {
            $this->fetchMemberId();
            return $this->_member_id;
        } else {
            return $this->_member_id;
        }
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @return the $_reg_no
     */
    public function getReg_no ()
    {
        return $this->_reg_no;
    }
    /**
     * @param field_type $_reg_no
     */
    public function setReg_no ($_reg_no)
    {
        $this->_reg_no = $_reg_no;
    }
    /**
     * @return the $_cast_id
     */
    public function getCast_id ()
    {
        return $this->_cast_id;
    }
    /**
     * @param field_type $_cast_id
     */
    public function setCast_id ($_cast_id)
    {
        $this->_cast_id = $_cast_id;
    }
    /**
     * @return the $_nationality_id
     */
    public function getNationality_id ()
    {
        return $this->_nationality_id;
    }
    /**
     * @param field_type $_nationality_id
     */
    public function setNationality_id ($_nationality_id)
    {
        $this->_nationality_id = $_nationality_id;
    }
    /**
     * @return the $_religion_id
     */
    public function getReligion_id ()
    {
        return $this->_religion_id;
    }
    /**
     * @param field_type $_religion_id
     */
    public function setReligion_id ($_religion_id)
    {
        $this->_religion_id = $_religion_id;
    }
    /**
     * @return the $_first_name
     */
    public function getFirst_name ()
    {
        return $this->_first_name;
    }
    /**
     * @param field_type $_first_name
     */
    public function setFirst_name ($_first_name)
    {
        $this->_first_name = $_first_name;
    }
    /**
     * @return the $_middle_name
     */
    public function getMiddle_name ()
    {
        return $this->_middle_name;
    }
    /**
     * @param field_type $_middle_name
     */
    public function setMiddle_name ($_middle_name)
    {
        $this->_middle_name = $_middle_name;
    }
    /**
     * @return the $_last_name
     */
    public function getLast_name ()
    {
        return $this->_last_name;
    }
    /**
     * @param field_type $_last_name
     */
    public function setLast_name ($_last_name)
    {
        $this->_last_name = $_last_name;
    }
    /**
     * @return the $_dob
     */
    public function getDob ()
    {
        return $this->_dob;
    }
    /**
     * @param field_type $_dob
     */
    public function setDob ($_dob)
    {
        $this->_dob = $_dob;
    }
    /**
     * @return the $_gender
     */
    public function getGender ()
    {
        return $this->_gender;
    }
    /**
     * @param field_type $_gender
     */
    public function setGender ($_gender)
    {
        $this->_gender = $_gender;
    }
    /**
     * @return the $_contact_no
     */
    public function getContact_no ()
    {
        return $this->_contact_no;
    }
    /**
     * @param field_type $_contact_no
     */
    public function setContact_no ($_contact_no)
    {
        $this->_contact_no = $_contact_no;
    }
    /**
     * @return the $_e_mail
     */
    public function getE_mail ()
    {
        return $this->_e_mail;
    }
    /**
     * @param field_type $_e_mail
     */
    public function setE_mail ($_e_mail)
    {
        $this->_e_mail = $_e_mail;
    }
    /**
     * @return the $_marital_status
     */
    public function getMarital_status ()
    {
        return $this->_marital_status;
    }
    /**
     * @param field_type $_marital_status
     */
    public function setMarital_status ($_marital_status)
    {
        $this->_marital_status = $_marital_status;
    }
    /**
     * @return the $_councelling_no
     */
    public function getCouncelling_no ()
    {
        return $this->_councelling_no;
    }
    /**
     * @param field_type $_councelling_no
     */
    public function setCouncelling_no ($_councelling_no)
    {
        $this->_councelling_no = $_councelling_no;
    }
    /**
     * @return the $_admission_date
     */
    public function getAdmission_date ()
    {
        return $this->_admission_date;
    }
    /**
     * @param field_type $_admission_date
     */
    public function setAdmission_date ($_admission_date)
    {
        $this->_admission_date = $_admission_date;
    }
    /**
     * @return the $_alloted_category
     */
    public function getAlloted_category ()
    {
        return $this->_alloted_category;
    }
    /**
     * @param field_type $_alloted_category
     */
    public function setAlloted_category ($_alloted_category)
    {
        $this->_alloted_category = $_alloted_category;
    }
    /**
     * @return the $_alloted_branch
     */
    public function getAlloted_branch ()
    {
        return $this->_alloted_branch;
    }
    /**
     * @param field_type $_alloted_branch
     */
    public function setAlloted_branch ($_alloted_branch)
    {
        $this->_alloted_branch = $_alloted_branch;
    }
    /**
     * @return the $_state_of_domicile
     */
    public function getState_of_domicile ()
    {
        return $this->_state_of_domicile;
    }
    /**
     * @param field_type $_state_of_domicile
     */
    public function setState_of_domicile ($_state_of_domicile)
    {
        $this->_state_of_domicile = $_state_of_domicile;
    }
    /**
     * @return the $_urban
     */
    public function getUrban ()
    {
        return $this->_urban;
    }
    /**
     * @param field_type $_urban
     */
    public function setUrban ($_urban)
    {
        $this->_urban = $_urban;
    }
    /**
     * @return the $_hostel
     */
    public function getHostel ()
    {
        return $this->_hostel;
    }
    /**
     * @param field_type $_hostel
     */
    public function setHostel ($_hostel)
    {
        $this->_hostel = $_hostel;
    }
    /**
     * @return the $_bus
     */
    public function getBus ()
    {
        return $this->_bus;
    }
    /**
     * @param field_type $_bus
     */
    public function setBus ($_bus)
    {
        $this->_bus = $_bus;
    }
    /**
     * @return the $_image_no
     */
    public function getImage_no ()
    {
        return $this->_image_no;
    }
    /**
     * @param field_type $_image_no
     */
    public function setImage_no ($_image_no)
    {
        $this->_image_no = $_image_no;
    }
    /**
     * @return the $_student_roll_no
     */
    public function getStudent_roll_no ()
    {
        return $this->_student_roll_no;
    }
    /**
     * @param field_type $_student_roll_no
     */
    public function setStudent_roll_no ($_student_roll_no)
    {
        $this->_student_roll_no = $_student_roll_no;
    }
    /**
     * @return the $_department_id
     */
    public function getDepartment_id ()
    {
        return $this->_department_id;
    }
    /**
     * @param field_type $_department_id
     */
    public function setDepartment_id ($_department_id)
    {
        $this->_department_id = $_department_id;
    }
    /**
     * @return the $_prgramme_id
     */
    public function getPrgramme_id ()
    {
        return $this->_prgramme_id;
    }
    /**
     * @param field_type $_prgramme_id
     */
    public function setPrgramme_id ($_prgramme_id)
    {
        $this->_prgramme_id = $_prgramme_id;
    }
    /**
     * @return the $_batch_start
     */
    public function getBatch_start ()
    {
        return $this->_batch_start;
    }
    /**
     * @param field_type $_batch_start
     */
    public function setBatch_start ($_batch_start)
    {
        $this->_batch_start = $_batch_start;
    }
    /**
     * @return the $_group_id
     */
    public function getGroup_id ()
    {
        return $this->_group_id;
    }
    /**
     * @param field_type $_group_id
     */
    public function setGroup_id ($_group_id)
    {
        $this->_group_id = $_group_id;
    }
    /**
     * @return the $_semster_id
     */
    public function getSemster_id ()
    {
        return $this->_semster_id;
    }
    /**
     * @param field_type $_semster_id
     */
    public function setSemster_id ($_semster_id)
    {
        $this->_semster_id = $_semster_id;
    }
    /**
     * Set Mapper
     * @param Core_Model_Mapper_Member_Student $mapper
     * @return Core_Model_Mapper_Member_Student
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Core_Model_Member_StudentMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_Member_Student());
        }
        return $this->_mapper;
    }
    public function __construct (array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    public function __set ($name, $value)
    {
        $method = 'set' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
        }
        $this->$method($value);
    }
    public function __get ($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
        }
    }
    /**
     * used to init an object
     * @param array $options
     */
    public function setOptions ($options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    /**
     * @todo
     * Enter description here ...
     */
    public function save ()
    {
        $this->getMapper()->save($this);
    }
    public function fetchMemberId ()
    {
        $roll_no = $this->getStudent_roll_no();
        if (!empty($roll_no)) {
            $result = $this->getMapper()->fetchMember_id($this);
            $this->setMember_id($result);
        } else {
            throw new Exception('You must set RollNumber first');
        }
    }
    public function fetchRollNumber ()
    {
        $member_id = $this->getMember_id();
        if (!empty($member_id)) {
            $result = $this->getMapper()->fetchStudent_roll_no($this);
            $this->setStudent_roll_no($result);
        } else {
            throw new Exception('You must set MemberId first');
        }
    }
    /**
     * Gets information of a student
     * You cant use it directly in 
     * controller To get info of student,
     * first setMember_id and then call getter functions to retrieve properties.
     */
    public function getStudentInfo ()
    {
        $options = $this->getMapper()->fetchStudentInfo($this);
        $this->setOptions($options);
    }
    /**
     * 
     * Enter description here ...
     * @param array $options containing properties mapped to values
     * @param array $property_range containing properties mapped to array containing upper and lower range
     * @throws Exception when trying to set equality and range both ,for property, at the same time
     * @throws Exception when invalid properties are specified 
     * @return array containing Member Ids
     */
    public function search (array $options = null, array $property_range = null)
    {
        $class_properties = array();
        $options_keys = array();
        $valid_options = array();
        $invalid_options = array();
        $setter_options = array();
        $property_range_keys = array();
        $valid_range_keys = array();
        $invalid_range_keys = array();
        $range = array();
        $error = '';
        $class_properties = $this->getClass_properties();
        if (! empty($options)) {
            $options_keys = array_keys($options);
            $valid_options = array_intersect($options_keys, $class_properties);
            foreach ($valid_options as $valid_option) {
                //$setter_options array is now ready for search
                //but will it participate,is not confirmed
                $setter_options[$valid_option] = $options[$valid_option];
            }
            $invalid_options = array_diff($options_keys, $class_properties);
            if (! empty($invalid_options)) {
                foreach ($invalid_options as $invalid_option) {
                    $error = $error . '  ' . $invalid_option;
                }
            }
        }
        if (! empty($property_range)) {
            $property_range_keys = array_keys($property_range);
            $valid_range_keys = array_intersect($property_range_keys, 
            $class_properties);
            foreach ($valid_range_keys as $valid_range_key) {
                //$range array is now ready for search
                //but will it participate,is not confirmed
                $range[$valid_range_key] = $property_range[$valid_range_key];
            }
            $invalid_range_keys = array_diff($property_range_keys, 
            $class_properties);
            if (! empty($invalid_range_keys)) {
                foreach ($invalid_range_keys as $invalid_range_key) {
                    $error = $error . '  ' . $invalid_range_key;
                }
            }
        }
        $user_friendly_message = $error .
         ' are invalid parameters and therefore were not included in search.' .
         'Please try again with correct parameters to get more accurate results';
        Zend_Registry::get('logger')->debug($user_friendly_message);
        $deciding_intersection = array_intersect($valid_options, 
        $valid_range_keys);
        if (empty($deciding_intersection)) {
            //now we can set off for search operation
            $this->setOptions($setter_options);
            $result = $this->getMapper()->fetchStudents($this, $setter_options, 
            $range);
            return $result;
        } else {
            foreach ($deciding_intersection as $duplicate_entry) {
                $error_1 = $error_1 . '  ' . $duplicate_entry;
            }
            throw new Exception(
            'Range and equality cannot be set for ' . $error_1 .
             ' at the same time');
        }
    }
}