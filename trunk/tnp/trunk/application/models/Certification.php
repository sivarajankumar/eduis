<?php
class Tnp_Model_Certification extends Tnp_Model_Generic
{
    protected $_certification_id;
    protected $_certification_name;
    protected $_functional_area_id;
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
     * @param field_type $_functional_area_id
     */
    public function setFunctional_area_id ($_functional_area_id)
    {
        $this->_functional_area_id = $_functional_area_id;
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
     * @param bool $functional_area_id_specific
     */
    public function fetchCertificationIds ($certification_name_specific = null, 
    $functional_area_id_specific = null)
    {
        $certification_name = null;
        $functional_area_id = null;
        if ($certification_name_specific == true) {
            $certification_name = $this->getCertification_name(true);
        }
        if ($functional_area_id_specific == true) {
            $functional_area_id = $this->getFunctional_area_id(true);
        }
        $certification_ids = array();
        $certification_ids = $this->getMapper()->fetchCertificationIds(
        $certification_name, $functional_area_id);
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
    public function saveInfo ($data_array)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($data_array);
        return $this->getMapper()->save($prepared_data);
    }
    public function updateInfo ($data_array)
    {
        $certification_id = $this->getCertification_id(true);
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($data_array);
        return $this->getMapper()->update($prepared_data, $certification_id);
    }
    public function deleteCertification ()
    {
        $certification_id = $this->getCertification_id(true);
        return $this->getMapper()->delete($certification_id);
    }
}