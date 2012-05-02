<?php
class Core_Model_Class extends Core_Model_Generic
{
    protected $_class_id;
    protected $_batch_id;
    protected $_semester_id;
    protected $_semester_type;
    protected $_semester_duration;
    protected $_handled_by_dept;
    protected $_start_date;
    protected $_completion_date;
    protected $_is_active;
    protected $_mapper;
    /**
     * @return the $_class_id
     */
    public function getClass_id ()
    {
        return $this->_class_id;
    }
    /**
     * @param field_type $_class_id
     */
    public function setClass_id ($_class_id)
    {
        $this->_class_id = $_class_id;
    }
    /**
     * @return the $_batch_id
     */
    public function getBatch_id ()
    {
        return $this->_batch_id;
    }
    /**
     * @param field_type $_batch_id
     */
    public function setBatch_id ($_batch_id)
    {
        $this->_batch_id = $_batch_id;
    }
    /**
     * @return the $_semester_id
     */
    public function getSemester_id ($throw_exception = FALSE)
    {
        if ($throw_exception) {
            $error = 'Semester is empty.';
            throw new Exception($error, Zend_Log::ERR);
        }
        return $this->_semester_id;
    }
    /**
     * @param field_type $_semester_id
     */
    public function setSemester_id ($_semester_id)
    {
        $this->_semester_id = $_semester_id;
    }
    /**
     * @return the $_semester_type
     */
    public function getSemester_type ()
    {
        return $this->_semester_type;
    }
    /**
     * @param field_type $_semester_type
     */
    public function setSemester_type ($_semester_type)
    {
        $this->_semester_type = $_semester_type;
    }
    /**
     * @return the $_semester_duration
     */
    public function getSemester_duration ()
    {
        return $this->_semester_duration;
    }
    /**
     * @param field_type $_semester_duration
     */
    public function setSemester_duration ($_semester_duration)
    {
        $this->_semester_duration = $_semester_duration;
    }
    /**
     * @return the $_handled_by_dept
     */
    public function getHandled_by_dept ()
    {
        return $this->_handled_by_dept;
    }
    /**
     * @param field_type $_handled_by_dept
     */
    public function setHandled_by_dept ($_handled_by_dept)
    {
        $this->_handled_by_dept = $_handled_by_dept;
    }
    /**
     * @return the $_start_date
     */
    public function getStart_date ()
    {
        return $this->_start_date;
    }
    /**
     * @param field_type $_start_date
     */
    public function setStart_date ($_start_date)
    {
        $this->_start_date = $_start_date;
    }
    /**
     * @return the $_completion_date
     */
    public function getCompletion_date ()
    {
        return $this->_completion_date;
    }
    /**
     * @param field_type $_completion_date
     */
    public function setCompletion_date ($_completion_date)
    {
        $this->_completion_date = $_completion_date;
    }
    /**
     * @return the $_is_active
     */
    public function getIs_active ()
    {
        return $this->_is_active;
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
     * @param Core_Model_Mapper_Class $mapper
     * @return Core_Model_Class
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Core_Model_Mapper_Class
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_Class());
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
        $class_id = $this->getClass_id();
        if (empty($class_id)) {
            $error = 'Please provide a Class Id';
            throw new Exception($error, Zend_Log::ERR);
        } else {
            $info = $this->getMapper()->fetchInfo($class_id);
            if (sizeof($info) == 0) {
                return false;
            } else {
                $this->setOptions($info);
            }
        }
    }
    /**
     * 
     * fetches the Class Ids of a batch
     * @param bool $batch_specific optional
     * @param bool $semester_specific optional 
     * @param bool $active optional
     * @throws Exception
     * @return array|int|false
     */
    public function fetchClassIds ($batch_specific = null, $semester_specific = null, 
    $active = null)
    {
        if ($semester_specific == true) {
            $semester_id = $this->getSemester_id(true);
        }
        if (isset($batch_specific)) {
            $batch_id = $this->getBatch_id(true);
        }
        if ($active == true) {
            $is_active = $this->getIs_active(true);
        }
        $class_ids = array();
        $class_ids = $this->getMapper()->fetchClassIds(null, null, $batch_id, 
        $semester_id,$is_active);
        if (empty($class_ids) == 0) {
            return false;
        } elseif (sizeof($class_ids) == 1) {
            return $class_ids[0];
        } else {
            return $class_ids;
        }
    }
    public function fetchStudents ()
    {}
    public function save ($data_array)
    {
        $preparedDataForSaveProcess = $this->prepareDataForSaveProcess(
        $data_array);
        $this->setOptions($preparedDataForSaveProcess);
        $this->getMapper()->save($preparedDataForSaveProcess);
    }
}