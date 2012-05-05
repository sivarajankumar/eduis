<?php
class Tnp_Model_Mapper_Language
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Language
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
            $this->setDbTable('Tnp_Model_DbTable_Languages');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @param integer $language_id
     */
    public function fetchInfo ($language_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $language_table = $db_table->info('name');
        $required_cols = array('language_name');
        $select = $adapter->select()
            ->from($language_table, $required_cols)
            ->where('language_id = ?', $language_id);
        $language_info = array();
        $language_info = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        //in model return 1st index
        return $language_info;
    }
    public function fetchAll ()
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $language_table = $db_table->info('name');
        $required_cols = array('language_id', 'language_name');
        $select = $adapter->select()->from($language_table, $required_cols);
        $languages = array();
        $result = array();
        $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        foreach ($result as $language_id => $language_name_array) {
            $languages[$language_id] = $language_name_array['language_name'];
        }
        return $languages;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $language_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'language_id = ' . $language_id;
        return $dbtable->update($prepared_data, $where);
    }
}
?>