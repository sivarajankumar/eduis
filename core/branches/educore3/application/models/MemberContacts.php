<?php
class Core_Model_MemberContacts extends Core_Model_Generic
{
    protected $_member_id;
    protected $_contact_type_id;
    protected $_contact_type_name;
    protected $_contact_details;
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
     * @return the $_contact_type_id
     */
    public function getContact_type_id ()
    {
        return $this->_contact_type_id;
    }
    /**
     * @param field_type $_contact_type_id
     */
    public function setContact_type_id ($_contact_type_id)
    {
        $this->_contact_type_id = $_contact_type_id;
    }
    /**
     * @return the $_contact_type_name
     */
    public function getContact_type_name ()
    {
        return $this->_contact_type_name;
    }
    /**
     * @param field_type $_contact_type_name
     */
    public function setContact_type_name ($_contact_type_name)
    {
        $this->_contact_type_name = $_contact_type_name;
    }
    /**
     * @return the $_contact_details
     */
    public function getContact_details ()
    {
        return $this->_contact_details;
    }
    /**
     * @param field_type $_contact_details
     */
    public function setContact_details ($_contact_details)
    {
        $this->_contact_details = $_contact_details;
    }
    /**
     * Sets Mapper
     * @param Core_Model_Mapper_MemberContacts $mapper
     * @return Core_Model_MemberContacts
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Core_Model_Mapper_MemberContacts
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_MemberContacts());
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
            if (sizeof($options) == 0) {
                return false;
            } else {
                $this->setOptions($options);
                return true;
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
