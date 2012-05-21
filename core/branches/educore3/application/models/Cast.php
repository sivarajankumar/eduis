<?php
class Core_Model_Cast extends Core_Model_Generic
{
    protected $_cast_id;
    protected $_cast_name;
    protected $_mapper;
    /**
     * @return the $_cast_id
     */
    public function getCast_id ($throw_exception = null)
    {
        $cast_id = $this->_cast_id;
        if (empty($cast_id) and $throw_exception == true) {
            $message = '_cast_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $cast_id;
        }
    }
    /**
     * @return the $_cast_name
     */
    public function getCast_name ($throw_exception = null)
    {
        $cast_name = $this->_cast_name;
        if (empty($cast_name) and $throw_exception == true) {
            $message = '_cast_name is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $cast_name;
        }
    }
    /**
     * @param field_type $_cast_id
     */
    public function setCast_id ($_cast_id)
    {
        $this->_cast_id = $_cast_id;
    }
    /**
     * @param field_type $_cast_name
     */
    public function setCast_name ($_cast_name)
    {
        $this->_cast_name = $_cast_name;
    }
    /**
     * Sets Mapper
     * @param Core_Model_Mapper_Cast $mapper
     * @return Core_Model_Cast
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Core_Model_Mapper_Cast
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_Cast());
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
     * Fetches information regarding a cast
     *
     */
    public function fetchInfo ()
    {
        $cast_id = $this->getCast_id(true);
        $info = $this->getMapper()->fetchInfo($cast_id);
        if (empty($info)) {
            return false;
        } else {
            $this->setOptions($info);
            return $this;
        }
    }
    public function fetchAllCasts ()
    {
        $all_casts = array();
        $all_casts = $this->getMapper()->fetchCasts();
        if (empty($all_casts)) {
            return false;
        } else {
            return $all_casts;
        }
    }
}