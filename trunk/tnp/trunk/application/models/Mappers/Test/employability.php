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
    public function fetchTestId ($test)
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
    public function fetchTestDetails ($test)
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
    public function fetchTestSectionId ($test)
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
    public function fetchTestSectionDetails ($test)
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
    public function fetchSectionRecord ($test)
    {
        $test_section_id = $test->getTest_section_id();
        $member_id = $test->getMember_id();
        $employability_test_id = $test->getEmployability_test_id();
        if (! isset($test_section_id) or ! isset($member_id) or
         ! isset($employability_test_id)) {
            $error = 'All three properties(section id, member id and testid) must be set';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('section_marks', 'section_percentile');
            $select = $adapter->select()
                ->from('employability_test_section', $required_fields)
                ->where('test_section_id = ?', $test_section_id);
            $section_record = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            $section_marks = array_keys($section_record);
            $section_percentile = $section_record[0];
            $test->setSection_marks($section_marks);
            $test->setSection_percentile($section_percentile);
        }
    }
    /**
     * 
     * fetches the test record of a member
     * @param Tnp_Model_Test_Employability $test
     */
    public function fetchRecord ($test)
    {
        $member_id = $test->getMember_id();
        $employability_test_id = $test->getEmployability_test_id();
        if (isset($member_id) or ! isset($employability_test_id)) {
            $error = 'Both properties(member id and testid) must be set';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('test_regn_no', 'test_total_score','test_percentile');
            $select = $adapter->select()
                ->from('employability_test_section', $required_fields)
                ->where('employability_test_id = ?', $employability_test_id)
                ->where('member_id = ?', $member_id);
            $record = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            $test_regn_no = array_keys($record);
            $percentile = $test_regn_no[0]['test_percentile'];
            $test->setSection_marks($section_marks);
            $test->setSection_percentile($section_percentile);
        }
    }
}