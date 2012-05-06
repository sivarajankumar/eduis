<?php
class Tnp_Model_MemberInfo_Skills extends Tnp_Model_Generic
{
    protected $_skill_id;
    protected $_skill_name;
    protected $_skill_field;
    protected $_mapper;
    /**
     * @return the $_skill_id
     */
    public function getSkill_id ($throw_exception = null)
    {
        $skill_id = $this->_skill_id;
        if (empty($skill_id) and $throw_exception == true) {
            $message = '_skill_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $skill_id;
        }
    }
    /**
     * @return the $_skill_name
     */
    public function getSkill_name ($throw_exception = null)
    {
        $skill_name = $this->_skill_name;
        if (empty($skill_name) and $throw_exception == true) {
            $message = '_skill_name is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $skill_name;
        }
    }
    /**
     * @return the $_skill_field
     */
    public function getSkill_field ($throw_exception = null)
    {
        $skill_field = $this->_skill_field;
        if (empty($skill_field) and $throw_exception == true) {
            $message = '_skill_field is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $skill_field;
        }
    }
    /**
     * @param field_type $_skill_id
     */
    public function setSkill_id ($_skill_id)
    {
        $this->_skill_id = $_skill_id;
    }
    /**
     * @param field_type $_skill_name
     */
    public function setSkill_name ($_skill_name)
    {
        $this->_skill_name = $_skill_name;
    }
    /**
     * @param field_type $_skill_field
     */
    public function setSkill_field ($_skill_field)
    {
        $this->_skill_field = $_skill_field;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_MemberInfo_Skills $mapper
     * @return Tnp_Model_Core_Training
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_MemberInfo_Skills
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_MemberInfo_Skills());
        }
        return $this->_mapper;
    }
}