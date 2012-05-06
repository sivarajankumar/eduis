<?php
class Tnp_Model_Core_FunctionalArea extends Tnp_Model_Generic
{
    protected $_functional_area_id;
    protected $_functional_area_name;
    protected $_mapper;
    /**
     * @return the $_functional_area_id
     */
    public function getFunctional_area_id ($throw_exception = null)
    {
        $functional_area_id = $this->_functional_area_id;
        if (empty($functional_area_id) and $throw_exception == true) {
            $message = '_functional_area_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $functional_area_id;
        }
    }
    /**
     * @return the $_functional_area_name
     */
    public function getFunctional_area_name ($throw_exception = null)
    {
        $functional_area_name = $this->_functional_area_name;
        if (empty($functional_area_name) and $throw_exception == true) {
            $message = '_functional_area_name is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $functional_area_name;
        }
    }
    /**
     * @param field_type $_functional_area_id
     */
    public function setFunctional_area_id ($_functional_area_id)
    {
        $this->_functional_area_id = $_functional_area_id;
    }
    /**
     * @param field_type $_functional_area_name
     */
    public function setFunctional_area_name ($_functional_area_name)
    {
        $this->_functional_area_name = $_functional_area_name;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_Core_FunctionalArea $mapper
     * @return Tnp_Model_Core_FunctionalArea
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Core_FunctionalArea
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_Core_FunctionalArea());
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
}