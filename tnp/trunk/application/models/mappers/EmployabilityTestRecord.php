<?php
class Tnp_Model_Mapper_EmployabilityTestRecord
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_EmployabilityTestRecord
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
            $this->setDbTable('Tnp_Model_DbTable_EmployabilityTestRecord');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @param integer $test_record_id
     */
    public function fetchInfo ($test_record_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $emp_test_record_table = $db_table->info('name');
        $required_cols = array('test_record_id', 'member_id', 
        'employability_test_id', 'test_regn_no', 'test_total_score', 
        'test_percentile');
        $select = $adapter->select()
            ->from($emp_test_record_table, $required_cols)
            ->where('test_record_id = ?', $test_record_id);
        $emp_test_record_info = array();
        $emp_test_record_info = $select->query()->fetchAll(
        Zend_Db::FETCH_UNIQUE);
        return $emp_test_record_info[$test_record_id];
    }
    public function fetchTestRecordIds ($member_id = null, 
    $employability_test_id = null, $test_regn_no = null, $test_total_score = null, 
    $test_percentile = null)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $emp_test_section_record_table = $db_table->info('name');
        $required_cols = array('employability_test_id');
        $select = $adapter->select()->from($emp_test_section_record_table, 
        $required_cols);
        if (! empty($member_id)) {
            $select->where('member_id = ?', $member_id);
        }
        if (! empty($employability_test_id)) {
            $select->where('employability_test_id=?', $employability_test_id);
        }
        if (! empty($test_regn_no)) {
            $select->where('test_regn_no=?', $test_regn_no);
        }
        if (! empty($test_total_score)) {
            $select->where('test_total_score=?', $test_total_score);
        }
        if (! empty($test_percentile)) {
            $select->where('test_percentile=?', $test_percentile);
        }
        $record_ids = array();
        $record_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $record_ids;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $test_record_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'test_record_id = ' . $test_record_id;
        return $dbtable->update($prepared_data, $where);
    }
}
