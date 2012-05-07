<?php
class Tnp_Model_Mapper_EmpTestInfo_SectionScore
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_EmpTestInfo_SectionScore
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
            $this->setDbTable('Tnp_Model_DbTable_EmployabilityTestSectionScore');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @param integer $section_score_id
     */
    public function fetchInfo ($section_score_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $emp_test_section_score_table = $db_table->info('name');
        $required_cols = array('section_score_id', 'test_section_id', 
        'member_id', 'employability_test_id', 'section_marks', 
        'section_percentile');
        $select = $adapter->select()
            ->from($emp_test_section_score_table, $required_cols)
            ->where('section_score_id = ?', $section_score_id);
        $emp_test_section_score_info = array();
        $emp_test_section_score_info = $select->query()->fetchAll(
        Zend_Db::FETCH_UNIQUE);
        return $emp_test_section_score_info[$section_score_id];
    }
    /*
     * @todo
     */
    public function fetchSectionScoreIds ($member_id = null, $test_section_id = null, 
    $employability_test_id = null, $section_marks = null, $section_percentile = null)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $emp_test_section_table = $db_table->info('name');
        $required_cols = array('section_score_id');
        $select = $adapter->select()->from($emp_test_section_table, 
        $required_cols);
        if (! empty($member_id)) {
            $select->where('member_id = ?', $member_id);
        }
        if (! empty($test_section_id)) {
            $select->where('test_section_id = ?', $test_section_id);
        }
        if (! empty($employability_test_id)) {
            $select->where('employability_test_id = ?', $employability_test_id);
        }
        if (! empty($section_marks)) {
            $select->where('section_marks = ?', $section_marks);
        }
        if (! empty($section_percentile)) {
            $select->where('section_percentile = ?', $section_percentile);
        }
        $section_score_ids = array();
        $section_score_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $section_score_ids;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $section_score_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'section_score_id = ' . $section_score_id;
        return $dbtable->update($prepared_data, $where);
    }
}
