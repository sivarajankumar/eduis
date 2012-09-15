<?php
class Core_Model_Mapper_Relations
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Core_Model_Mapper_Relations
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
            $this->setDbTable('Core_Model_DbTable_Relations');
        }
        return $this->_dbTable;
    }
    public function fetchRelations ()
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $relation_table = $db_table->info('name');
        $required_cols = array('relation_id', 'relation_name');
        $select = $adapter->select()->from($relation_table, $required_cols);
        $relations = array();
        $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        if (empty($result)) {
            return false;
        } else {
            foreach ($result as $relation_id => $relation_name_array) {
                $relations[$relation_id] = $relation_name_array['relation_name'];
            }
            return $relations;
        }
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $relation_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'relation_id = ' . $relation_id;
        return $dbtable->update($prepared_data, $where);
    }
}
?>