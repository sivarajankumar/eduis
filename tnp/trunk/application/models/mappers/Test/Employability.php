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
    public function fetchTestInfo (Tnp_Model_Test_Employability $test)
    {
        $employability_test_id = $test->getEmployability_test_id();
        if (! isset($employability_test_id)) {
            $error = 'Please provide some test id to work on';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('employability_test_id', 'test_name', 
            'date_of_conduct');
            $select = $adapter->select()
                ->from('employability_test', $required_fields)
                ->where('employability_test_id = ?', $employability_test_id);
            $test_info = array();
            $test_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $test_info[$employability_test_id];
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
    public function fetchTestSectionInfo (Tnp_Model_Test_Employability $test)
    {
        $test_section_id = $test->getTest_section_id();
        if (! isset($test_section_id)) {
            $error = 'Please provide some test_section_id to work on';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('test_section_id', 
            'test_section_name');
            $select = $adapter->select()
                ->from('employability_test_section', $required_fields)
                ->where('test_section_id = ?', $test_section_id);
            $test_section_info = array();
            $test_section_info = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $test_section_info[$test_section_id];
        }
    }
    /**
     * 
     * Enter description here ...
     * @param Tnp_Model_Test_Employability $test
     */
    public function fetchMemberSectionRecord (Tnp_Model_Test_Employability $test)
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
    public function fetchMemberTestRecord (Tnp_Model_Test_Employability $test)
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
            return $member_test_record;
        }
    }
    /**
     * Enter description here ...
     * @param Tnp_Model_Profile_Components_Training $training
     * @param array $property_range Example :array('name'=>array('from'=>n ,'to'=>m));
     * here 'from' stands for >= AND 'to' stands for <=
     * 
     */
    public function fetchStudents (
    Tnp_Model_Profile_Components_Training $training, 
    array $setter_options = null, array $property_range = null)
    {
        $setter_options_keys = array_keys($setter_options);
        $property_range_keys = array_keys($property_range);
        $merge = array_merge($setter_options_keys, $property_range_keys);
        //declare table name and table columns for join statement
        $table = (array('e_t_rec' => $this->getDbTable()->info('name')));
        $name1 = array('e_t' => 'employability_test');
        $cond1 = 'e_t_rec.employability_test_id = e_t.employability_test_id';
        $name2 = array('e_t_sec_scr' => 'employability_test_section_score');
        $cond2 = ' e_t_sec_scr.employability_test_id= e_t_rec.employability_test_id';
        $name3 = array('e_t_sec' => 'employability_test_section');
        $cond3 = ' e_t_sec_scr.test_section_id= e_t_sec.test_section_id';
        //(1)get column names of employability_test present in arguments received
        $e_t_col = array('test_name', 'date_of_conduct');
        $e_t_intrsctn = array();
        $e_t_intrsctn = array_intersect($e_t_col, $merge);
        //(2)get column names of employability_test_section_score present in arguments received
        $e_t_sec_scr_col = array('test_section_id', 'section_marks', 
        'section_percentile');
        $e_t_sec_scr_intrsctn = array();
        $e_t_sec_scr_intrsctn = array_intersect($e_t_sec_scr_col, $merge);
        //(3)get column names of employability_test_section present in arguments received
        $e_t_sec_col = array('test_name', 'test_section_name');
        $e_t_sec_intrsctn = array();
        $e_t_sec_intrsctn = array_intersect($e_t_sec_col, $merge);
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()->from($table, 'member_id');
        if (! empty($e_t_intrsctn)) {
            $select->join($name1, $cond1);
        }
        if (! empty($e_t_sec_scr_intrsctn)) {
            $select->join($name2, $cond2);
        }
        if (! empty($e_t_sec_intrsctn)) {
            $select->join($name3, $cond3);
        }
        foreach ($property_range as $key => $range) {
            if (! empty($range['from'])) {
                $select->where("$key >= ?", $range['from']);
            }
            if (! empty($range['to'])) {
                $select->where("$key <= ?", $range['to']);
            }
        }
        foreach ($setter_options as $property_name => $value) {
            $getter_string = 'get' . ucfirst($property_name);
            $training->$getter_string();
            $condition = $property_name . ' = ?';
            $select->where($condition, $value);
        }
        $result = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        if (! empty($result)) {
            $serach_error = 'No results match your search criteria.';
            return $serach_error;
        } else {
            return $result;
        }
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
}
