<?php
class Core_Model_Nationality extends Core_Model_Generic
{
    protected $_nationality_id;
    protected $_nationality_name;
    protected $_mapper;
    /**
     * @return the $_nationality_id
     */
    public function getNationality_id ($throw_exception = null)
    {
        $nationality_id = $this->_nationality_id;
        if (empty($nationality_id) and $throw_exception == true) {
            $message = '_nationality_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $nationality_id;
        }
    }
    /**
     * @return the $_nationality_name
     */
    public function getNationality_name ($throw_exception = null)
    {
        $nationality_name = $this->_nationality_name;
        if (empty($nationality_name) and $throw_exception == true) {
            $message = '_nationality_name is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $nationality_name;
        }
    }
    /**
     * @param field_type $_nationality_id
     */
    public function setNationality_id ($_nationality_id)
    {
        $this->_nationality_id = $_nationality_id;
    }
    /**
     * @param field_type $_nationality_name
     */
    public function setNationality_name ($_nationality_name)
    {
        $this->_nationality_name = $_nationality_name;
    }
    /**
     * Sets Mapper
     * @param Core_Model_Mapper_Nationality $mapper
     * @return Core_Model_Nationality
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Core_Model_Mapper_Nationality
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_Nationality());
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
     * Fetches information regarding a nationality
     *
     */
    public function fetchInfo ()
    {
        $nationality_id = $this->getNationality_id(true);
        $info = $this->getMapper()->fetchInfo($nationality_id);
        if (empty($info)) {
            return false;
        } else {
            $this->setOptions($info);
            return $this;
        }
    }
    public function fetchAllNationalities ()
    {
        $all_nationalities = array();
        $all_nationalities = $this->getMapper()->fetchNationalities();
        if (empty($all_nationalities)) {
            return false;
        } else {
            return $all_nationalities;
        }
    }
}