<?php
class Tnp_Model_Mapper_Core_FunctionalArea
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Core_FunctionalArea
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
            $this->setDbTable('Tnp_Model_DbTable_FunctionalArea');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @param integer $functional_area_id
     */
    public function fetchInfo ($functional_area_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $functional_area_table = $db_table->info('name');
        $required_cols = array('functional_area_name');
        $select = $adapter->select()
            ->from($functional_area_table, $required_cols)
            ->where('functional_area_id = ?', $functional_area_id);
        $functional_area_info = array();
        $functional_area_info = $select->query()->fetchAll(
        Zend_Db::FETCH_UNIQUE);
        return $functional_area_info[$functional_area_id];
    }
    public function fetchFunctionalAreas ()
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $functional_area_table = $db_table->info('name');
        $required_cols = array('functional_area_id', 'functional_area_name');
        $select = $adapter->select()->from($functional_area_table, $required_cols);
        $functional_areas = array();
        $result = array();
        $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        foreach ($result as $functional_area_id => $functional_area_name_array) {
            $functional_areas[$functional_area_id] = $functional_area_name_array['functional_area_name'];
        }
        return $functional_areas;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $functional_area_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'functional_area_id = ' . $functional_area_id;
        return $dbtable->update($prepared_data, $where);
    }
}
?>