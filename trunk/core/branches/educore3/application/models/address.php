<?php
class Core_Model_Address extends Core_Model_Generic
{
    protected $_member_id;
    protected $_address_type;
    protected $_postal_code;
    protected $_city;
    protected $_district;
    protected $_state;
    protected $_area;
    protected $_address;
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
     * @return the $_address_type
     */
    public function getAddress_type ()
    {
        return $this->_address_type;
    }
    /**
     * @param field_type $_address_type
     */
    public function setAddress_type ($_address_type)
    {
        $this->_address_type = $_address_type;
    }
    /**
     * @return the $_postal_code
     */
    public function getPostal_code ()
    {
        return $this->_postal_code;
    }
    /**
     * @param field_type $_postal_code
     */
    public function setPostal_code ($_postal_code)
    {
        $this->_postal_code = $_postal_code;
    }
    /**
     * @return the $_city
     */
    public function getCity ()
    {
        return $this->_city;
    }
    /**
     * @param field_type $_city
     */
    public function setCity ($_city)
    {
        $this->_city = $_city;
    }
    /**
     * @return the $_district
     */
    public function getDistrict ()
    {
        return $this->_district;
    }
    /**
     * @param field_type $_district
     */
    public function setDistrict ($_district)
    {
        $this->_district = $_district;
    }
    /**
     * @return the $_state
     */
    public function getState ()
    {
        return $this->_state;
    }
    /**
     * @param field_type $_state
     */
    public function setState ($_state)
    {
        $this->_state = $_state;
    }
    /**
     * @return the $_area
     */
    public function getArea ()
    {
        return $this->_area;
    }
    /**
     * @param field_type $_area
     */
    public function setArea ($_area)
    {
        $this->_area = $_area;
    }
    /**
     * @return the $_address
     */
    public function getAddress ()
    {
        return $this->_address;
    }
    /**
     * @param field_type $_address
     */
    public function setAddress ($_address)
    {
        $this->_address = $_address;
    }
    /**
     * Set Mapper
     * @param Core_Model_Mapper_Address $mapper
     * @return Core_Model_Address
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Core_Model_Mapper_Address
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_Address());
        }
        return $this->_mapper;
    }
    /**
     * Initialises address details of a member
     * 
     */
    public function initAddressInfo ()
    {
        $options = $this->getMapper()->fetchAddressInfo($this);
        $this->setOptions($options);
    }
}
