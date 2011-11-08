<?php
class Acad_Model_Exam_Competitive
{
    protected $_init_save = false;
    protected $_member_id;
    protected $_exam_name;
    protected $_exam_abbr;
    protected $_exam_id;
    protected $_exam_roll_no;
    protected $_exam_date;
    protected $_total_score;
    protected $_all_india_rank;
    protected $_mapper;
    /**
     * @return the $_init_save
     */
    protected function getInit_save ()
    {
        return $this->_init_save;
    }
    /**
     * @param field_type $_init_save
     */
    protected function setInit_save ($_init_save)
    {
        $this->_init_save = $_init_save;
    }
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
     * @return the $_exam_name
     */
    public function getExam_name ()
    {
        return $this->_exam_name;
    }
    /**
     * @param field_type $_exam_name
     */
    public function setExam_name ($_exam_name)
    {
        $this->_exam_name = $_exam_name;
    }
    /**
     * @return the $_exam_abbr
     */
    public function getExam_abbr ()
    {
        return $this->_exam_abbr;
    }
    /**
     * @param field_type $_exam_abbr
     */
    public function setExam_abbr ($_exam_abbr)
    {
        $this->_exam_abbr = $_exam_abbr;
    }
    /**
     * @return the $_exam_id
     */
    public function getExam_id ()
    {
        return $this->_exam_id;
    }
    /**
     * @param field_type $_exam_id
     */
    public function setExam_id ($_exam_id)
    {
        $this->_exam_id = $_exam_id;
    }
    /**
     * @return the $_exam_roll_no
     */
    public function getExam_roll_no ()
    {
        return $this->_exam_roll_no;
    }
    /**
     * @param field_type $_exam_roll_no
     */
    public function setExam_roll_no ($_exam_roll_no)
    {
        $this->_exam_roll_no = $_exam_roll_no;
    }
    /**
     * @return the $_exam_date
     */
    public function getExam_date ()
    {
        return $this->_exam_date;
    }
    /**
     * @param field_type $_exam_date
     */
    public function setExam_date ($_exam_date)
    {
        $this->_exam_date = $_exam_date;
    }
    /**
     * @return the $_total_score
     */
    public function getTotal_score ()
    {
        return $this->_total_score;
    }
    /**
     * @param field_type $_total_score
     */
    public function setTotal_score ($_total_score)
    {
        $this->_total_score = $_total_score;
    }
    /**
     * @return the $_all_india_rank
     */
    public function getAll_india_rank ()
    {
        return $this->_all_india_rank;
    }
    /**
     * @param field_type $_all_india_rank
     */
    public function setAll_india_rank ($_all_india_rank)
    {
        $this->_all_india_rank = $_all_india_rank;
    }
    /**
     * Set Subject Mapper
     * @param Acad_Model_Mapper_Exam_Competitive $mapper
     * @return Acad_Model_Exam_Competitive
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Exam_CompetitiveMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Exam_Competitive());
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
     * Gets Competitive exam information of a member
     * 
     */
    public function initMemberExamInfo ()
    {
        $options = $this->getMapper()->fetchMemberExamInfo($this);
        $this->setOptions($options);
    }
    /**
     * Gets Competitive exam information of a member
     * 
     */
    public function initExamInfo ()
    {
        $options = $this->getMapper()->fetchExamInfo($this);
        $this->setOptions($options);
    }
    /**
     * Initialises the save process
     * by unsetting all object properties
     */
    public function initSave ()
    {
        $this->unsetAll();
        $this->setInit_save(true);
    }
    /**
     * Saves the student object to database
     * 
     * @param array $options
     */
    public function save ($options)
    {
        if ($this->getInit_save() == true) {
            $properties = $this->getAllowedProperties();
            $recieved = array_keys($options);
            $valid_props = array_intersect($recieved, $properties);
            foreach ($valid_props as $value) {
                $setter_options[$value] = $options[$value];
            }
            if (! empty($setter_options)) {
                $this->setOptions($setter_options);
                $this->getMapper()->save($setter_options, $this);
            }else{
                throw new Exception('No valid option was supplied for save process');
            }
        } else {
            throw new Exception('Save not initialised');
        }
    }
    protected function unsetAll ()
    {
        $properties = $this->getAllowedProperties();
        foreach ($properties as $name) {
            $str = "set" . ucfirst($name);
            $this->$str(null);
        }
    }
    public function getAllowedProperties ()
    {
        $properties = get_class_vars(get_class($this));
        $names = array_keys($properties);
        $options = array();
        foreach ($names as $name => $value) {
            $options[] = substr($value, 1);
        }
        //put names of all properties you want to deny acess to
        $not_allowed = array('mapper', 'init_save');
        //return on acessible properties
        return array_diff($options, $not_allowed);
    }
    /**
     * Filters out valid options
     * maintaining key value relationship
     * @param array $options An associative array of objectProperty mapped to its value.
     * 
     */
    protected function validOptions ($options)
    {
        $class_properties = $this->getAllowedProperties();
        $options_keys = array_keys($options);
        $valid_options = array_intersect($options_keys, $class_properties);
        foreach ($valid_options as $valid_option) {
            $validated_options[$valid_option] = $options[$valid_option];
        }
        return $validated_options;
    }
    /**
     * Filters out invalid options
     * @param array $options An associative array of objectProperty mapped to its value.
     * 
     */
    protected function invalidOptions ($options)
    {
        $class_properties = $this->getAllowedProperties();
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
        $error1 = '';
        $error2 = '';
        if (! empty($options)) {
            //$setter_options array is now ready for search
            //but will it participate,is not confirmed
            $setter_options = $this->validOptions(
            $options);
            $invalid_names = array_keys($this->invalidOptions($options));
            if (! empty($invalid_names)) {
                $error1 = "<b>" . implode(', ', $invalid_names) . "</b>";
            }
        }
        if (! empty($property_range)) {
            $range = $this->validOptions($property_range);
            $invalid_names_1 = array_keys(
            $this->invalidOptions($property_range));
            if (! empty($invalid_names_1)) {
                $error2 = "<b>" . implode(', ', $invalid_names_1) . "</b>";
            }
        }
        $error_append = ' are invalid parameters and therefore, they were not included in search.';
        $suggestion = 'Please try again with correct parameters to get more accurate results';
        $message = "$error_append " . "</br>" . "$suggestion";
        $deciding_intersection = array_intersect($valid_options, 
        $valid_range_keys);
        if (isset($invalid_names) or isset($invalid_names_1)) {
            Zend_Registry::get('logger')->debug(
            var_export($error1 . ' ' . $error2 . $message));
            echo "</br>";
        }
        if (empty($deciding_intersection)) {
            //now we can set off for search operation
            $this->setOptions($setter_options);
            return $this->getMapper()->fetchStudents($this, $setter_options, 
            $range);
        } else {
            $error = implode(', ', $deciding_intersection);
            throw new Exception(
            'Range and equality cannot be set for ' . $error .
             ' at the same time');
        }
    }
}
?>