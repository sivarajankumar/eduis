<?php
class Core_Model_Relative
{
    protected $_member_id;
    protected $_relation_id;
    protected $_relation_name;
    protected $_name;
    protected $_occupation;
    protected $_designation;
    protected $_office_add;
    protected $_contact;
    protected $_annual_income;
    protected $_landline_no;
    protected $_class_properties = array('member_id', 'relation_id', 
    'relation_name', 'name', 'occupation', 'designation', 'office_add', 
    'contact', 'annual_income', 'landline_no');
    protected $_mapper;
    public function getClass_properties ()
    {
        return $this->_class_properties;
    }
    public function setClass_properties ($_class_properties)
    {
        $this->_class_properties = $_class_properties;
    }
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    public function getRelation_id ()
    {
        return $this->_relation_id;
    }
    public function setRelation_id ($_relation_id)
    {
        $this->_relation_id = $_relation_id;
    }
    public function getRelation_name ()
    {
        return $this->_relation_name;
    }
    public function setRelation_name ($_relation_name)
    {
        $this->_relation_name = $_relation_name;
    }
    public function getName ()
    {
        return $this->_name;
    }
    public function setName ($_name)
    {
        $this->_name = $_name;
    }
    public function getOccupation ()
    {
        return $this->_occupation;
    }
    public function setOccupation ($_occupation)
    {
        $this->_occupation = $_occupation;
    }
    public function getDesignation ()
    {
        return $this->_designation;
    }
    public function setDesignation ($_designation)
    {
        $this->_designation = $_designation;
    }
    public function getOffice_add ()
    {
        return $this->_office_add;
    }
    public function setOffice_add ($_office_add)
    {
        $this->_office_add = $_office_add;
    }
    public function getContact ()
    {
        return $this->_contact;
    }
    public function setContact ($_contact)
    {
        $this->_contact = $_contact;
    }
    public function getAnnual_income ()
    {
        return $this->_annual_income;
    }
    public function setAnnual_income ($_annual_income)
    {
        $this->_annual_income = $_annual_income;
    }
    public function getLandline_no ()
    {
        return $this->_landline_no;
    }
    public function setLandline_no ($_landline_no)
    {
        $this->_landline_no = $_landline_no;
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
        return $this->$method();
    }
    /**
     * Set Mapper
     * @param Core_Model_Mapper_Relative $mapper
     * @return Core_Model_Relative
     */
    public function setMapper ($_mapper)
    {
        $this->_mapper = $_mapper;
    }
    /**
     * 
     * @return Core_Model_Mapper_Relative
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_Relative());
        }
        return $this->_mapper;
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
    public function initRelativeInfo ()
    {
        $info = $this->getMapper()->fetchRelativeInfo($this);
        $this->setOptions($info);
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