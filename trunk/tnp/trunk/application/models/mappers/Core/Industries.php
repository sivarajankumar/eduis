<?php
class Tnp_Model_Mapper_Core_Industries
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Core_Industries
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
            $this->setDbTable('Tnp_Model_DbTable_Industries');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @param integer $industry_id
     */
    public function fetchInfo ($industry_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $industry_table = $db_table->info('name');
        $required_cols = array('industry_id', 'industry_name');
        $select = $adapter->select()
            ->from($industry_table, $required_cols)
            ->where('industry_id = ?', $industry_id);
        $industry_info = array();
        $industry_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $industry_info[$industry_id];
    }
    public function fetchIndustryIds ()
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $industry_table = $db_table->info('name');
        $required_cols = array('industry_id');
        $select = $adapter->select()->from($industry_table, $required_cols);
        $industries = array();
        $result = array();
        $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        foreach ($result as $industry_id => $industry_names) {
            $industries[$industry_id] = $industry_names['language_name'];
        }
        return $industries;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $industry_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'industry_id = ' . $industry_id;
        return $dbtable->update($prepared_data, $where);
    }
}
?>