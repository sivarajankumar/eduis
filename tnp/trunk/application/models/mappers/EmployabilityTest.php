<?php
class Tnp_Model_Mapper_EmployabilityTest
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_EmployabilityTest
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
            $this->setDbTable('Tnp_Model_DbTable_EmployabilityTest');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @param integer $employability_test_id
     */
    public function fetchInfo ($employability_test_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $emp_test_table = $db_table->info('name');
        $required_cols = array('employability_test_id','test_name', 'date_of_conduct');
        $select = $adapter->select()
            ->from($emp_test_table, $required_cols)
            ->where('employability_test_id = ?', $employability_test_id);
        $emp_test_info = array();
        $emp_test_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $emp_test_info[$employability_test_id];
    }
    public function fetchTests ()
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $emp_test_table = $db_table->info('name');
        $required_cols = array('employability_test_id', 'test_name');
        $select = $adapter->select()->from($emp_test_table, $required_cols);
        $emp_tests = array();
        $emp_test_info = array();
        $emp_test_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        foreach ($emp_test_info as $employability_test_id => $test_name_array) {
            $emp_tests[$employability_test_id] = $test_name_array['functional_area_name'];
        }
        return $emp_tests;
    }
    /**
     * 
     * Enter description here ...
     * @param int $test_name
     * @param date $date_of_conduct format must be yyyy.MM.dd (dot as separator)
     */
    public function fetchTestsIds ($test_name = null, $date_of_conduct = null)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $emp_test_table = $db_table->info('name');
        $required_cols = array('employability_test_id');
        $select = $adapter->select()->from($emp_test_table, $required_cols);
        if ($test_name == true) {
            $select->where('test_name = ?', $test_name);
        }
        if ($date_of_conduct == true) {
            $date_of_conduct = Zend_Locale_Format::getDate($date_of_conduct, 
            array('date_format' => 'yyyyMMdd', 'fix_date' => true));
            $select->where('date_of_conduct = ?', $date_of_conduct);
        }
        $emp_test_ids = array();
        $emp_test_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $emp_test_ids;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $employability_test_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'employability_test_id = ' . $employability_test_id;
        return $dbtable->update($prepared_data, $where);
    }
}
