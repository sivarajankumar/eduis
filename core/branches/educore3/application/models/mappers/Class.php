<?php
class Core_Model_Mapper_Class
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Core_Model_Mapper_Class
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
            $this->setDbTable('Core_Model_DbTable_Class');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches Class details
     * 
     * @param integer $class_id
     */
    public function fetchInfo ($class_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $class_table = $db_table->info('name');
        $required_cols = array('class_id', 'batch_id', 'semester_id', 
        'semester_type', 'semester_duration', 'handled_by_dept', 'start_date', 
        'completion_date', 'is_active');
        $select = $adapter->select()
            ->from($class_table, $required_cols)
            ->where('class_id = ?', $class_id);
        $class_info = array();
        $class_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $class_info[$class_id];
    }
    /**
     * Fetches Class Id
     * @param unknown_type $department_id
     * @param unknown_type $programme_id
     * @param unknown_type $semester_id
     */
    public function fetchClassIds ($department_id = null, $programme_id = null, 
    $batch_id = null, $semester_id = null, $is_active = null)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $class_dbtable = $this->getDbTable();
        $class_table = $class_dbtable->info('name');
        $batch_dbTable = new Core_Model_DbTable_Batch();
        $batch_table = $batch_dbTable->info('name');
        $cond = $class_table . '.batch_id =' . $batch_table . '.batch_id';
        $class_cols = array('class_id');
        $select = $adapter->select()->from($class_table, $class_cols);
        if (isset($department_id)) {
            $select->where('department_id = ?', $is_active);
        }
        if (isset($programme_id)) {
            $select->where('programme_id = ?', $is_active);
        }
        if (isset($programme_id)) {
            $select->where('semester_id = ?', $is_active);
        }
        if (isset($batch_id)) {
            $select->where('batch_id = ?', $batch_id);
        }
        if (isset($is_active)) {
            $select->where('is_active = ?', $is_active);
        }
        $class_ids = array();
        $class_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $class_ids;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $class_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'class_id = ' . $class_id;
        return $dbtable->update($prepared_data, $where);
    }
}
?>