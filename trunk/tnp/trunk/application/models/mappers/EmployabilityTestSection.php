<?php
class Tnp_Model_Mapper_EmployabilityTestSection
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_EmployabilityTestSection
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
    public function fetchTestSectionIds ($employability_test_id = null, 
    $test_section_name = null)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $emp_test_section_table = $db_table->info('name');
        $required_cols = array('test_section_id');
        $select = $adapter->select()->from($emp_test_section_table, 
        $required_cols);
        if ($employability_test_id == true) {
            $select->where('employability_test_id = ?', $employability_test_id);
        }
        if ($test_section_name == true) {
            $select->where('test_section_name = ?', $test_section_name);
        }
        $emp_test_sections = array();
        $emp_test_sections = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $emp_test_sections;
    }
    public function fetchTestSections ($employability_test_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $emp_test_section_table = $db_table->info('name');
        $required_cols = array('test_section_id', 'test_section_name');
        $select = $adapter->select()
            ->from($emp_test_section_table, $required_cols)
            ->where('employability_test_id = ?', $employability_test_id);
        $test_sections = array();
        $test_sections_info = array();
        $test_sections_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        foreach ($test_sections_info as $employability_test_id => $section_name_array) {
            $test_sections[$employability_test_id] = $section_name_array['test_section_name'];
        }
        return $test_sections;
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
    public function delete ($test_section_id)
    {
        $where = 'test_section_id = ' . $test_section_id;
        return $this->getDbTable()->delete($where);
    }
}
