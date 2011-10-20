<?php
class Acad_Model_Programme_Diploma
{
    protected $_member_id;
    //protected $_discipline_id;
    protected $_discipline_name;
    protected $_marks_obtained;
    protected $_total_marks;
    protected $_percentage;
    protected $_remarks;
    protected $_passing_year;
    protected $_branch;
    protected $_board;
    protected $_institution;
    protected $_city_name;
    protected $_state_name;
    protected $_board_roll;
    protected $_migration_date;
    protected $_class_properties = array('member_id', 'board_roll_no', 
    'marks_obtained', 'total_marks', 'percentage', 'pcm_percent', 'passing_year', 
    'board', 'school_rank', 'remarks', 'institution', 'city_name', 'state_name', 
    'migration_date');
    protected $_mapper;
    public function getClass_properties ()
    {
        return $this->_class_properties;
    }
    public function setClass_properties ($_class_properties)
    {
        $this->_class_properties = $_class_properties;
    }
    public function getCity_name ()
    {
        return $this->_city_name;
    }
    public function setCity_name ($_city_name)
    {
        $this->_city_name = $_city_name;
    }
    public function getState_name ()
    {
        return $this->_state_name;
    }
    public function setState_name ($_state_name)
    {
        $this->_state_name = $_state_name;
    }
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /*    public function getDiscipline_id ()
    {
        return $this->_discipline_id;
    }
    public function setDiscipline_id ($_discipline_id)
    {
        $this->_discipline_id = $_discipline_id;
    }*/
    public function getDiscipline_name ()
    {
        return $this->_discipline_name;
    }
    public function setDiscipline_name ($_discipline_name)
    {
        $this->_discipline_name = $_discipline_name;
    }
    public function getMarks_obtained ()
    {
        return $this->_marks_obtained;
    }
    public function setMarks_obtained ($_marks_obtained)
    {
        $this->_marks_obtained = $_marks_obtained;
    }
    public function getTotal_marks ()
    {
        return $this->_total_marks;
    }
    public function setTotal_marks ($_total_marks)
    {
        $this->_total_marks = $_total_marks;
    }
    public function getPercentage ()
    {
        return $this->_percentage;
    }
    public function setPercentage ($_percentage)
    {
        $this->_percentage = $_percentage;
    }
    public function getRemarks ()
    {
        return $this->_remarks;
    }
    public function setRemarks ($_remarks)
    {
        $this->_remarks = $_remarks;
    }
    public function getPassing_year ()
    {
        return $this->_passing_year;
    }
    public function setPassing_year ($_passing_year)
    {
        $this->_passing_year = $_passing_year;
    }
    public function getBranch ()
    {
        return $this->_branch;
    }
    public function setBranch ($_branch)
    {
        $this->_branch = $_branch;
    }
    public function getBoard ()
    {
        return $this->_board;
    }
    public function setBoard ($_board)
    {
        $this->_board = $_board;
    }
    public function getInstitution ()
    {
        return $this->_institution;
    }
    public function setInstitution ($_institution)
    {
        $this->_institution = $_institution;
    }
    public function getBoard_roll ()
    {
        return $this->_board_roll;
    }
    public function setBoard_roll ($_board_roll)
    {
        $this->_board_roll = $_board_roll;
    }
    public function getMigration_date ()
    {
        return $this->_migration_date;
    }
    public function setMigration_date ($_migration_date)
    {
        $this->_migration_date = $_migration_date;
    }
    /**
     * Set Subject Mapper
     * @param Acad_Model_Mapper_Programme_Diploma $mapper
     * @return Acad_Model_Programme_Diploma
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Programme_Diploma
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Programme_Diploma());
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
    public function initMemberExamInfo ()
    {
        $options = $this->getMapper()->fetchMemberExamInfo($this);
        $this->setOptions($options);
    }
    /*public function initDisciplineInfo ()
    {
        $options = $this->getMapper()->fetchDisciplineInfo($this);
        $this->setOptions($options);
    }*/
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