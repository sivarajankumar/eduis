<?php
class Acad_Model_Mapper_Qualification
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Qualification
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
            $this->setDbTable('Acad_Model_DbTable_Qualification');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches Qualification details
     * 
     * @param integer $batch_id
     */
    public function fetchInfo ($qualification_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $qualification_table = $db_table->info('name');
        $required_cols = array('qualification_id', 'qualification_name');
        $select = $adapter->select()
            ->from($qualification_table, $required_cols)
            ->where('qualification_id = ?', $qualification_id);
        $qualification_info = array();
        $qualification_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $qualification_info[$qualification_id];
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