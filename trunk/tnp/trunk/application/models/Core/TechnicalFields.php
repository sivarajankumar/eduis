<?php
class Tnp_Model_Core_TechnicalFields extends Tnp_Model_Generic
{
    protected $_technical_field_id;
    protected $_technical_field_name;
    protected $_technical_sector;
    protected $_mapper;
    /**
     * @return the $_technical_field_id
     */
    public function getTechnical_field_id ($throw_exception = null)
    {
        $technical_field_id = $this->_technical_field_id;
        if (empty($technical_field_id) and $throw_exception == true) {
            $message = '_technical_field_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $technical_field_id;
        }
    }
    /**
     * @return the $_technical_field_name
     */
    public function getTechnical_field_name ($throw_exception = null)
    {
        $technical_field_name = $this->_technical_field_name;
        if (empty($technical_field_name) and $throw_exception == true) {
            $message = '_technical_field_name is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $technical_field_name;
        }
    }
    /**
     * @return the $_technical_sector
     */
    public function getTechnical_sector ()
    {
        return $this->_technical_sector;
    }
    /**
     * @param field_type $_technical_field_id
     */
    public function setTechnical_field_id ($_technical_field_id)
    {
        $this->_technical_field_id = $_technical_field_id;
    }
    /**
     * @param field_type $_technical_field_name
     */
    public function setTechnical_field_name ($_technical_field_name)
    {
        $this->_technical_field_name = $_technical_field_name;
    }
    /**
     * @param field_type $_technical_sector
     */
    public function setTechnical_sector ($_technical_sector)
    {
        $this->_technical_sector = $_technical_sector;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_Core_TechnicalFields $mapper
     * @return Tnp_Model_Core_TechnicalFields
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Core_TechnicalFields
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_Core_TechnicalFields());
        }
        return $this->_mapper;
    }
}