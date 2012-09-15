<?php
class Core_Model_Programme extends Core_Model_Generic
{
    protected $_programme_id;
    protected $_programme_name;
    protected $_total_semesters;
    protected $_duration;
    protected $_mapper;
    /**
     * @return the $_duration
     */
    public function getDuration ()
    {
        return $this->_duration;
    }
    /**
     * @param field_type $_duration
     */
    public function setDuration ($_duration)
    {
        $this->_duration = $_duration;
    }
    /**
     * @return the $_programme_id
     */
    public function getProgramme_id ($throw_exception = null)
    {
        $programme_id = $this->_programme_id;
        if (empty($programme_id) and $throw_exception == true) {
            $message = '_programme_id is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $programme_id;
        }
    }
    /**
     * @return the $_programme_name
     */
    public function getProgramme_name ()
    {
        return $this->_programme_name;
    }
    /**
     * @return the $_total_semesters
     */
    public function getTotal_semesters ()
    {
        return $this->_total_semesters;
    }
    /**
     * @param field_type $_programme_id
     */
    public function setProgramme_id ($_programme_id)
    {
        $this->_programme_id = $_programme_id;
    }
    /**
     * @param field_type $_programme_name
     */
    public function setProgramme_name ($_programme_name)
    {
        $this->_programme_name = $_programme_name;
    }
    /**
     * @param field_type $_total_semesters
     */
    public function setTotal_semesters ($_total_semesters)
    {
        $this->_total_semesters = $_total_semesters;
    }
    /**
     * Sets Mapper
     * @param Core_Model_Mapper_Programme $mapper
     * @return Core_Model_Programme
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Core_Model_Mapper_Programme
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_Programme());
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
            /* case 'duration':
                return 'num_years';
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
            /*case 'num_years':
                return 'duration';
                break;*/
            default:
                return $key;
                break;
        }
    }
    /**
     * $programme['']=$programme_name
     *
     */
    public function fetchProgrammes ()
    {
        $programmes = $this->getMapper()->fetchProgrammes();
        if (empty($programmes)) {
            return false;
        } else {
            return $programmes;
        }
    }
    public function fetchInfo ()
    {
        $programme_id = $this->getProgramme_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($programme_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
    public function save ($programme_info)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($programme_info);
        return $this->getMapper()->save($prepared_data);
    }
    public function update ($programme_info, $programme_id)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($programme_info);
        return $this->getMapper()->update($prepared_data, $programme_id);
    }
}