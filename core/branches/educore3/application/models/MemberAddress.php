<?php
class Core_Model_MemberAddress extends Core_Model_Generic
{
    protected $_member_id;
    protected $_postal_code;
    protected $_city;
    protected $_district;
    protected $_state;
    protected $_address;
    protected $_adress_type;
    protected $_mapper;
    /**
     * @return the $_member_id
     */
    protected function getMember_id ()
    {
        return $this->_member_id;
    }
    /**
     * @param field_type $_member_id
     */
    protected function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @return the $_postal_code
     */
    protected function getPostal_code ()
    {
        return $this->_postal_code;
    }
    /**
     * @param field_type $_postal_code
     */
    protected function setPostal_code ($_postal_code)
    {
        $this->_postal_code = $_postal_code;
    }
    /**
     * @return the $_city
     */
    protected function getCity ()
    {
        return $this->_city;
    }
    /**
     * @param field_type $_city
     */
    protected function setCity ($_city)
    {
        $this->_city = $_city;
    }
    /**
     * @return the $_district
     */
    protected function getDistrict ()
    {
        return $this->_district;
    }
    /**
     * @param field_type $_district
     */
    protected function setDistrict ($_district)
    {
        $this->_district = $_district;
    }
    /**
     * @return the $_state
     */
    protected function getState ()
    {
        return $this->_state;
    }
    /**
     * @param field_type $_state
     */
    protected function setState ($_state)
    {
        $this->_state = $_state;
    }
    /**
     * @return the $_address
     */
    protected function getAddress ()
    {
        return $this->_address;
    }
    /**
     * @param field_type $_address
     */
    protected function setAddress ($_address)
    {
        $this->_address = $_address;
    }
    /**
     * @return the $_adress_type
     */
    protected function getAdress_type ()
    {
        return $this->_adress_type;
    }
    /**
     * @param field_type $_adress_type
     */
    protected function setAdress_type ($_adress_type)
    {
        $this->_adress_type = $_adress_type;
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
        if (empty($member_id)) {
            $careless_error = 'Please provide a Member Id';
            throw new Exception($careless_error);
        } else {
            $options = $this->getMapper()->fetchInfo($member_id);
            if (sizeof($options) == 0) {} else {
                $no_data_error = 'NO ADDRESS DETAILS EXISTS FOR MEMBER ID : ' .
                 $member_id;
                throw new Exception($no_data_error);
                $this->setOptions($options);
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
