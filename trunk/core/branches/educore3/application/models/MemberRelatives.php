<?php
class Core_Model_MemberRelatives extends Core_Model_Generic
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
    protected $_email;
    protected $_mapper;
    /**
     * @param bool $throw_exception optional
     * @return the $_member_id
     */
    public function getMember_id ($throw_exception = null)
    {
        $member_id = $this->_member_id;
        if (empty($member_id) and $throw_exception == true) {
            $message = 'Member_id is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $member_id;
        }
    }
    /**
     * @return the $_relation_id
     */
    public function getRelation_id ($throw_exception = null)
    {
        $relation_id = $this->_relation_id;
        if (empty($relation_id) and $throw_exception == true) {
            $message = '_relation_id is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $relation_id;
        }
    }
    /**
     * @return the $_relation_name
     */
    public function getRelation_name ()
    {
        return $this->_relation_name;
    }
    /**
     * @return the $_name
     */
    public function getName ()
    {
        return $this->_name;
    }
    /**
     * @return the $_occupation
     */
    public function getOccupation ()
    {
        return $this->_occupation;
    }
    /**
     * @return the $_designation
     */
    public function getDesignation ()
    {
        return $this->_designation;
    }
    /**
     * @return the $_office_add
     */
    public function getOffice_add ()
    {
        return $this->_office_add;
    }
    /**
     * @return the $_contact
     */
    public function getContact ()
    {
        return $this->_contact;
    }
    /**
     * @return the $_annual_income
     */
    public function getAnnual_income ()
    {
        return $this->_annual_income;
    }
    /**
     * @return the $_landline_no
     */
    public function getLandline_no ()
    {
        return $this->_landline_no;
    }
    /**
     * @return the $_email
     */
    public function getEmail ()
    {
        return $this->_email;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_relation_id
     */
    public function setRelation_id ($_relation_id)
    {
        $this->_relation_id = $_relation_id;
    }
    /**
     * @param field_type $_relation_name
     */
    public function setRelation_name ($_relation_name)
    {
        $this->_relation_name = $_relation_name;
    }
    /**
     * @param field_type $_name
     */
    public function setName ($_name)
    {
        $this->_name = $_name;
    }
    /**
     * @param field_type $_occupation
     */
    public function setOccupation ($_occupation)
    {
        $this->_occupation = $_occupation;
    }
    /**
     * @param field_type $_designation
     */
    public function setDesignation ($_designation)
    {
        $this->_designation = $_designation;
    }
    /**
     * @param field_type $_office_add
     */
    public function setOffice_add ($_office_add)
    {
        $this->_office_add = $_office_add;
    }
    /**
     * @param field_type $_contact
     */
    public function setContact ($_contact)
    {
        $this->_contact = $_contact;
    }
    /**
     * @param field_type $_annual_income
     */
    public function setAnnual_income ($_annual_income)
    {
        $this->_annual_income = $_annual_income;
    }
    /**
     * @param field_type $_landline_no
     */
    public function setLandline_no ($_landline_no)
    {
        $this->_landline_no = $_landline_no;
    }
    /**
     * @param field_type $_email
     */
    public function setEmail ($_email)
    {
        $this->_email = $_email;
    }
    /**
     * Sets Mapper
     * @param Core_Model_Mapper_MemberRelatives $mapper
     * @return Core_Model_MemberRelatives
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Core_Model_Mapper_MemberRelatives
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_MemberRelatives());
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
    /**
     * 
     */
    public function initInfo ()
    {}
    /**
     * Fetches information regarding class
     *
     */
    public function fetchInfo ()
    {
        $member_id = $this->getMember_id(true);
        $relation_id = $this->getRelation_id(true);
        $info = $this->getMapper()->fetchInfo($member_id, $relation_id);
        if (empty($info)) {
            return false;
        } else {
            $this->setOptions($info);
            return $this;
        }
    }
    /**
     * Fetches all Relation Ids of a member
     *
     */
    public function fetchRelationIds ()
    {
        $member_id = $this->getMember_id(true);
        $relation_ids = $this->getMapper()->fetchRelationIds($member_id);
        if (empty($relation_ids)) {
            return false;
        } else {
            return $relation_ids;
        }
    }
}