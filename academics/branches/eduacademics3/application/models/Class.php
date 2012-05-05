<?php
class Acad_Model_Class extends Acad_Model_Generic
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
    public function getClass_id ($throw_exception = null)
    {
        $class_id = $this->_class_id;
        if (empty($class_id) and $throw_exception == true) {
            $message = '_class_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $class_id;
        }
    }
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
     * @return the $_semester_id
     */
    public function getSemester_id ($throw_exception = null)
    {
        $semester_id = $this->_semester_id;
        if (empty($semester_id) and $throw_exception == true) {
            $message = '_semester_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $semester_id;
        }
    }
    /**
     * @return the $_semester_type
     */
    public function getSemester_type ()
    {
        return $this->_semester_type;
    }
    /**
     * @return the $_semester_duration
     */
    public function getSemester_duration ()
    {
        return $this->_semester_duration;
    }
    /**
     * @return the $_handled_by_dept
     */
    public function getHandled_by_dept ($throw_exception = null)
    {
        $handled_by_dept = $this->_handled_by_dept;
        if (empty($handled_by_dept) and $throw_exception == true) {
            $message = '_handled_by_dept is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $handled_by_dept;
        }
    }
    /**
     * @return the $_start_date
     */
    public function getStart_date ()
    {
        return $this->_start_date;
    }
    /**
     * @return the $_completion_date
     */
    public function getCompletion_date ()
    {
        return $this->_completion_date;
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
     * @param field_type $_class_id
     */
    public function setClass_id ($_class_id)
    {
        $this->_class_id = $_class_id;
    }
    /**
     * @param field_type $_batch_id
     */
    public function setBatch_id ($_batch_id)
    {
        $this->_batch_id = $_batch_id;
    }
    /**
     * @param field_type $_semester_id
     */
    public function setSemester_id ($_semester_id)
    {
        $this->_semester_id = $_semester_id;
    }
    /**
     * @param field_type $_semester_type
     */
    public function setSemester_type ($_semester_type)
    {
        $this->_semester_type = $_semester_type;
    }
    /**
     * @param field_type $_semester_duration
     */
    public function setSemester_duration ($_semester_duration)
    {
        $this->_semester_duration = $_semester_duration;
    }
    /**
     * @param field_type $_handled_by_dept
     */
    public function setHandled_by_dept ($_handled_by_dept)
    {
        $this->_handled_by_dept = $_handled_by_dept;
    }
    /**
     * @param field_type $_start_date
     */
    public function setStart_date ($_start_date)
    {
        $this->_start_date = $_start_date;
    }
    /**
     * @param field_type $_completion_date
     */
    public function setCompletion_date ($_completion_date)
    {
        $this->_completion_date = $_completion_date;
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
     * @param Acad_Model_Mapper_Class $mapper
     * @return Acad_Model_Class
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Class
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Class());
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
        $class_id = $this->getClass_id(true);
        $info = $this->getMapper()->fetchInfo($class_id);
        if (empty($info)) {
            return false;
        } else {
            $this->setOptions($info);
            return $this;
        }
    }
    /**
     * 
     * fetches the Class Ids of a batch
     * @param bool $batch_specific optional
     * @param bool $semester_specific optional 
     * @param bool $active optional
     * @return array|int|false
     */
    public function fetchClassIds ($batch_specific = null, $semester_specific = null, 
    $active = null)
    {
        $department_id = null;
        $programme_id = null;
        $batch_id = null;
        $semester_id = null;
        $is_active = null;
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
        $class_ids = $this->getMapper()->fetchClassIds($department_id, 
        $programme_id, $batch_id, $semester_id, $is_active);
        if (empty($class_ids)) {
            return false;
        } else {
            return $class_ids;
        }
    }
    public function fetchStudents ()
    {}
}