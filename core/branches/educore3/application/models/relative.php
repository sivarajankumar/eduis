<?php
class Core_Model_Relative extends Core_Model_Generic
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
    protected $_mapper;
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
    public function initRelativeInfo ()
    {
        $info = $this->getMapper()->fetchRelativeInfo($this);
        $this->setOptions($info);
    }
}