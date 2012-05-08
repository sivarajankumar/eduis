<?php
class Tnp_Model_Certification extends Tnp_Model_Generic
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
     * @param Tnp_Model_Mapper_Certification $mapper
     * @return Tnp_Model_Certification
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Certification
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_Certification());
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
     * Enter description here ...
     * @param bool $certification_name_specific
     * @param bool $technical_field_id_specific
     */
    public function fetchCertificationIds ($certification_name_specific = null, 
    $technical_field_id_specific = null)
    {
        $certification_name = null;
        $technical_field_id = null;
        if ($certification_name_specific == true) {
            $certification_name = $this->getCertification_name(true);
        }
        if ($technical_field_id_specific == true) {
            $technical_field_id = $this->getCertification_name(true);
        }
        $certification_ids = array();
        $certification_ids = $this->getMapper()->fetchCertificationIds(
        $certification_name, $technical_field_id);
        if (empty($certification_ids)) {
            return false;
        } else {
            return $certification_ids;
        }
    }
    public function fetchInfo ()
    {
        $certification_id = $this->getCertification_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($certification_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
}