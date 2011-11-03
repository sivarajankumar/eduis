<?php
class Core_Model_Relative
{
    protected $_init_save = false;
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
     * @return the $_relation_id
     */
    public function getRelation_id ()
    {
        return $this->_relation_id;
    }
    /**
     * @param field_type $_relation_id
     */
    public function setRelation_id ($_relation_id)
    {
        $this->_relation_id = $_relation_id;
    }
    /**
     * @return the $_relation_name
     */
    public function getRelation_name ()
    {
        return $this->_relation_name;
    }
    /**
     * @param field_type $_relation_name
     */
    public function setRelation_name ($_relation_name)
    {
        $this->_relation_name = $_relation_name;
    }
    /**
     * @return the $_name
     */
    public function getName ()
    {
        return $this->_name;
    }
    /**
     * @param field_type $_name
     */
    public function setName ($_name)
    {
        $this->_name = $_name;
    }
    /**
     * @return the $_occupation
     */
    public function getOccupation ()
    {
        return $this->_occupation;
    }
    /**
     * @param field_type $_occupation
     */
    public function setOccupation ($_occupation)
    {
        $this->_occupation = $_occupation;
    }
    /**
     * @return the $_designation
     */
    public function getDesignation ()
    {
        return $this->_designation;
    }
    /**
     * @param field_type $_designation
     */
    public function setDesignation ($_designation)
    {
        $this->_designation = $_designation;
    }
    /**
     * @return the $_office_add
     */
    public function getOffice_add ()
    {
        return $this->_office_add;
    }
    /**
     * @param field_type $_office_add
     */
    public function setOffice_add ($_office_add)
    {
        $this->_office_add = $_office_add;
    }
    /**
     * @return the $_contact
     */
    public function getContact ()
    {
        return $this->_contact;
    }
    /**
     * @param field_type $_contact
     */
    public function setContact ($_contact)
    {
        $this->_contact = $_contact;
    }
    /**
     * @return the $_annual_income
     */
    public function getAnnual_income ()
    {
        return $this->_annual_income;
    }
    /**
     * @param field_type $_annual_income
     */
    public function setAnnual_income ($_annual_income)
    {
        $this->_annual_income = $_annual_income;
    }
    /**
     * @return the $_landline_no
     */
    public function getLandline_no ()
    {
        return $this->_landline_no;
    }
    /**
     * @param field_type $_landline_no
     */
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
            $this->setOptions($setter_options);
            $this->getMapper()->save($setter_options, $this);
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
        $validated_options = array();
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