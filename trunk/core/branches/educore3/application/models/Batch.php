<?php
class Core_Model_Batch extends Core_Model_Generic
{
    protected $_batch_id;
    protected $_department_id;
    protected $_programme_id;
    protected $_batch_start;
    protected $_batch_number;
    protected $_is_active;
    protected $_mapper;
    /**
     * @return the $_batch_id
     */
    public function getBatch_id ($throw_exception = null)
    {
        $batch_id = $this->_batch_id;
        if (empty($batch_id) and $throw_exception == true) {
            $message = '_batch_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $batch_id;
        }
    }
    /**
     * @return the $_department_id
     */
    public function getDepartment_id ($throw_exception = null)
    {
        $department_id = $this->_department_id;
        if (empty($department_id) and $throw_exception == true) {
            $message = '_department_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $department_id;
        }
    }
    /**
     * @return the $_programme_id
     */
    public function getProgramme_id ($throw_exception = null)
    {
        $programme_id = $this->_programme_id;
        if (empty($programme_id) and $throw_exception == true) {
            $message = '_programme_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $programme_id;
        }
    }
    /**
     * @return the $_batch_start
     */
    public function getBatch_start ($throw_exception = null)
    {
        $batch_start = $this->_batch_start;
        if (empty($batch_start) and $throw_exception == true) {
            $message = '_batch_start is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $batch_start;
        }
    }
    /**
     * @return the $_batch_number
     */
    public function getBatch_number ()
    {
        return $this->_batch_number;
    }
    /**
     * @return the $_is_active
     */
    public function getIs_active ($throw_exception = null)
    {
        $is_active = $this->_is_active;
        if (empty($is_active) and $throw_exception == true) {
            $message = '_is_active is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $is_active;
        }
    }
    /**
     * @param field_type $_batch_id
     */
    public function setBatch_id ($_batch_id)
    {
        $this->_batch_id = $_batch_id;
    }
    /**
     * @param field_type $_department_id
     */
    public function setDepartment_id ($_department_id)
    {
        $this->_department_id = $_department_id;
    }
    /**
     * @param field_type $_programme_id
     */
    public function setProgramme_id ($_programme_id)
    {
        $this->_programme_id = $_programme_id;
    }
    /**
     * @param field_type $_batch_start
     */
    public function setBatch_start ($_batch_start)
    {
        $this->_batch_start = $_batch_start;
    }
    /**
     * @param field_type $_batch_number
     */
    public function setBatch_number ($_batch_number)
    {
        $this->_batch_number = $_batch_number;
    }
    /**
     * @param field_type $_is_active
     */
    public function setIs_active ($_is_active)
    {
        $this->_is_active = $_is_active;
    }
    /**
     * Sets Mapper
     * @param Core_Model_Mapper_Batch $mapper
     * @return Core_Model_Batch
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Core_Model_Mapper_Batch
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_Batch());
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
     */
    public function initInfo ()
    {}
    /**
     * Fetches information regarding class
     *
     */
    public function fetchInfo ()
    {
        $member_id = $this->getMember_id();
        if (empty($member_id)) {
            $error = 'Please provide a Batch_Id';
            throw new Exception($error, Zend_Log::ERR);
        } else {
            $info = $this->getMapper()->fetchPersonalInfo($member_id);
            if (empty($info)) {
                return false;
            } else {
                $this->setOptions($info);
                return $this;
            }
        }
    }
    /**
     * fetches the Batch Ids
     * 
     * @param bool $batch_start_year_specific optional
     * @param bool $department_specific optional
     * @param bool $programme_specific optional
     * @throws Exception
     * @return array|int|flase
     */
    public function fetchBatchIds ($batch_start_year_specific = null, 
    $department_specific = null, $programme_specific = null)
    {
        $batch_start = null;
        $department_id = null;
        $programme_id = null;
        $batch_ids = array();
        if ($batch_start_year_specific == true) {
            $batch_start = $this->getBatch_start(true);
        }
        if ($department_specific == true) {
            $department_id = $this->getDepartment_id(true);
        }
        if ($programme_specific == true) {
            $programme_id = $this->getProgramme_id(true);
        }
        $batch_ids = $this->getMapper()->fetchBatchIds($batch_start, 
        $department_id, $programme_id);
        if (empty($batch_ids)) {
            return false;
        } else {
            return $batch_ids;
        }
    }
    public function save ($data_array)
    {
        $preparedDataForSaveProcess = $this->prepareDataForSaveProcess(
        $data_array);
        $this->setOptions($preparedDataForSaveProcess);
        $this->getMapper()->save($preparedDataForSaveProcess);
    }
}