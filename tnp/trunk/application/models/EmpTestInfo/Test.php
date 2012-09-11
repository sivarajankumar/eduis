<?php
class Tnp_Model_EmpTestInfo_Test extends Tnp_Model_Generic
{
    protected $_employability_test_id;
    protected $_test_name;
    protected $_date_of_conduct;
    protected $_mapper;
    /**
     * @return the $_employability_test_id
     */
    public function getEmployability_test_id ($throw_exception = null)
    {
        $employability_test_id = $this->_employability_test_id;
        if (empty($employability_test_id) and $throw_exception == true) {
            $message = '_employability_test_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $employability_test_id;
        }
    }
    /**
     * @return the $_test_name
     */
    public function getTest_name ($throw_exception = null)
    {
        $test_name = $this->_test_name;
        if (empty($test_name) and $throw_exception == true) {
            $message = '_test_name is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $test_name;
        }
    }
    /**
     * @return the $_date_of_conduct
     */
    public function getDate_of_conduct ()
    {
        return $this->_date_of_conduct;
    }
    /**
     * @param field_type $_employability_test_id
     */
    public function setEmployability_test_id ($_employability_test_id)
    {
        $this->_employability_test_id = $_employability_test_id;
    }
    /**
     * @param field_type $_test_name
     */
    public function setTest_name ($_test_name)
    {
        $this->_test_name = $_test_name;
    }
    /**
     * @param field_type $_date_of_conduct
     */
    public function setDate_of_conduct ($_date_of_conduct)
    {
        $this->_date_of_conduct = $_date_of_conduct;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_EmployabilityTest $mapper
     * @return Tnp_Model_EmpTestInfo_Test
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_EmployabilityTest
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_EmployabilityTest());
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
     * the date format must be yyyy.MM.dd (dot as separator)
     * Enter description here ...
     * @param bool $test_name
     * @param bool $date_of_conduct
     */
    public function fetchTestsIds ($test_name_specific = null, 
    $date_of_conduct_secific = null)
    {
        $test_name = null;
        $date_of_conduct = null;
        if ($test_name_specific == true) {
            $test_name = $this->getTest_name(true);
        }
        if ($date_of_conduct_secific == true) {
            $date_of_conduct = $this->getDate_of_conduct(true);
        }
        $emp_test_ids = array();
        $emp_test_ids = $this->getMapper()->fetchTestsIds($test_name, 
        $date_of_conduct);
        if (empty($emp_test_ids)) {
            return false;
        } else {
            return $emp_test_ids;
        }
    }
    /**
     * 
     *@return Tnp_Model_EmpTestInfo_Test|false
     */
    public function fetchInfo ()
    {
        $emp_test_id = $this->getEmployability_test_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($emp_test_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
    public function fetchTests ()
    {
        $tests = array();
        $tests = $this->getMapper()->fetchTests();
        if (empty($tests)) {
            return false;
        } else {
            return array_unique($tests);
        }
    }
    public function save ($data_array)
    {
        if (! empty($data_array['test_name']) and
         ! empty($data_array['date_of_conduct'])) {
            $test_name = $data_array['test_name'];
            $date_of_conduct = $data_array['date_of_conduct'];
            $this->setTest_name($test_name);
            $this->setDate_of_conduct($date_of_conduct);
            $employability_test_id = $this->fetchTestsIds(true, true);
            if (isset($employability_test_id)) {
                return array_pop($employability_test_id);
            } else {
                return $this->saveInfo($data_array);
            }
        }
    }
    private function saveInfo ($data_array)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($data_array);
        return $this->getMapper()->save($prepared_data);
    }
    public function update ($data_array)
    {
        $test_id = $this->getEmployability_test_id(true);
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($data_array);
        return $this->getMapper()->update($prepared_data, $test_id);
    }
    public function deleteTest ()
    {
        $test_id = $this->getEmployability_test_id(true);
        return $this->getMapper()->delete($test_id);
    }
}