<?php
class Tnp_Model_Core_Industries extends Tnp_Model_Generic
{
    protected $_industry_id;
    protected $_industry_name;
    protected $_mapper;
    /**
     * @return the $_industry_id
     */
    public function getIndustry_id ($throw_exception = null)
    {
        $industry_id = $this->_industry_id;
        if (empty($industry_id) and $throw_exception == true) {
            $message = '_industry_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $industry_id;
        }
    }
    /**
     * @return the $_industry_name
     */
    public function getIndustry_name ()
    {
        return $this->_industry_name;
    }
    /**
     * @param field_type $_industry_id
     */
    public function setIndustry_id ($_industry_id)
    {
        $this->_industry_id = $_industry_id;
    }
    /**
     * @param field_type $_industry_name
     */
    public function setIndustry_name ($_industry_name)
    {
        $this->_industry_name = $_industry_name;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_Core_Industries $mapper
     * @return Tnp_Model_Core_Industries
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Core_Industries
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_Core_Industries());
        }
        return $this->_mapper;
    }
}