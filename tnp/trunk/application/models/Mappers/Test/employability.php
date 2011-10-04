<?php
class Tnp_Model_Mapper_Test_Employability
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Test_Employability
     */
    public function setDbTable ($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (! $dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    /**
     * Get registered Zend_Db_Table instance
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Tnp_Model_DbTable_Employability');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * Enter description here ...
     * @param Tnp_Model_Test_Employability $test
     */
    public function fetchTestId (Tnp_Model_Test_Employability $test)
    {
        $test_name = $test->getTest_name();
        $date_of_conduct = $test->getDate_of_conduct();
        if (! isset($test_name) or ! isset($date_of_conduct)) {
            $error = 'Please set Date Of Conduct and Test Name both';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('employability_test_id');
            $select = $adapter->select()
                ->from('employability_test', $required_fields)
                ->where('test_name = ?', $test_name)
                ->where('date_of_conduct = ?', $date_of_conduct);
            $employability_test_id = $select->query()->fetchColumn();
            $test->setEmployability_test_id($employability_test_id);
        }
    }
    /**
     * 
     * Enter description here ...
     * @param Tnp_Model_Test_Employability $test
     */
    public function fetchTestDetails (Tnp_Model_Test_Employability $test)
    {
        $employability_test_id = $test->getEmployability_test_id();
        if (! isset($employability_test_id)) {
            $error = 'Please provide some test id to work on';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('test_name', 'date_of_conduct');
            $select = $adapter->select()
                ->from('employability_test', $required_fields)
                ->where('employability_test_id = ?', $employability_test_id);
            $test_Details = array();
            $test_Details = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            $test_name = array_keys($test_Details);
            $date_of_conduct = $test_name[0];
            $test->setTest_name($test_name);
            $test->setDate_of_conduct($date_of_conduct);
        }
    }
    /**
     * 
     * Enter description here ...
     * @param Tnp_Model_Test_Employability $test
     */
    public function fetchTestSectionId (Tnp_Model_Test_Employability $test)
    {
        $test_name = $test->getTest_name();
        $section_name = $test->getTest_section_name();
        if (! isset($test_name) or ! isset($section_name)) {
            $error = 'Please set Test Name and Section Name both';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('test_section_id');
            $select = $adapter->select()
                ->from('employability_test_section', $required_fields)
                ->where('test_name = ?', $test_name)
                ->where('test_section_name = ?', $section_name);
            $section_id = $select->query()->fetchColumn();
            $test->setTest_section_id($section_id);
        }
    }
    /**
     * 
     * Enter description here ...
     * @param Tnp_Model_Test_Employability $test
     */
    public function fetchTestSectionDetails (Tnp_Model_Test_Employability $test)
    {
        $test_section_id = $test->getTest_section_id();
        if (! isset($test_section_id)) {
            $error = 'Please provide some test_section_id to work on';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('test_name', 'test_section_name');
            $select = $adapter->select()
                ->from('employability_test_section', $required_fields)
                ->where('test_section_id = ?', $test_section_id);
            $test_Details = array();
            $test_Details = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            $test_name = array_keys($test_Details);
            $test_section_name = $test_name[0];
            $test->setTest_name($test_name);
            $test->setTest_section_name($test_section_name);
        }
    }
    /**
     * 
     * Enter description here ...
     * @param Tnp_Model_Test_Employability $test
     */
    public function fetchSectionRecord (Tnp_Model_Test_Employability $test)
    {
        $member_id = $test->getMember_id();
        $employability_test_id = $test->getEmployability_test_id();
        if (! isset($member_id) or ! isset($employability_test_id)) {
            $error = 'Both properties(member id and testid) must be set';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('test_section_id', 'section_marks', 
            'section_percentile');
            $select = $adapter->select()
                ->from('employability_test_section_score', $required_fields)
                ->where('member_id = ?', $member_id);
            $section_record = array();
            $section_record = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            //Zend_Registry::get('logger')->debug($section_record);
            return $section_record;
        }
    }
    /**
     * 
     * fetches the test record of a member
     * @param Tnp_Model_Test_Employability $test
     */
    public function fetchRecord (Tnp_Model_Test_Employability $test)
    {
        $member_id = $test->getMember_id();
        if (! isset($member_id)) {
            $error = 'member id must be set';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('employability_test_id', 'test_regn_no', 
            'test_total_score', 'test_percentile');
            $select = $adapter->select()
                ->from($this->getDbTable()
                ->info('name'), $required_fields)
                ->where('member_id = ?', $member_id);
            $member_test_record = array();
            $member_test_record = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            //Zend_Registry::get('logger')->debug($member_test_record);
            return $member_test_record;
        }
    }
}