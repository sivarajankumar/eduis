<?php
class Tnp_Model_StudentLanguage extends Tnp_Model_Generic
{
    protected $_member_id;
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
     * @param field_type $_proficiency
     */
    public function setProficiency ($_proficiency)
    {
        $this->_proficiency = $_proficiency;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_StudentLanguage $mapper
     * @return Tnp_Model_StudentLanguage
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_StudentClass
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_StudentLanguage());
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
        $class_id = $this->getClass_id(true);
        $info = $this->getMapper()->fetchInfo($member_id, $class_id);
        if (empty($info)) {
            return false;
        } else {
            $this->setOptions($info);
            return $this;
        }
    }
    public function fetchBatchIdentifierClassId ()
    {
        $member_id = $this->getMember_id(true);
        $batch_id = $this->getMapper()->fetchBatchIdentifierClassId($member_id);
        return $batch_id;
    }
    public function fetchClassIds ()
    {
        $member_id = $this->getMember_id(true);
        $class_ids = $this->getMapper()->fetchClassIds($member_id);
        if (empty($class_ids)) {
            return false;
        } else {
            return $class_ids;
        }
    }
}