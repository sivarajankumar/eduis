<?php
class Tnp_Model_EmpTestInfo_Section extends Tnp_Model_Generic
{
    protected $_test_section_id;
    protected $_employability_test_id;
    protected $_test_section_name;
    protected $_mapper;
    /**
     * @return the $_test_section_id
     */
    public function getTest_section_id ($throw_exception = null)
    {
        $test_section_id = $this->_test_section_id;
        if (empty($test_section_id) and $throw_exception == true) {
            $message = '_test_section_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $test_section_id;
        }
    }
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
     * @return the $_test_section_name
     */
    public function getTest_section_name ($throw_exception = null)
    {
        return $this->_test_section_name;
        $test_section_name = $this->_test_section_name;
        if (empty($test_section_name) and $throw_exception == true) {
            $message = '_test_section_name is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $test_section_name;
        }
    }
    /**
     * @param field_type $_test_section_id
     */
    public function setTest_section_id ($_test_section_id)
    {
        $this->_test_section_id = $_test_section_id;
    }
    /**
     * @param field_type $_employability_test_id
     */
    public function setEmployability_test_id ($_employability_test_id)
    {
        $this->_employability_test_id = $_employability_test_id;
    }
    /**
     * @param field_type $_test_section_name
     */
    public function setTest_section_name ($_test_section_name)
    {
        $this->_test_section_name = $_test_section_name;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_EmpTestInfo_Section $mapper
     * @return Tnp_Model_Core_Training
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_EmpTestInfo_Section
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_EmpTestInfo_Section());
        }
        return $this->_mapper;
    }
}