<?php
class Tnp_Model_FunctionalArea extends Tnp_Model_Generic
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
     * @param Tnp_Model_Mapper_FunctionalArea $mapper
     * @return Tnp_Model_FunctionalArea
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_FunctionalArea
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_FunctionalArea());
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
     * @return array ,Format = array($functional_area_id=>$functional_area_name)
     */
    public function fetchFunctionalAreas ()
    {
        $functional_areas = array();
        $functional_areas = $this->getMapper()->fetchFunctionalAreas();
        if (empty($functional_areas)) {
            return false;
        } else {
            return $functional_areas;
        }
    }
    public function fetchInfo ()
    {
        $functional_area_id = $this->getFunctional_area_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($functional_area_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
    public function fetchFunctionalId ()
    {
        $functional_area_id = $this->getMapper()->fetchFunctionalId(
        $this->getFunctional_area_name(true));
        if (empty($functional_area_id)) {
            return false;
        } else {
            return array_pop($functional_area_id);
        }
    }
    public function saveInfo ($data_array)
    {
        $this->setFunctional_area_name($data_array['functional_area_name']);
        $functional_area_id = $this->fetchFunctionalId();
        if (empty($functional_area_id)) {
            return $this->save($data_array);
        } else {
            return $functional_area_id;
        }
    }
    private function save ($data_array)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($data_array);
        return $this->getMapper()->save($prepared_data);
    }
    public function updateInfo ($data_array)
    {
        $functional_area_id = $this->getFunctional_area_id(true);
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($data_array);
        return $this->getMapper()->update($prepared_data, $functional_area_id);
    }
    public function deleteFunctionalArea ()
    {
        $functional_area_id = $this->getFunctional_area_id(true);
        return $this->getMapper()->delete($functional_area_id);
    }
}