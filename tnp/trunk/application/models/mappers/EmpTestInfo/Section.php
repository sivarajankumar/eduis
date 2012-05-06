<?php
class Tnp_Model_Mapper_EmpTestInfo_Section
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_EmpTestInfo_Section
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
            $this->setDbTable('Tnp_Model_DbTable_EmployabilityTestSection');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @param integer $test_section_id
     */
    public function fetchInfo ($test_section_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $emp_test_section_table = $db_table->info('name');
        $required_cols = array('test_section_id', 'employability_test_id', 
        'test_section_name');
        $select = $adapter->select()
            ->from($emp_test_section_table, $required_cols)
            ->where('test_section_id = ?', $test_section_id);
        $emp_test_section_info = array();
        $emp_test_section_info = $select->query()->fetchAll(
        Zend_Db::FETCH_UNIQUE);
        return $emp_test_section_info[$test_section_id];
    }
    public function fetchTestSections ()
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $emp_test_section_table = $db_table->info('name');
        $required_cols = array('employability_test_id', 'test_section_id');
        $select = $adapter->select()->from($emp_test_section_table, 
        $required_cols);
        $emp_test_sections = array();
        $test_section_info = array();
        $test_section_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        foreach ($test_section_info as $employability_test_id => $test_section_id_array) {
            $emp_test_sections[$employability_test_id] = $test_section_id_array['test_section_id'];
        }
        return $emp_test_sections;
    }
    /*
     * @todo
     */
    public function fetchIds ()
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $emp_test_section_table = $db_table->info('name');
        $required_cols = array('test_section_id');
        $select = $adapter->select()->from($emp_test_section_table, 
        $required_cols);
        //$select->where('functional_area_id = ?', $functional_area_id);
        $test_section_ids = array();
        $test_section_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $test_section_ids;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $test_section_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'test_section_id = ' . $test_section_id;
        return $dbtable->update($prepared_data, $where);
    }
}
