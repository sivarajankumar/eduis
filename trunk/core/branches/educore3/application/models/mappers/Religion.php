<?php
class Core_Model_Mapper_Religion
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Core_Model_Mapper_Religion
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
            $this->setDbTable('Core_Model_DbTable_Religions');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches Religion details
     * 
     * @param integer $religion_id
     */
    public function fetchInfo ($religion_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $religion_table = $db_table->info('name');
        $required_cols = array('religion_id', 'religion_name');
        $select = $adapter->select()
            ->from($religion_table, $required_cols)
            ->where('religion_id = ?', $religion_id);
        $religion_info = array();
        $religion_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        if (empty($religion_info)) {
            return false;
        } else {
            return $religion_info[$religion_id];
        }
    }
    public function fetchReligions ()
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $religion_table = $db_table->info('name');
        $required_cols = array('religion_id', 'religion_name');
        $select = $adapter->select()->from($religion_table, $required_cols);
        $all_religions = array();
        $result = array();
        $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        foreach ($result as $religion_id => $religion_name_array) {
            $all_religions[$religion_id] = $religion_name_array['religion_name'];
        }
        return $all_religions;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $religion_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'religion_id = ' . $religion_id;
        return $dbtable->update($prepared_data, $where);
    }
}
?>