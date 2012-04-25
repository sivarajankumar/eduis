<?php
class Acad_Model_Mapper_Batch
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Batch
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
            $this->setDbTable('Acad_Model_DbTable_Batch');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches Batch details
     * 
     * @param integer $batch_id
     */
    public function fetchInfo ($batch_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = new Acad_Model_DbTable_Batch();
        $batch_table = $db_table->info('name');
        $required_cols = array('batch_id', 'department_id', 'programme_id', 
        'batch_start', 'batch_number', 'is_active');
        $select = $adapter->select()
            ->from($batch_table, $required_cols)
            ->where('batch_id = ?', $batch_id);
        $student_info = array();
        $student_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $student_info[$batch_id];
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        try {
            $row_id = $dbtable->insert($prepared_data);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}