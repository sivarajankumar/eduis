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
     * @param Tnp_Model_Mapper_EmployabilityTestSection $mapper
     * @return Tnp_Model_Core_Training
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_EmployabilityTestSection
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_EmployabilityTestSection());
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
     * Enter description here ...
     * @param bool $test_specific
     * @param bool $section_name_specific
     */
    public function fetchTestSectionIds ($test_specific = null, 
    $section_name_specific = null)
    {
        $employability_test_id = null;
        $test_section_name = null;
        if ($test_specific) {
            $employability_test_id = $this->getEmployability_test_id(true);
        }
        if ($section_name_specific) {
            $test_section_name = $this->getTest_section_name(true);
        }
        $section_ids = array();
        $section_ids = $this->getMapper()->fetchTestSectionIds(
        $employability_test_id = null, $test_section_name = null);
        if (empty($section_ids)) {
            return false;
        } else {
            return $section_ids;
        }
    }
    /**
     * 
     * @return Tnp_Model_EmpTestInfo_Section|false
     */
    public function fetchInfo ()
    {
        $section_id = $this->getTest_section_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($section_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
    public function fetchTestSections ()
    {
        $test_sections = array();
        $employability_test_id = $this->getEmployability_test_id(true);
        $test_sections = $this->getMapper()->fetchTestSections(
        $employability_test_id);
        if (empty($test_sections)) {
            return false;
        } else {
            return $test_sections;
        }
    }
    public function saveInfo ($data_array)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($data_array);
        return $this->getMapper()->save($prepared_data);
    }
    public function updateInfo ($data_array)
    {
        $section_id = $this->getTest_section_id(true);
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($data_array);
        return $this->getMapper()->update($prepared_data, $section_id);
    }
    public function deleteSection ()
    {
        $section_id = $this->getTest_section_id(true);
        return $this->getMapper()->delete($section_id);
    }
}