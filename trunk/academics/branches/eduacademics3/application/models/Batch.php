<?php
class Acad_Model_Batch extends Acad_Model_Generic
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
     * @return the $_department_id
     */
    public function getDepartment_id ()
    {
        return $this->_department_id;
    }
    /**
     * @param field_type $_department_id
     */
    public function setDepartment_id ($_department_id)
    {
        $this->_department_id = $_department_id;
    }
    /**
     * @return the $_programme_id
     */
    public function getProgramme_id ()
    {
        return $this->_programme_id;
    }
    /**
     * @param field_type $_programme_id
     */
    public function setProgramme_id ($_programme_id)
    {
        $this->_programme_id = $_programme_id;
    }
    /**
     * @return the $_batch_start
     */
    public function getBatch_start ()
    {
        return $this->_batch_start;
    }
    /**
     * @param field_type $_batch_start
     */
    public function setBatch_start ($_batch_start)
    {
        $this->_batch_start = $_batch_start;
    }
    /**
     * @return the $_batch_number
     */
    public function getBatch_number ()
    {
        return $this->_batch_number;
    }
    /**
     * @param field_type $_batch_number
     */
    public function setBatch_number ($_batch_number)
    {
        $this->_batch_number = $_batch_number;
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
     * @param Acad_Model_Mapper_Batch $mapper
     * @return Acad_Model_Batch
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Batch
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Batch());
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
            $careless_error = 'Please provide a Batch_Id';
            throw new Exception($careless_error);
        } else {
            $info = $this->getMapper()->fetchPersonalInfo($member_id);
            if (sizeof($info) == 0) {
                return false;
            } else {
                $this->setOptions($info);
                return true;
            }
        }
    }
    /**
     * Enter description here ...
     * @param boolean $department_specific
     * @param boolean $programme_specific
     */
    public function fetchBatchId ($department_specific = null, 
    $programme_specific = null)
    {
        $department_id = $this->getDepartment_id();
        $programme_id = $this->getProgramme_id();
        $start_year = $this->getBatch_start();
        $basis = '';
        if (! empty($department_specific) and $department_specific == true) {
            $basis = 'department';
            $department_id=$this->getDepartment_id();
        }
        if (! empty($programme_specific) and $programme_specific == true) {
            $basis = 'programme';
            $programme_id=$this->getProgramme_id();
        }
        switch ($basis) {
            case 'department':
                $semester_id = $this->getSemester_id();
                $batch_id = $this->getBatch_id();
                if (empty($department_id)) {
                    $careless_error = 'Insufficient Params supplied to fetchBatchId(). Department id required';
                    throw new Exception($careless_error);
                } else {
                    $class_ids = $this->getMapper()->fetchClassIds(null, null, 
                    $batch_id, $semester_id);
                    if (sizeof($class_ids) == 0) {
                        return false;
                    } elseif (sizeof($class_ids) == 1) {
                        return $class_ids[0];
                    } else {
                        return $class_ids;
                    }
                }
                break;
                  case 'programme':
                $semester_id = $this->getSemester_id();
                $batch_id = $this->getBatch_id();
                if (empty($semester_id) or empty($batch_id)) {
                    $careless_error = 'Insufficient Params supplied to fetchBatchAllClassIds(). Semester id  and Batch id required';
                    throw new Exception($careless_error);
                } else {
                    $class_ids = $this->getMapper()->fetchClassIds(null, null, 
                    $batch_id, $semester_id);
                    if (sizeof($class_ids) == 0) {
                        return false;
                    } elseif (sizeof($class_ids) == 1) {
                        return $class_ids[0];
                    } else {
                        return $class_ids;
                    }
                }
                break;
                default:
                    break;
                
        }
        $this->getMapper()->fetchBatchId();
    }
    public function save ($data_array)
    {
        $preparedDataForSaveProcess = $this->prepareDataForSaveProcess(
        $data_array);
        $this->setOptions($preparedDataForSaveProcess);
        $this->getMapper()->save($preparedDataForSaveProcess);
    }
}