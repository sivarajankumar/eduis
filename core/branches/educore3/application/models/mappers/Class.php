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
?>