<?php
class Acad_Model_DmcMarks extends Acad_Model_Generic
{
    protected $_dmc_marks_id;
    protected $_student_subject_id;
    protected $_dmc_info_id;
    protected $_internal;
    protected $_external;
    protected $_percentage;
    protected $_is_pass;
    protected $_is_considered;
    protected $_is_verified;
    protected $_date;
    protected $_mapper;
    /**
     * @return the $_dmc_marks_id
     */
    public function getDmc_marks_id ()
    {
        return $this->_dmc_marks_id;
    }
    /**
     * @param field_type $_dmc_marks_id
     */
    public function setDmc_marks_id ($_dmc_marks_id)
    {
        $this->_dmc_marks_id = $_dmc_marks_id;
    }
    /**
     * @return the $_student_subject_id
     */
    public function getStudent_subject_id ()
    {
        return $this->_student_subject_id;
    }
    /**
     * @param field_type $_student_subject_id
     */
    public function setStudent_subject_id ($_student_subject_id)
    {
        $this->_student_subject_id = $_student_subject_id;
    }
    /**
     * @return the $_dmc_info_id
     */
    public function getDmc_info_id ()
    {
        return $this->_dmc_info_id;
    }
    /**
     * @param field_type $_dmc_info_id
     */
    public function setDmc_info_id ($_dmc_info_id)
    {
        $this->_dmc_info_id = $_dmc_info_id;
    }
    /**
     * @return the $_internal
     */
    public function getInternal ()
    {
        return $this->_internal;
    }
    /**
     * @param field_type $_internal
     */
    public function setInternal ($_internal)
    {
        $this->_internal = $_internal;
    }
    /**
     * @return the $_external
     */
    public function getExternal ()
    {
        return $this->_external;
    }
    /**
     * @param field_type $_external
     */
    public function setExternal ($_external)
    {
        $this->_external = $_external;
    }
    /**
     * @return the $_percentage
     */
    public function getPercentage ()
    {
        return $this->_percentage;
    }
    /**
     * @param field_type $_percentage
     */
    public function setPercentage ($_percentage)
    {
        $this->_percentage = $_percentage;
    }
    /**
     * @return the $_is_pass
     */
    public function getIs_pass ()
    {
        return $this->_is_pass;
    }
    /**
     * @param field_type $_is_pass
     */
    public function setIs_pass ($_is_pass)
    {
        $this->_is_pass = $_is_pass;
    }
    /**
     * @return the $_is_considered
     */
    public function getIs_considered ()
    {
        return $this->_is_considered;
    }
    /**
     * @param field_type $_is_considered
     */
    public function setIs_considered ($_is_considered)
    {
        $this->_is_considered = $_is_considered;
    }
    /**
     * @return the $_is_verified
     */
    public function getIs_verified ()
    {
        return $this->_is_verified;
    }
    /**
     * @param field_type $_is_verified
     */
    public function setIs_verified ($_is_verified)
    {
        $this->_is_verified = $_is_verified;
    }
    /**
     * @return the $_date
     */
    public function getDate ()
    {
        return $this->_date;
    }
    /**
     * @param field_type $_date
     */
    public function setDate ($_date)
    {
        $this->_date = $_date;
    }
    /**
     * Sets Mapper
     * @param Acad_Model_Mapper_DmcMarks $mapper
     * @return Acad_Model_DmcMarks
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_DmcMarks
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_DmcMarks());
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
    /* public function fetchInfo ()
    {
        $result_type_id = $this->getResult_type_id();
        $student_subject_id = $this->getStudent_subject_id();
        $considered = $this->getIs_considered();
        $info = $this->getMapper()->fetchInfo($student_subject_id, 
        $result_type_id, $considered);
        if (sizeof($info) == 0) {
            return false;
        } else {
            $this->setOptions($info);
            return $this;
        }
    }*/
    public function save ($data_array)
    {
        $preparedDataForSaveProcess = $this->prepareDataForSaveProcess(
        $data_array);
        $this->setOptions($preparedDataForSaveProcess);
        $this->getMapper()->save($preparedDataForSaveProcess);
    }
}