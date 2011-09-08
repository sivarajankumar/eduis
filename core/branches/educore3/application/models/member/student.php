<?php
class Core_Model_Member_Student
{
    protected $_member_id;
    protected $_reg_no;
    protected $_cast_id;
    protected $_blood_group_id;
    protected $_nationality_id;
    protected $_religion_id;
    //protected $_student_roll_no;
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
    protected $_mapper;
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    public function getReg_no ()
    {
        return $this->_reg_no;
    }
    public function setReg_no ($_reg_no)
    {
        $this->_reg_no = $_reg_no;
    }
    public function getCast_id ()
    {
        return $this->_cast_id;
    }
    public function setCast_id ($_cast_id)
    {
        $this->_cast_id = $_cast_id;
    }
    public function getBlood_group_id ()
    {
        return $this->_blood_group_id;
    }
    public function setBlood_group_id ($_blood_group_id)
    {
        $this->_blood_group_id = $_blood_group_id;
    }
    public function getNationality_id ()
    {
        return $this->_nationality_id;
    }
    public function setNationality_id ($_nationality_id)
    {
        $this->_nationality_id = $_nationality_id;
    }
    public function getReligion_id ()
    {
        return $this->_religion_id;
    }
    public function setReligion_id ($_religion_id)
    {
        $this->_religion_id = $_religion_id;
    }
    /*public function getStudent_roll_no ()
    {
        return $this->_student_roll_no;
    }
    public function setStudent_roll_no ($_student_roll_no)
    {
        $this->_student_roll_no = $_student_roll_no;
    }*/
    public function getFirst_name ()
    {
        return $this->_first_name;
    }
    public function setFirst_name ($_first_name)
    {
        $this->_first_name = $_first_name;
    }
    public function getMiddle_name ()
    {
        return $this->_middle_name;
    }
    public function setMiddle_name ($_middle_name)
    {
        $this->_middle_name = $_middle_name;
    }
    public function getLast_name ()
    {
        return $this->_last_name;
    }
    public function setLast_name ($_last_name)
    {
        $this->_last_name = $_last_name;
    }
    public function getDob ()
    {
        return $this->_dob;
    }
    public function setDob ($_dob)
    {
        $this->_dob = $_dob;
    }
    public function getGender ()
    {
        return $this->_gender;
    }
    public function setGender ($_gender)
    {
        $this->_gender = $_gender;
    }
    public function getContact_no ()
    {
        return $this->_contact_no;
    }
    public function setContact_no ($_contact_no)
    {
        $this->_contact_no = $_contact_no;
    }
    public function getE_mail ()
    {
        return $this->_e_mail;
    }
    public function setE_mail ($_e_mail)
    {
        $this->_e_mail = $_e_mail;
    }
    public function getMarital_status ()
    {
        return $this->_marital_status;
    }
    public function setMarital_status ($_marital_status)
    {
        $this->_marital_status = $_marital_status;
    }
    public function getCouncelling_no ()
    {
        return $this->_councelling_no;
    }
    public function setCouncelling_no ($_councelling_no)
    {
        $this->_councelling_no = $_councelling_no;
    }
    public function getAdmission_date ()
    {
        return $this->_admission_date;
    }
    public function setAdmission_date ($_admission_date)
    {
        $this->_admission_date = $_admission_date;
    }
    public function getAlloted_category ()
    {
        return $this->_alloted_category;
    }
    public function setAlloted_category ($_alloted_category)
    {
        $this->_alloted_category = $_alloted_category;
    }
    public function getAlloted_branch ()
    {
        return $this->_alloted_branch;
    }
    public function setAlloted_branch ($_alloted_branch)
    {
        $this->_alloted_branch = $_alloted_branch;
    }
    public function getState_of_domicile ()
    {
        return $this->_state_of_domicile;
    }
    public function setState_of_domicile ($_state_of_domicile)
    {
        $this->_state_of_domicile = $_state_of_domicile;
    }
    public function getUrban ()
    {
        return $this->_urban;
    }
    public function setUrban ($_urban)
    {
        $this->_urban = $_urban;
    }
    public function getHostel ()
    {
        return $this->_hostel;
    }
    public function setHostel ($_hostel)
    {
        $this->_hostel = $_hostel;
    }
    public function getBus ()
    {
        return $this->_bus;
    }
    public function setBus ($_bus)
    {
        $this->_bus = $_bus;
    }
    public function getImage_no ()
    {
        return $this->_image_no;
    }
    public function setImage_no ($_image_no)
    {
        $this->_image_no = $_image_no;
    }
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
            $this->setMapper(new Core_Model_Member_StudentMapper());
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
            throw new Zend_Exception('Invalid property specified');
        }
        $this->$method($value);
    }
    public function __get ($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw new Zend_Exception('Invalid property specified');
        }
        return $this->$method();
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
    /**
     * first set properties of object, according to which you want
     * to search,using constructor, then call the search function
     * 
     */
    public function search ()
    {
        return $this->getMapper()->fetchStudents($this);
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
}