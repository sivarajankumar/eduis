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
        $db_table = $this->getDbTable();
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
    /**
     * 
     * fetches the Batch Ids
     * @param bool $batch_start optional
     * @param bool $department_id optional
     * @param bool $programme_id optional
     * @return array
     */
    public function fetchBatchIds ($batch_start = null, $department_id = null, 
    $programme_id = null)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $batch_table = $db_table->info('name');
        $required_cols = array('batch_id');
        $select = $adapter->select()->from($batch_table, $required_cols);
        if (isset($batch_start)) {
            $select->where('batch_start = ?', $batch_start);
        }
        if (isset($department_id)) {
            $select->where('department_id = ?', $department_id);
        }
        if (isset($programme_id)) {
            $select->where('programme_id = ?', $programme_id);
        }
        $batch_ids = array();
        $batch_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $batch_ids;
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