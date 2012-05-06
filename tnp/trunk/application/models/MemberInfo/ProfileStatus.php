<?php
class Tnp_Model_MemberInfo_ProfileStatus extends Tnp_Model_Generic
{
    protected $_member_id;
    protected $_exists;
    protected $_is_locked;
    protected $_last_updated_on;
    protected $_mapper;
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
     * @return the $_exists
     */
    public function getExists ()
    {
        return $this->_exists;
    }
    /**
     * @return the $_is_locked
     */
    public function getIs_locked ()
    {
        return $this->_is_locked;
    }
    /**
     * @return the $_last_updated_on
     */
    public function getLast_updated_on ()
    {
        return $this->_last_updated_on;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_exists
     */
    public function setExists ($_exists)
    {
        $this->_exists = $_exists;
    }
    /**
     * @param field_type $_is_locked
     */
    public function setIs_locked ($_is_locked)
    {
        $this->_is_locked = $_is_locked;
    }
    /**
     * @param field_type $_last_updated_on
     */
    public function setLast_updated_on ($_last_updated_on)
    {
        $this->_last_updated_on = $_last_updated_on;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_MemberInfo_ProfileStatus $mapper
     * @return Tnp_Model_MemberInfo_ProfileStatus
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_MemberInfo_ProfileStatus
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_MemberInfo_ProfileStatus());
        }
        return $this->_mapper;
    }
}