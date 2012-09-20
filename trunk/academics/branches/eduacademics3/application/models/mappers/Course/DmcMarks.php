<?php
class Acad_Model_Mapper_Course_DmcMarks
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Course_DmcMarks
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
            $this->setDbTable('Acad_Model_DbTable_DmcMarks');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches Dmc marks
     * @param integer $student_subject_id
     * @param integer $result_type_id
     * @param boolean
     * @throws Exception
     */
    public function fetchInfo ($dmc_info_id, $student_subject_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $dmc_marks_table = $db_table->info('name');
        $required_cols = array('dmc_info_id', 'dmc_marks_id', 'internal', 
        'external', 'percentage', 'is_pass', 'is_verified', 'date', 
        'student_subject_id', 'max_marks');
        $select = $adapter->select()
            ->from($dmc_marks_table, $required_cols)
            ->where(' dmc_info_id= ?', $dmc_info_id)
            ->where(' student_subject_id= ?', $student_subject_id);
        $dmc_marks = array();
        $dmc_marks = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $dmc_marks[$dmc_info_id];
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $dmc_info_id, $student_subject_id)
    {
        $dbtable = $this->getDbTable();
        $where1 = 'dmc_info_id = ' . $dmc_info_id;
        $where2 = 'student_subject_id = ' . $student_subject_id;
        return $dbtable->update($prepared_data, array($where1, $where2));
    }
}
?>