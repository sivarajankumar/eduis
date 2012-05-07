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
    public function getExists ($throw_exception = null)
    {
        $exists = $this->_exists;
        if (empty($exists) and $throw_exception == true) {
            $message = '_exists is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $exists;
        }
    }
    /**
     * @return the $_is_locked
     */
    public function getIs_locked ($throw_exception = null)
    {
        $is_locked = $this->_is_locked;
        if (empty($is_locked) and $throw_exception == true) {
            $message = '_is_locked is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $is_locked;
        }
    }
    /**
     * @return the $_last_updated_on
     */
    public function getLast_updated_on ($throw_exception = null)
    {
        $last_updated_on = $this->_last_updated_on;
        if (empty($last_updated_on) and $throw_exception == true) {
            $message = '_last_updated_on is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $last_updated_on;
        }
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
    public function fetchInfo ()
    {
        $member_id = $this->getMember_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($member_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
    /**
     * 
     * Enter description here ...
     * @param bool $exists
     * @param bool $is_locked
     * @param bool $last_updated_on ( date_format must be set in the object in the form yyyy.MM.dd  with dot separater
     */
    public function fetchMemberIds ($profile_exists = null, $locked = null, 
    $updated_on = null)
    {
        $exists = null;
        $is_locked = null;
        $last_updated_on = null;
        if ($profile_exists == true) {
            $exists = $this->getExists(true);
        }
        if ($locked == true) {
            $exists = $this->getExists(true);
        }
        if ($locked == true) {
            $is_locked = $this->getIs_locked(true);
        }
        if ($updated_on == true) {
            $last_updated_on = $this->getLast_updated_on(true);
            $last_updated_on = Zend_Locale_Format::getDate($last_updated_on, 
            array('date_format' => 'yyyyMMdd', 'fix_date' => true));
        }
        $member_ids = $this->getMapper()->fetchMemberIds($exists, $is_locked, 
        $last_updated_on);
        return $member_ids;
    }
}