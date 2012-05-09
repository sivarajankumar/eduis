<?php
class Tnp_Model_MemberInfo_Experience extends Tnp_Model_Generic
{
    protected $_student_experience_id;
    protected $_member_id;
    protected $_industry_id;
    protected $_functional_area_id;
    protected $_role_id;
    protected $_experience_months;
    protected $_experience_years;
    protected $_organisation;
    protected $_end_date;
    protected $_start_date;
    protected $_is_parttime;
    protected $_description;
    protected $_mapper;
    /**
     * @return the $_student_experience_id
     */
    public function getStudent_experience_id ()
    {
        return $this->_student_experience_id;
    }
    /**
     * @param bool $throw_exception optional
     * @return the $_member_id
     */
    public function getMember_id ($throw_exception = null)
    {
        $member_id = $this->_member_id;
        if (empty($member_id) and $throw_exception == true) {
            $message = 'Member_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $member_id;
        }
    }
    /**
     * @return the $_industry_id
     */
    public function getIndustry_id ()
    {
        return $this->_industry_id;
    }
    /**
     * @return the $_functional_area_id
     */
    public function getFunctional_area_id ()
    {
        return $this->_functional_area_id;
    }
    /**
     * @return the $_role_id
     */
    public function getRole_id ()
    {
        return $this->_role_id;
    }
    /**
     * @return the $_experience_months
     */
    public function getExperience_months ()
    {
        return $this->_experience_months;
    }
    /**
     * @return the $_experience_years
     */
    public function getExperience_years ()
    {
        return $this->_experience_years;
    }
    /**
     * @return the $_organisation
     */
    public function getOrganisation ()
    {
        return $this->_organisation;
    }
    /**
     * @return the $_end_date
     */
    public function getEnd_date ()
    {
        return $this->_end_date;
    }
    /**
     * @return the $_start_date
     */
    public function getStart_date ()
    {
        return $this->_start_date;
    }
    /**
     * @return the $_is_parttime
     */
    public function getIs_parttime ()
    {
        return $this->_is_parttime;
    }
    /**
     * @return the $_description
     */
    public function getDescription ()
    {
        return $this->_description;
    }
    /**
     * @param field_type $_student_experience_id
     */
    public function setStudent_experience_id ($_student_experience_id)
    {
        $this->_student_experience_id = $_student_experience_id;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_industry_id
     */
    public function setIndustry_id ($_industry_id)
    {
        $this->_industry_id = $_industry_id;
    }
    /**
     * @param field_type $_functional_area_id
     */
    public function setFunctional_area_id ($_functional_area_id)
    {
        $this->_functional_area_id = $_functional_area_id;
    }
    /**
     * @param field_type $_role_id
     */
    public function setRole_id ($_role_id)
    {
        $this->_role_id = $_role_id;
    }
    /**
     * @param field_type $_experience_months
     */
    public function setExperience_months ($_experience_months)
    {
        $this->_experience_months = $_experience_months;
    }
    /**
     * @param field_type $_experience_years
     */
    public function setExperience_years ($_experience_years)
    {
        $this->_experience_years = $_experience_years;
    }
    /**
     * @param field_type $_organisation
     */
    public function setOrganisation ($_organisation)
    {
        $this->_organisation = $_organisation;
    }
    /**
     * @param field_type $_end_date
     */
    public function setEnd_date ($_end_date)
    {
        $this->_end_date = $_end_date;
    }
    /**
     * @param field_type $_start_date
     */
    public function setStart_date ($_start_date)
    {
        $this->_start_date = $_start_date;
    }
    /**
     * @param field_type $_is_parttime
     */
    public function setIs_parttime ($_is_parttime)
    {
        $this->_is_parttime = $_is_parttime;
    }
    /**
     * @param field_type $_description
     */
    public function setDescription ($_description)
    {
        $this->_description = $_description;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_MemberExperience $mapper
     * @return Tnp_Model_MemberInfo_Experience
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_MemberExperience
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_MemberExperience());
        }
        return $this->_mapper;
    }
    /**
     * Provides correct db column names corresponding to model properties
     * @todo add correct names where required
     * @param string $key
     */
    protected function correctDbKeys ($key)
    {
        switch ($key) {
            /*case 'nationalit':
                return 'nationality';
                break;*/
            default:
                return $key;
                break;
        }
    }
    /**
     * Provides correct model property names corresponding to db column names
     * @todo add correct names where required
     * @param string $key
     */
    protected function correctModelKeys ($key)
    {
        switch ($key) {
            /*case 'nationality':
                return 'nationalit';
                break;*/
            default:
                return $key;
                break;
        }
    }
    public function fetchStudentExperienceIds ()
    {
        $member_id = $this->getMember_id(true);
        $experience_ids = $this->getMapper()->fetchStudentExperienceIds($member_id);
        if (empty($experience_ids)) {
            return false;
        } else {
            return $experience_ids;
        }
    }
    public function fetchInfo ()
    {
        $stu_exp_id = $this->getStudent_experience_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($stu_exp_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
}