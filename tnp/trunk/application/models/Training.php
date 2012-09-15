<?php
/**
 * 
 * 
 * @deprecated
 *
 */
class Tnp_Model_Training extends Tnp_Model_Generic
{
    protected $_training_id;
    protected $_technical_field_id;
    protected $_training_technology;
    protected $_mapper;
    /**
     * @return the $_training_id
     */
    public function getTraining_id ($throw_exception = null)
    {
        $training_id = $this->_training_id;
        if (empty($training_id) and $throw_exception == true) {
            $message = '_training_id is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $training_id;
        }
    }
    /**
     * @return the $_technical_field_id
     */
    public function getTechnical_field_id ($throw_exception = null)
    {
        $technical_field_id = $this->_technical_field_id;
        if (empty($technical_field_id) and $throw_exception == true) {
            $message = '_technical_field_id is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $technical_field_id;
        }
    }
    /**
     * @return the $_training_technology
     */
    public function getTraining_technology ($throw_exception = null)
    {
        $training_technology = $this->_training_technology;
        if (empty($training_technology) and $throw_exception == true) {
            $message = '_training_technology is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $training_technology;
        }
    }
    /**
     * @param field_type $_training_id
     */
    public function setTraining_id ($_training_id)
    {
        $this->_training_id = $_training_id;
    }
    /**
     * @param field_type $_technical_field_id
     */
    public function setTechnical_field_id ($_technical_field_id)
    {
        $this->_technical_field_id = $_technical_field_id;
    }
    /**
     * @param field_type $_training_technology
     */
    public function setTraining_technology ($_training_technology)
    {
        $this->_training_technology = $_training_technology;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_Training $mapper
     * @return Tnp_Model_Training
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Training
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_Training());
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
    public function fetchTechnologies ()
    {
        $technologies = array();
        $technologies = $this->getMapper()->fetchTechnologies();
        if (empty($technologies)) {
            return false;
        } else {
            return $technologies;
        }
    }
    public function fetchInfo ()
    {
        $training_id = $this->getTraining_id();
        $info = array();
        $info = $this->getMapper()->fetchInfo($training_id);
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
        $training_id = $this->getTraining_id(true);
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($data_array);
        return $this->getMapper()->update($prepared_data, $training_id);
    }
    public function deleteTraining ()
    {
        $training_id = $this->getTraining_id(true);
        return $this->getMapper()->delete($training_id);
    }
}