<?php
class Core_Model_MemberAddress extends Core_Model_Generic
{
    protected $_member_id;
    protected $_postal_code;
    protected $_city;
    protected $_district;
    protected $_state;
    protected $_address;
    protected $_address_type;
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
     * Sets Mapper
     * @param Core_Model_Mapper_MemberAddress $mapper
     * @return Core_Model_MemberAddress
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Core_Model_Mapper_MemberAddress
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_MemberAddress());
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
        $member_id = $this->getMember_id();
        $address_type = $this->getAddress_type();
        if (empty($member_id) or empty($address_type)) {
            $careless_error = 'Please provide a Member Id and Address Type';
            throw new Exception($careless_error);
        } else {
            $address_info = $this->getMapper()->fetchInfo($member_id, 
            $address_type);
            if (sizeof($address_info) == 0) {
                return false;
            } else {
                $this->setOptions($address_info);
                return true;
            }
        }
    }
    /**
     * Fetches all Address Types of a member
     *
     */
    public function fetchAddressTypes ()
    {
        $member_id = $this->getMember_id();
        if (empty($member_id)) {
            $careless_error = 'Please provide a Member Id in fetchAddressTypes().';
            throw new Exception($careless_error, Zend_Log::ERR);
        } else {
            $address_types = $this->getMapper()->fetchAddressTypes($member_id);
            if (sizeof($address_types) == 0) {
                return false;
            } else {
                return $address_types;
            }
        }
    }
    public function save ($data_array)
    {
        $preparedDataForSaveProcess = $this->prepareDataForSaveProcess(
        $data_array);
        $this->setOptions($preparedDataForSaveProcess);
        $this->getMapper()->save($preparedDataForSaveProcess);
    }
}
