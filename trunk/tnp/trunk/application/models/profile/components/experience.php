<?php
class Tnp_Model_Profile_Components_Experience
{
    protected $_student_experience_id;
    protected $_member_id;
    protected $_industry_id;
    protected $_industry_name;
    protected $_functional_area_id;
    protected $_functional_area_name;
    protected $_role_id;
    protected $_role_name;
    protected $_experience_months;
    protected $_experience_year;
    protected $_organisation;
    protected $_start_date;
    protected $_end_date;
    protected $_is_parttime;
    protected $_description;
    protected $_mapper;
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
            $this->findIndustry_id();
        }
        return $this->_industry_id;
    }
    public function setIndustry_id ($_industry_id)
    {
        $this->_industry_id = $_industry_id;
    }
    public function getIndustry_name ()
    {
        $industry_name = $this->_industry_name;
        if (! isset($industry_name)) {
            $this->findIndustry_name();
        }
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
            $this->findFunctional_area_id();
        }
        return $this->_functional_area_id;
    }
    public function setFunctional_area_id ($_functional_area_id)
    {
        $this->_functional_area_id = $_functional_area_id;
    }
    public function getFunctional_area_name ()
    {
        $functional_area_name = $this->_functional_area_name;
        if (! isset($functional_area_name)) {
            $this->findFunctional_area_name();
        }
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
            $this->findRole_id();
        }
        return $this->_role_id;
    }
    public function setRole_id ($_role_id)
    {
        $this->_role_id = $_role_id;
    }
    public function getRole_name ()
    {
        $role_name = $this->_role_name;
        if (! isset($role_name)) {
            $this->findRole_name();
        }
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
    public function getExperience_year ()
    {
        return $this->_experience_year;
    }
    public function setExperience_year ($_experience_year)
    {
        $this->_experience_year = $_experience_year;
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
    /**
     * first set properties of object, according to which you want
     * to search,using constructor, then call the search function
     * 
     */
    public function search ()
    {
        return $this->getMapper()->fetchMemberId($this);
    }
    public function getMemberExperienceDetails ()
    {
        $options = $this->getMapper()->fetchMemberExperienceDetails($this);
        $this->setOptions($options);
    }
    /**
     * Enter description here ...
     */
    public function getMemberExperienceIds ()
    {
        return $this->getMapper()->fetchMemberExperienceIds($this);
    }
    /**
     * Enter description here ...
     */
    protected function findIndustry_id ()
    {
        $this->getMapper()->fetchIndustry_id($this);
    }
    /**
     * Enter description here ...
     */
    protected function findIndustry_name ()
    {
        $this->getMapper()->fetchIndustry_name($this);
    }
    /**
     * Enter description here ...
     */
    protected function findFunctional_area_id ()
    {
        $this->getMapper()->fetchFunctional_area_id($this);
    }
    /**
     * Enter description here ...
     */
    protected function findFunctional_area_name ()
    {
        $this->getMapper()->fetchFunctional_area_name($this);
    }
    /**
     * Enter description here ...
     */
    protected function findRole_id ()
    {
        $this->getMapper()->fetchRole_id($this);
    }
    /**
     * Enter description here ...
     */
    protected function findRole_name ()
    {
        $this->getMapper()->fetchRole_name($this);
    }
}