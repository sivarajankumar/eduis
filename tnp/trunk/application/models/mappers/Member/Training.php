<?php
class Tnp_Model_Mapper_Member_Training
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Member_Training
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
            $this->setDbTable('Tnp_Model_DbTable_StudentTraining');
        }
        return $this->_dbTable;
    }
    public function fetchInfo ($member_id, $training_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $student_training_table = $db_table->info('name');
        $required_cols = array('member_id', 'training_id', 'training_institute', 
        'start_date', 'completion_date', 'training_semester');
        $select = $adapter->select()
            ->from($student_training_table, $required_cols)
            ->where('member_id = ?', $member_id)
            ->where('training_id = ?', $training_id);
        $student_training_table_info = array();
        $student_training_table_info = $select->query()->fetchAll(
        Zend_Db::FETCH_UNIQUE);
        return $student_training_table_info[$member_id];
    }
    public function fetchMemberIds ($training_id = null, $training_institute = null, 
    $start_date = null, $completion_date = null, $training_semester = null)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $student_training_table = $db_table->info('name');
        $required_cols = array('member_id');
        $select = $adapter->select()->from($student_training_table, 
        $required_cols);
        if (! empty($training_id)) {
            $select->where('training_id = ?', $training_id);
        }
        if (! empty($training_institute)) {
            $select->where('training_institute = ?', $training_institute);
        }
        if (! empty($start_date)) {
            $select->where('start_date = ?', $start_date);
        }
        if (! empty($completion_date)) {
            $select->where('completion_date = ?', $completion_date);
        }
        if (! empty($training_semester)) {
            $select->where('training_semester = ?', $training_semester);
        }
        $member_ids = array();
        $member_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $member_ids;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $member_id, $training_id)
    {
        $dbtable = $this->getDbTable();
        $where1 = 'member_id = ' . $member_id;
        $where2 = 'training_id = ' . $training_id;
        return $dbtable->update($prepared_data, array($where1, $where2));
    }
}