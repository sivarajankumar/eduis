<?php
class Tnp_Model_Profile_Components_Certification
{
    protected $_member_certifications_info = array();
    protected $_certification_id;
    protected $_certification_name;
    protected $_technical_field_id;
    protected $_technical_field_name;
    protected $_technical_sector;
    protected $_member_id;
    protected $_start_date;
    protected $_complete_date;
    protected $_mapper;
    protected $_class_properties = array('certification_id', 
    'certification_name', 'technical_field_id', 'technical_field_name', 
    'technical_sector', 'member_id', 'start_date', 'complete_date');
    public function getClass_properties ()
    {
        return $this->_class_properties;
    }
    public function setClass_properties ($_class_properties)
    {
        $this->_class_properties = $_class_properties;
    }
    protected function getMember_certifications_info ()
    {
        $member_certifications_info = $this->_member_certifications_info;
        if (sizeof($member_certifications_info) == 0) {
            $member_certifications_info = $this->getMapper()->fetchMemberCertificationInfo(
            $this);
            $this->setMember_certifications_info($member_certifications_info);
        }
        return $this->_member_certifications_info;
    }
    protected function setMember_certifications_info (
    $_member_certifications_info)
    {
        $this->_member_certifications_info = $_member_certifications_info;
    }
    public function getCertification_id ()
    {
        $certification_id = $this->_certification_id;
        if (! isset($certification_id)) {
            $this->getMapper()->fetchCertification_id($this);
        }
        return $this->_certification_id;
    }
    public function setCertification_id ($_certification_id)
    {
        $this->_certification_id = $_certification_id;
    }
    public function getCertification_name ()
    {
        return $this->_certification_name;
    }
    public function setCertification_name ($_certification_name)
    {
        $this->_certification_name = $_certification_name;
    }
    public function getTechnical_field_id ()
    {
        $technical_field_id = $this->_technical_field_id;
        if (! isset($technical_field_id)) {
            $this->getMapper()->fetchTechnical_field_id($this);
        }
        return $this->_technical_field_id;
    }
    public function setTechnical_field_id ($_technical_field_id)
    {
        $this->_technical_field_id = $_technical_field_id;
    }
    public function getTechnical_field_name ()
    {
        return $this->_technical_field_name;
    }
    public function setTechnical_field_name ($_technical_field_name)
    {
        $this->_technical_field_name = $_technical_field_name;
    }
    public function getTechnical_sector ()
    {
        return $this->_technical_sector;
    }
    public function setTechnical_sector ($_technical_sector)
    {
        $this->_technical_sector = $_technical_sector;
    }
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    public function getStart_date ()
    {
        return $this->_start_date;
    }
    public function setStart_date ($_start_date)
    {
        $this->_start_date = $_start_date;
    }
    public function getComplete_date ()
    {
        return $this->_complete_date;
    }
    public function setComplete_date ($_complete_date)
    {
        $this->_complete_date = $_complete_date;
    }
    /**
     * Set Mapper
     * @param Tnp_Model_Mapper_Profile_Components_Certification $mapper
     * @return Tnp_Model_Profile_Components_Certification
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Profile_Components_Certification
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(
            new Tnp_Model_Mapper_Profile_Components_Certification());
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
     * 
     * Enter description here ...
     */
    public function initMemberCertificationInfo ()
    {
        $certifications_info = $this->getMember_certifications_info();
        $certifications_id = $this->getCertification_id();
        if (! isset($certifications_id)) {
            $error = 'No Certification Id provided';
            throw new Exception($error);
        } else {
            if (! array_key_exists($certifications_id, $certifications_info)) {
                $error = 'Certification Id : ' . $certifications_id . 'for user ' .
                 $this->getMember_id() . ' is invalid';
                throw new Exception($error);
            } else {
                $options = $certifications_info[$certifications_id];
                $this->setOptions($options);
            }
        }
    }
    public function getMemberCertificationIds ()
    {
        $certifications_info = $this->getMember_certifications_info();
        return array_keys($certifications_info);
    }
    public function initCertificationInfo ()
    {
        $options = $this->getMapper()->fetchCertificationInfo($this);
        $this->setOptions($options);
    }
    public function initTechnicalFieldInfo ()
    {
        $options = $this->getMapper()->fetchTechnicalFieldInfo($this);
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
                $error = implode(', ', $invalid_range_keys);
            }
        }
        $user_friendly_message = ' are invalid parameters and therefore, they were not included in search.' .
         "</br>" .
         'Please try again with correct parameters to get more accurate results';
        $deciding_intersection = array_intersect($valid_options, 
        $valid_range_keys);
        Zend_Registry::get('logger')->debug(
        var_export($error . $user_friendly_message));
        echo "</br>";
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