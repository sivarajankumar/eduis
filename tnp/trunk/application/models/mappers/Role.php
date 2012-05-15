<?php
class Tnp_Model_Mapper_Role
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Role
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
            $this->setDbTable('Tnp_Model_DbTable_Roles');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @param integer $industry_id
     */
    public function fetchInfo ($role_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $role_table = $db_table->info('name');
        $required_cols = array('role_id', 'role_name');
        $select = $adapter->select()
            ->from($role_table, $required_cols)
            ->where('role_id = ?', $role_id);
        $role_info = array();
        $role_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $role_info[$role_id];
    }
    public function fetchRoles ()
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $role_table = $db_table->info('name');
        $required_cols = array('role_id', 'role_name');
        $select = $adapter->select()->from($role_table, $required_cols);
        $roles = array();
        $result = array();
        $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        foreach ($result as $role_id => $role_info_array) {
            $roles[$role_id] = $role_info_array['role_name'];
        }
        return $roles;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $role_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'role_id = ' . $role_id;
        return $dbtable->update($prepared_data, $where);
    }
    public function delete ($role_id)
    {
        $where = 'role_id = ' . $role_id;
        return $this->getDbTable()->delete($where);
    }
}
?>