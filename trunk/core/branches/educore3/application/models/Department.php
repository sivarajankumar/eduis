<?php
class Core_Model_Department extends Core_Model_Generic
{
    protected $_department_id;
    protected $_department_name;
    protected $_mapper;
    /**
     * @return the $_department_id
     */
    public function getDepartment_id ($throw_exception = null)
    {
        $department_id = $this->_department_id;
        if (empty($department_id) and $throw_exception == true) {
            $message = '_department_id is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $department_id;
        }
    }
    /**
     * @param field_type $_department_id
     */
    public function setDepartment_id ($_department_id)
    {
        $this->_department_id = $_department_id;
    }
    /**
     * Sets Mapper
     * @param Core_Model_Mapper_Department $mapper
     * @return Core_Model_Department
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Core_Model_Mapper_Department
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_Department());
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
     * $department['']=$department_name
     *
     */
    public function fetchDepartments ()
    {
        $departments = $this->getMapper()->fetchDepartments();
        if (empty($departments)) {
            return false;
        } else {
            return $departments;
        }
    }
    public function save ($dep_info)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($dep_info);
        return $this->getMapper()->save($prepared_data);
    }
    public function update ($dep_info, $dep_id)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($dep_info);
        return $this->getMapper()->update($prepared_data, $dep_id);
    }
}