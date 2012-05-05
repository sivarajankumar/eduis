<?php
class Acad_Model_Mapper_Subject
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Subject
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
            $this->setDbTable('Acad_Model_DbTable_Subject');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches Subject details
     * 
     * @param integer $subject_id
     */
    public function fetchInfo ($subject_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $subject_table = $db_table->info('name');
        $required_cols = array('subject_id', 'subject_code', 'abbr', 
        'subject_name', 'subject_type_id', 'is_optional', 'lecture_per_week', 
        'tutorial_per_week', 'practical_per_week', 'suggested_duration');
        $select = $adapter->select()
            ->from($subject_table, $required_cols)
            ->where('subject_id = ?', $subject_id);
        $subject_info = array();
        $subject_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $subject_info[$subject_id];
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $subject_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'subject_id = ' . $subject_id;
        return $dbtable->update($prepared_data, $where);
    }
}
?>