<?php
class Core_Model_Mapper_Nationality
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Core_Model_Mapper_Nationality
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
            $this->setDbTable('Core_Model_DbTable_Nationalities');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches Nationality details
     * 
     * @param integer $nationality_id
     */
    public function fetchInfo ($nationality_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $nationality_table = $db_table->info('name');
        $required_cols = array('nationality_id', 'nationality_name');
        $select = $adapter->select()
            ->from($nationality_table, $required_cols)
            ->where('nationality_id = ?', $nationality_id);
        $nationality_info = array();
        $nationality_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $nationality_info[$nationality_id];
    }
    public function fetchNationalities ()
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $nationality_table = $db_table->info('name');
        $required_cols = array('nationality_id', 'nationality_name');
        $select = $adapter->select()->from($nationality_table, $required_cols);
        $all_nationalitys = array();
        $result = array();
        $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        foreach ($result as $nationality_id => $nationality_name_array) {
            $all_nationalitys[$nationality_id] = $nationality_name_array['nationality_name'];
        }
        return $all_nationalitys;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $nationality_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'nationality_id = ' . $nationality_id;
        return $dbtable->update($prepared_data, $where);
    }
}
?>