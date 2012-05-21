<?php
class Core_Model_Religion extends Core_Model_Generic
{
    protected $_religion_id;
    protected $_religion_name;
    protected $_mapper;
    /**
     * @return the $_religion_id
     */
    public function getReligion_id ($throw_exception = null)
    {
        $religion_id = $this->_religion_id;
        if (empty($religion_id) and $throw_exception == true) {
            $message = '_religion_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $religion_id;
        }
    }
    /**
     * @return the $_religion_name
     */
    public function getReligion_name ($throw_exception = null)
    {
        $religion_name = $this->_religion_name;
        if (empty($religion_name) and $throw_exception == true) {
            $message = '_religion_name is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $religion_name;
        }
    }
    /**
     * @param field_type $_religion_id
     */
    public function setReligion_id ($_religion_id)
    {
        $this->_religion_id = $_religion_id;
    }
    /**
     * @param field_type $_religion_name
     */
    public function setReligion_name ($_religion_name)
    {
        $this->_religion_name = $_religion_name;
    }
    /**
     * Sets Mapper
     * @param Core_Model_Mapper_Religion $mapper
     * @return Core_Model_Religion
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Core_Model_Mapper_Religion
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_Religion());
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
     * Fetches information regarding a religion
     *
     */
    public function fetchInfo ()
    {
        $religion_id = $this->getReligion_id(true);
        $info = $this->getMapper()->fetchInfo($religion_id);
        if (empty($info)) {
            return false;
        } else {
            $this->setOptions($info);
            return $this;
        }
    }
    public function fetchAllReligions ()
    {
        $all_religions = array();
        $all_religions = $this->getMapper()->fetchReligions();
        if (empty($all_religions)) {
            return false;
        } else {
            return $all_religions;
        }
    }
}