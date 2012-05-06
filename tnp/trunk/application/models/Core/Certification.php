<?php
class Tnp_Model_Core_Certification extends Tnp_Model_Generic
{
    protected $_certification_id;
    protected $_certification_name;
    protected $_technical_field_id;
    protected $_mapper;
    /**
     * @return the $_certification_id
     */
    public function getCertification_id ($throw_exception = null)
    {
        $certification_id = $this->_certification_id;
        if (empty($certification_id) and $throw_exception == true) {
            $message = '_certification_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $certification_id;
        }
    }
    /**
     * @return the $_certification_name
     */
    public function getCertification_name ($throw_exception = null)
    {
        $certification_name = $this->_certification_name;
        if (empty($certification_name) and $throw_exception == true) {
            $message = '_certification_name is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $certification_name;
        }
    }
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
     * @param field_type $_certification_id
     */
    public function setCertification_id ($_certification_id)
    {
        $this->_certification_id = $_certification_id;
    }
    /**
     * @param field_type $_certification_name
     */
    public function setCertification_name ($_certification_name)
    {
        $this->_certification_name = $_certification_name;
    }
    /**
     * @param field_type $_technical_field_id
     */
    public function setTechnical_field_id ($_technical_field_id)
    {
        $this->_technical_field_id = $_technical_field_id;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_Core_Certification $mapper
     * @return Tnp_Model_Core_Certification
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Core_Certification
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_Core_Certification());
        }
        return $this->_mapper;
    }
}