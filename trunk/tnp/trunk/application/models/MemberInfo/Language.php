<?php
class Tnp_Model_MemberInfo_Language extends Tnp_Model_Generic
{
    protected $_member_id;
    protected $_language_id;
    protected $_proficiency;
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
     * @return the $_language_id
     */
    public function getLanguage_id ()
    {
        return $this->_language_id;
    }
    /**
     * @return the $_proficiency
     */
    public function getProficiency ()
    {
        return $this->_proficiency;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_language_id
     */
    public function setLanguage_id ($_language_id)
    {
        $this->_language_id = $_language_id;
    }
    /**
     * @param field_type $_proficiency
     */
    public function setProficiency ($_proficiency)
    {
        $this->_proficiency = $_proficiency;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_MemberInfo_Language $mapper
     * @return Tnp_Model_Core_Training
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_MemberInfo_Language
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_MemberInfo_Language());
        }
        return $this->_mapper;
    }
}