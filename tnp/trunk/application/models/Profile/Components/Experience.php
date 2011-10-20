<?php
class Tnp_Model_Profile_Components_Experience
{
    protected $_member_experiences_info = array();
    protected $_student_experience_id;
    protected $_member_id;
    protected $_industry_id;
    protected $_industry_name;
    protected $_functional_area_id;
    protected $_functional_area_name;
    protected $_role_id;
    protected $_role_name;
    protected $_experience_months;
    protected $_experience_years;
    protected $_organisation;
    protected $_start_date;
    protected $_end_date;
    protected $_is_parttime;
    protected $_description;
    protected $_mapper;
    protected $_class_properties = array('student_experience_id', 'member_id', 
    'industry_id', 'functional_area_id', 'functional_area_name', 'role_id', 
    'role_name', 'experience_months', 'experience_years', 'organisation', 
    'start_date', 'end_date', 'is_parttime', 'description');
    public function getClass_properties ()
    {
        return $this->_class_properties;
    }
    public function setClass_properties ($_class_properties)
    {
        $this->_class_properties = $_class_properties;
    }
    public function getMember_experiences_info ()
    {
        $member_experiences_info = $this->_member_experiences_info;
        if (sizeof($member_experiences_info) == 0) {
            $member_experiences_info = $this->getMapper()->fetchMemberExperienceInfo(
            $this);
            $this->setMember_experiences_info($member_experiences_info);
        }
        return $this->_member_experiences_info;
    }
    public function setMember_experiences_info ($_member_experiences_info)
    {
        $this->_member_experiences_info = $_member_experiences_info;
    }
    public function getStudent_experience_id ()
    {
        return $this->_student_experience_id;
    }
    public function setStudent_experience_id ($_student_experience_id)
    {
        $this->_student_experience_id = $_student_experience_id;
    }
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    public function getIndustry_id ()
    {
        $industry_id = $this->_industry_id;
        if (! isset($industry_id)) {
            $this->getMapper()->fetchIndustry_id($this);
        }
        return $this->_industry_id;
    }
    public function setIndustry_id ($_industry_id)
    {
        $this->_industry_id = $_industry_id;
    }
    public function getIndustry_name ()
    {
        return $this->_industry_name;
    }
    public function setIndustry_name ($_industry_name)
    {
        $this->_industry_name = $_industry_name;
    }
    public function getFunctional_area_id ()
    {
        $functional_area_id = $this->_functional_area_id;
        if (! isset($functional_area_id)) {
            $this->getMapper()->fetchFunctional_area_id($this);
        }
        return $this->_functional_area_id;
    }
    public function setFunctional_area_id ($_functional_area_id)
    {
        $this->_functional_area_id = $_functional_area_id;
    }
    public function getFunctional_area_name ()
    {
        return $this->_functional_area_name;
    }
    public function setFunctional_area_name ($_functional_area_name)
    {
        $this->_functional_area_name = $_functional_area_name;
    }
    public function getRole_id ()
    {
        $role_id = $this->_role_id;
        if (! isset($role_id)) {
            $this->getMapper()->fetchRole_id($this);
        }
        return $this->_role_id;
    }
    public function setRole_id ($_role_id)
    {
        $this->_role_id = $_role_id;
    }
    public function getRole_name ()
    {
        return $this->_role_name;
    }
    public function setRole_name ($_role_name)
    {
        $this->_role_name = $_role_name;
    }
    public function getExperience_months ()
    {
        return $this->_experience_months;
    }
    public function setExperience_months ($_experience_months)
    {
        $this->_experience_months = $_experience_months;
    }
    public function getExperience_years ()
    {
        return $this->_experience_years;
    }
    public function setExperience_years ($_experience_years)
    {
        $this->_experience_years = $_experience_years;
    }
    public function getOrganisation ()
    {
        return $this->_organisation;
    }
    public function setOrganisation ($_organisation)
    {
        $this->_organisation = $_organisation;
    }
    public function getStart_date ()
    {
        return $this->_start_date;
    }
    public function setStart_date ($_start_date)
    {
        $this->_start_date = $_start_date;
    }
    public function getEnd_date ()
    {
        return $this->_end_date;
    }
    public function setEnd_date ($_end_date)
    {
        $this->_end_date = $_end_date;
    }
    public function getIs_parttime ()
    {
        return $this->_is_parttime;
    }
    public function setIs_parttime ($_is_parttime)
    {
        $this->_is_parttime = $_is_parttime;
    }
    public function getDescription ()
    {
        return $this->_description;
    }
    public function setDescription ($_description)
    {
        $this->_description = $_description;
    }
    /**
     * Set Mapper
     * @param Tnp_Model_Mapper_Profile_Components_Experience $mapper
     * @return Tnp_Model_Profile_Components_Experience
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Profile_Components_Experience
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(
            new Tnp_Model_Mapper_Profile_Components_Experience());
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
     * must include a check that no undesirable properties are set before saving
     * ex : some properties are defined to just simplify search or are to be used as read only i-e
     * they must not be set by controller.. if set they must be detected here...
     * but this is not a problem bcoz save function will save only those properties 
     * for which it is designed to save
     */
    public function save ()
    {
        $this->getMapper()->save($this);
    }
    public function initMemberExperienceDetails ()
    {
        $member_experiences_info = $this->getMember_experiences_info();
        $experience_id = $this->getStudent_experience_id();
        if (! isset($experience_id)) {
            $error = 'No Experience Id provided';
            throw new Exception($error);
        } else {
            if (! array_key_exists($experience_id, $member_experiences_info)) {
                $error = 'Experience Id : ' . $experience_id . 'for user ' .
                 $this->getMember_id() . ' is invalid';
                throw new Exception($error);
            } else {
                $options = $member_experiences_info[$experience_id];
                $this->setOptions($options);
            }
        }
    }
    public function getMemberExperienceIds ()
    {
        $member_experiences_info = $this->getMember_experiences_info();
        return array_keys($member_experiences_info);
    }
    public function initIndustryInfo ()
    {
        $options = $this->getMapper()->fetchIndustryInfo($this);
        $this->setOptions($options);
    }
    public function initFunctionalAreaInfo ()
    {
        $options = $this->getMapper()->fetchFunctionalAreaInfo($this);
        $this->setOptions($options);
    }
    public function initRoleInfo ()
    {
        $options = $this->getMapper()->fetchRoleInfo($this);
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
                $error = implode(', ', $invalid_range_keys);
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