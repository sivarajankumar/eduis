<?php
class Acad_Model_Mapper_StudentClass
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_StudentClass
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
            $this->setDbTable('Acad_Model_DbTable_StudentClass');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches Class details of a student
     * 
     * @param integer $member_id
     */
    public function fetchInfo ($member_id, $class_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $stu_class_table = $db_table->info('name');
        $required_cols = array('member_id', 'class_id', 'group_id', 'roll_no', 
        'start_date', 'completion_date', 'is_initial_batch_identifier');
        $select = $adapter->select()
            ->from($stu_class_table, $required_cols)
            ->where('member_id = ?', $member_id)
            ->where('class_id = ?', $class_id);
        $student_info = array();
        $student_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $student_info[$member_id];
    }
    /**
     * Fetches all Classes in which a student has/had enrolled
     * 
     * @param integer $member_id
     */
    public function fetchClassIds ($member_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $stu_class_table = $db_table->info('name');
        $required_cols = array('class_id');
        $select = $adapter->select()
            ->from($stu_class_table, $required_cols)
            ->where('member_id = ?', $member_id);
        $class_ids = array();
        return $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
    }
    /**
     * Fetches all Classes in which a student has/had enrolled
     * 
     * @param integer $member_id
     */
    public function fetchBatchIdentifierClassId ($member_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $stu_class_table = $db_table->info('name');
        $required_cols = array('class_id');
        $select = $adapter->select()
            ->from($stu_class_table, $required_cols)
            ->where('is_initial_batch_identifier = ?', 1);
        $class_id = array();
        $class_id = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $class_id[0];
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $member_id, $class_id)
    {
        $dbtable = $this->getDbTable();
        $where1 = 'member_id = ' . $member_id;
        $where2 = 'class_id = ' . $class_id;
        return $dbtable->update($prepared_data, array($where1, $where2));
    }
}
?>