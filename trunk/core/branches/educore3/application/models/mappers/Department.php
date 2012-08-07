<?php
class Core_Model_Mapper_Department
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Core_Model_Mapper_Department
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
            $this->setDbTable('Core_Model_DbTable_Department');
        }
        return $this->_dbTable;
    }
    public function fetchDepartments ()
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $dep_table = $db_table->info('name');
        $required_cols = array('department_id', 'department_name');
        $select = $adapter->select()->from($dep_table, $required_cols);
        $departments = array();
        $departments = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        foreach ($departments as $dep_id => $dep_name_array) {
            $all_deps[$dep_id] = $dep_name_array['department_name'];
        }
        return $all_deps;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $dep_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'department_id = ' . $dep_id;
        return $dbtable->update($prepared_data, $where);
    }
}