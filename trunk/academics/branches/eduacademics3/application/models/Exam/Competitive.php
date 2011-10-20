<?php
class Acad_Model_Exam_Competitive
{
    protected $_member_id;
    protected $_exam_name;
    protected $_exam_abbr;
    protected $_exam_id;
    protected $_exam_roll_no;
    protected $_exam_date;
    protected $_total_score;
    protected $_all_india_rank;
    protected $_class_properties = array('exam_id', 'exam_roll_no', 'exam_date', 
    'total_score', 'all_india_rank');
    public function getClass_properties ()
    {
        return $this->_class_properties;
    }
    public function setClass_properties ($_class_properties)
    {
        $this->_class_properties = $_class_properties;
    }
    public function getCompetitive_exam_name ()
    {
        return $this->_exam_name;
    }
    public function setCompetitive_exam_name ($_competitive_exam_name)
    {
        $this->_competitive_exam_name = $_competitive_exam_name;
    }
    public function getCompetitive_exam_abbr ()
    {
        return $this->_competitive_exam_abbr;
    }
    public function setCompetitive_exam_abbr ($_competitive_exam_abbr)
    {
        $this->_competitive_exam_abbr = $_competitive_exam_abbr;
    }
    public function getCompetitive_exam_id ()
    {
        return $this->_competitive_exam_id;
    }
    public function setCompetitive_exam_id ($_competitive_exam_id)
    {
        $this->_competitive_exam_id = $_competitive_exam_id;
    }
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    public function getExam_roll_no ()
    {
        return $this->_exam_roll_no;
    }
    public function setExam_roll_no ($_exam_roll_no)
    {
        $this->_exam_roll_no = $_exam_roll_no;
    }
    public function getExam_date ()
    {
        return $this->_exam_date;
    }
    public function setExam_date ($_exam_date)
    {
        $this->_exam_date = $_exam_date;
    }
    public function getTotal_score ()
    {
        return $this->_total_score;
    }
    public function setTotal_score ($_total_score)
    {
        $this->_total_score = $_total_score;
    }
    public function getAll_india_rank ()
    {
        return $this->_all_india_rank;
    }
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
     * @todo
     * Enter description here ...
     */
    public function save ()
    {
        $this->getMapper()->save($this);
    }
    /**
     * Gets AISSCE information of a member
     * You cant use it directly in 
     * controller,
     * first setMember_id and then call getter functions to retrieve properties.
     */
    public function initMemberExamInfo ()
    {
        $options = $this->getMapper()->fetchMemberExamInfo($this);
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
?>