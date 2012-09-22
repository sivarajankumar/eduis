<?php
class Acad_Model_Mapper_StudentCompetitiveExam
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_StudentCompetitiveExam
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
            $this->setDbTable('Acad_Model_DbTable_StudentCompetitiveExam');
        }
        return $this->_dbTable;
    }
    public function fetchExamIds ($member_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $stu_comp_table = $db_table->info('name');
        $required_cols = array('exam_id');
        $select = $adapter->select()
            ->from($stu_comp_table, $required_cols)
            ->where('member_id = ?', $member_id);
        $exam_ids = array();
        $exam_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $exam_ids;
    }
    public function fetchExamInfo ($member_id, $exam_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $stu_comp_table = $db_table->info('name');
        $required_cols = array('member_id', 'exam_id', 'roll_no', 'date', 
        'total_score', 'all_india_rank');
        $select = $adapter->select()
            ->from($stu_comp_table, $required_cols)
            ->where('member_id = ?', $member_id)
            ->where('exam_id = ?', $exam_id);
        $exam_info = array();
        $exam_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        if (empty($exam_info)) {
            return false;
        } else {
            return $exam_info[$member_id];
        }
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $member_id, $exam_id)
    {
        $dbtable = $this->getDbTable();
        $where1 = 'member_id = ' . $member_id;
        $where2 = 'exam_id = ' . $exam_id;
        return $dbtable->update($prepared_data, array($where1, $where2));
    }
}