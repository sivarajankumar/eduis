<?php
class Acad_Model_Exam_Aissce
{
    protected $_member_id;
    protected $_board_roll_no;
    protected $_marks_obtained;
    protected $_total_marks;
    protected $_percentage;
    protected $_pcm_percent;
    protected $_passing_year;
    protected $_board;
    protected $_school_rank;
    protected $_remarks;
    protected $_institution;
    protected $_city_name;
    protected $_state_name;
    protected $_migration_date;
    protected $_mapper;
    protected $_search_initialised = false;
    protected $_save_initialised = false;
    protected $_class_properties = array('member_id', 'board_roll_no', 
    'marks_obtained', 'total_marks', 'percentage', 'pcm_percent', 'passing_year', 
    'board', 'school_rank', 'remarks', 'institution', 'city_name', 'state_name', 
    'migration_date');
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
    /**
     * @return the $_board_roll_no
     */
    public function getBoard_roll_no ()
    {
        return $this->_board_roll_no;
    }
    /**
     * @param field_type $_board_roll_no
     */
    public function setBoard_roll_no ($_board_roll_no)
    {
        $this->_board_roll_no = $_board_roll_no;
    }
    /**
     * @return the $_marks_obtained
     */
    public function getMarks_obtained ()
    {
        return $this->_marks_obtained;
    }
    /**
     * @param field_type $_marks_obtained
     */
    public function setMarks_obtained ($_marks_obtained)
    {
        $this->_marks_obtained = $_marks_obtained;
    }
    /**
     * @return the $_total_marks
     */
    public function getTotal_marks ()
    {
        return $this->_total_marks;
    }
    /**
     * @param field_type $_total_marks
     */
    public function setTotal_marks ($_total_marks)
    {
        $this->_total_marks = $_total_marks;
    }
    /**
     * @return the $_percentage
     */
    public function getPercentage ()
    {
        return $this->_percentage;
    }
    /**
     * @param field_type $_percentage
     */
    public function setPercentage ($_percentage)
    {
        $this->_percentage = $_percentage;
    }
    /**
     * @return the $_pcm_percent
     */
    public function getPcm_percent ()
    {
        return $this->_pcm_percent;
    }
    /**
     * @param field_type $_pcm_percent
     */
    public function setPcm_percent ($_pcm_percent)
    {
        $this->_pcm_percent = $_pcm_percent;
    }
    /**
     * @return the $_passing_year
     */
    public function getPassing_year ()
    {
        return $this->_passing_year;
    }
    /**
     * @param field_type $_passing_year
     */
    public function setPassing_year ($_passing_year)
    {
        $this->_passing_year = $_passing_year;
    }
    /**
     * @return the $_board
     */
    public function getBoard ()
    {
        return $this->_board;
    }
    /**
     * @param field_type $_board
     */
    public function setBoard ($_board)
    {
        $this->_board = $_board;
    }
    /**
     * @return the $_school_rank
     */
    public function getSchool_rank ()
    {
        return $this->_school_rank;
    }
    /**
     * @param field_type $_school_rank
     */
    public function setSchool_rank ($_school_rank)
    {
        $this->_school_rank = $_school_rank;
    }
    /**
     * @return the $_remarks
     */
    public function getRemarks ()
    {
        return $this->_remarks;
    }
    /**
     * @param field_type $_remarks
     */
    public function setRemarks ($_remarks)
    {
        $this->_remarks = $_remarks;
    }
    /**
     * @return the $_institution
     */
    public function getInstitution ()
    {
        return $this->_institution;
    }
    /**
     * @param field_type $_institution
     */
    public function setInstitution ($_institution)
    {
        $this->_institution = $_institution;
    }
    /**
     * @return the $_city_name
     */
    public function getCity_name ()
    {
        return $this->_city_name;
    }
    /**
     * @param field_type $_city_name
     */
    public function setCity_name ($_city_name)
    {
        $this->_city_name = $_city_name;
    }
    /**
     * @return the $_state_name
     */
    public function getState_name ()
    {
        return $this->_state_name;
    }
    /**
     * @param field_type $_state_name
     */
    public function setState_name ($_state_name)
    {
        $this->_state_name = $_state_name;
    }
    /**
     * @return the $_migration_date
     */
    public function getMigration_date ()
    {
        return $this->_migration_date;
    }
    /**
     * @param field_type $_migration_date
     */
    public function setMigration_date ($_migration_date)
    {
        $this->_migration_date = $_migration_date;
    }
    /**
     * @return the $_search_initialised
     */
    protected function getSearch_initialised ()
    {
        return $this->_search_initialised;
    }
    /**
     * @param field_type $_search_initialised
     */
    protected function setSearch_initialised ($_search_initialised)
    {
        $this->_search_initialised = $_search_initialised;
    }
    /**
     * @return the $_save_initialised
     */
    protected function getSave_initialised ()
    {
        return $this->_save_initialised;
    }
    /**
     * @param field_type $_save_initialised
     */
    protected function setSave_initialised ($_save_initialised)
    {
        $this->_save_initialised = $_save_initialised;
    }
    /**
     * @return the $_class_properties
     */
    public function getClass_properties ()
    {
        return $this->_class_properties;
    }
    /**
     * @param field_type $_class_properties
     */
    public function setClass_properties ($_class_properties)
    {
        $this->_class_properties = $_class_properties;
    }
    /**
     * Set Aissce Mapper
     * @param Acad_Model_Mapper_Exam_Aissce $mapper - Subject Mapper
     * @return Acad_Model_Exam_Aissce
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Exam_Aissce
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Exam_Aissce());
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
    public function init_save ()
    {
        $this->setSave_initialised(true);
        $class_properties = $this->getClass_properties();
        foreach ($class_properties as $property) {
            $p = "_$property";
            unset($this->$p);
        }
    }
    /**
     * Saves object to database
     * @param array $options An associative array of objectProperty mapped to its value.
     * 
     */
    public function save ($options)
    {
        $save_init_status = $this->getSave_initialised();
        if ($save_init_status == true) {
            $class_properties = $this->getClass_properties();
            $options_keys = array_keys($options);
        }
    }
    /**
     * 
     * Enter description here ...
     */
    public function initMemberExamInfo ()
    {
        $options = $this->getMapper()->fetchMemberExamInfo($this);
        $this->setOptions($options);
    }
    /**
     * Filters out valid class properties
     * @param array $options An associative array of objectProperty mapped to its value.
     * 
     */
    protected function validOptions ($options)
    {
        $class_properties = $this->getClass_properties();
        $options_keys = array_keys($options);
        $valid_options = array_intersect($options_keys, $class_properties);
        foreach ($valid_options as $valid_option) {
            $validated_options[$valid_option] = $options[$valid_option];
        }
        return $validated_options;
    }
    /**
     * Filters out invalid class properties
     * @param array $options An associative array of objectProperty mapped to its value.
     * 
     */
    protected function invalidOptions ($options)
    {
        $class_properties = $this->getClass_properties();
        $options_keys = array_keys($options);
        $invalidOptions = array_diff($options_keys, $class_properties);
        foreach ($invalidOptions as $invalidOption) {
            $validation_failed[$invalidOption] = $options[$invalidOption];
        }
        return $validation_failed;
    }
    /**
     * Enter description here ...
     * @param array $options containing properties mapped to values
     * @param array $property_range containing properties mapped to array containing upper and lower range
     * @throws Exception when trying to set equality and range both ,for property, at the same time
     * @throws Exception when invalid properties are specified 
     * @return array containing Member Ids
     */
    public function search (array $options = null, array $property_range = null)
    {
        //declaration necessary because their scope is required to be throughout the function
        $setter_options = array();
        $valid_options = array();
        $invalid_names = array();
        $property_range_keys = array();
        $valid_range_keys = array();
        $invalid_names_1 = array();
        $range = array();
        $error = '';
        $class_properties = $this->getClass_properties();
        if (! empty($options)) {
            //$setter_options array is now ready for search
            //but will it participate,is not confirmed
            $setter_options = $this->validOptions($options);
            $invalid_names = array_keys($this->invalidOptions($options));
            if (! empty($invalid_names)) {
                $error = "<b>" . implode(', ', $invalid_names) . "</b>";
            }
        }
        if (! empty($property_range)) {
            $range = $this->validOptions($property_range);
            $invalid_names_1 = array_keys($this->invalidOptions($property_range));
            if (! empty($invalid_names_1)) {
                $error = "<b>" . implode(', ', $invalid_names_1) . "</b>";
            }
        }
        $error_append = ' are invalid parameters and therefore, they were not included in search.';
        $suggestion = 'Please try again with correct parameters to get more accurate results';
        $message = $error_append . "</br>" . $suggestion;
        $deciding_intersection = array_intersect($valid_options, 
        $valid_range_keys);
        Zend_Registry::get('logger')->debug(var_export($error . $message));
        echo "</br>";
        if (empty($deciding_intersection)) {
            //now we can set off for search operation
            $this->setOptions($setter_options);
            return $this->getMapper()->fetchStudents($this, $setter_options,$range);
        } else {
            $error_1 = implode(', ', $deciding_intersection);
            throw new Exception('Range and equality cannot be set for ' . $error_1 .' at the same time');
        }
    }
}