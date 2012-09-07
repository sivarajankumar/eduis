<?php
/**
 * 
 * 
 * @deprecated
 *
 */
class Tnp_Model_TechnicalField extends Tnp_Model_Generic
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
     * @param Tnp_Model_Mapper_TechnicalField $mapper
     * @return Tnp_Model_TechnicalField
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_TechnicalField
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_TechnicalField());
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
     *@return array ,Format =array($tech_field_id=>$tech_field_name)
     */
    public function fetchTechnicalFields ()
    {
        $tech_fields = array();
        $tech_fields = $this->getMapper()->fetchTechnicalFields();
        if (empty($tech_fields)) {
            return false;
        } else {
            return $tech_fields;
        }
    }
    public function fetchInfo ()
    {
        $tech_field_id = $this->getTechnical_field_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($tech_field_id);
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
        $tech_field_id = $this->getTechnical_field_id(true);
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($data_array);
        return $this->getMapper()->update($prepared_data, $tech_field_id);
    }
    public function deleteTechnicalField ()
    {
        $tech_field_id = $this->getTechnical_field_id(true);
        return $this->getMapper()->delete($tech_field_id);
    }
}