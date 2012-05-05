<?php
class Acad_Model_Qualification extends Acad_Model_Generic
{
    protected $_qualification_id;
    protected $_qualification_name;
    protected $_mapper;
    /**
     * @return the $_qualification_id
     */
    public function getQualification_id ($throw_exception = null)
    {
        $qualification_id = $this->_qualification_id;
        if (empty($qualification_id) and $throw_exception == true) {
            $message = '_qualification_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $qualification_id;
        }
    }
    /**
     * @return the $_qualification_name
     */
    public function getQualification_name ()
    {
        return $this->_qualification_name;
    }
    /**
     * @param field_type $_qualification_id
     */
    public function setQualification_id ($_qualification_id)
    {
        $this->_qualification_id = $_qualification_id;
    }
    /**
     * @param field_type $_qualification_name
     */
    public function setQualification_name ($_qualification_name)
    {
        $qualification_name = strtoupper($_qualification_name);
        $this->_qualification_name = $qualification_name;
    }
    /**
     * Sets Mapper
     * @param Acad_Model_Mapper_Qualification $mapper
     * @return Acad_Model_Qualification
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Qualification
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Qualification());
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
     * Fetches Qualification Details
     *
     */
    public function fetchInfo ()
    {
        $qualification_id = $this->getQualification_id(true);
        $info = $this->getMapper()->fetchInfo($qualification_id);
        if (empty($info)) {
            return false;
        } else {
            $this->setOptions($info);
            return true;
        }
    }
    public function fetchQualifications ()
    {
        $qualifications = $this->getMapper()->fetchQualifications();
        if (empty($qualifications)) {
            return false;
        } else {
            return $qualifications;
        }
    }
}