<?php
class Core_Model_Mapper_Cast
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Core_Model_Mapper_Cast
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
            $this->setDbTable('Core_Model_DbTable_Casts');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches Cast details
     * 
     * @param integer $cast_id
     */
    public function fetchInfo ($cast_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $cast_table = $db_table->info('name');
        $required_cols = array('cast_id', 'cast_name');
        $select = $adapter->select()
            ->from($required_cols, $required_cols)
            ->where('cast_id = ?', $cast_id);
        $cast_info = array();
        $cast_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $cast_info[$cast_id];
    }
    public function fetchCasts ()
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $cast_table = $db_table->info('name');
        $required_cols = array('cast_id', 'cast_name');
        $select = $adapter->select()->from($required_cols, $required_cols);
        $all_casts = array();
        $result = array();
        $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        foreach ($result as $cast_id => $cast_name_array) {
            $all_casts[$cast_id] = $cast_name_array['cast_name'];
        }
        return $all_casts;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $cast_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'cast_id = ' . $cast_id;
        return $dbtable->update($prepared_data, $where);
    }
}
?>