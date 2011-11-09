<?php
class Tnp_Model_Profile_Components_Experience extends Tnp_Model_Generic
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
}