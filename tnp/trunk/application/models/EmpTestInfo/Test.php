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
     * @param Tnp_Model_Mapper_EmpTestInfo_Test $mapper
     * @return Tnp_Model_EmpTestInfo_Test
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_EmpTestInfo_Test
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_EmpTestInfo_Test());
        }
        return $this->_mapper;
    }
}