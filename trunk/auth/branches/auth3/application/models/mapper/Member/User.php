<?php
class Auth_Model_Mapper_Member_User
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Auth_Model_Mapper_Member_User
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
            $this->setDbTable('Auth_Model_DbTable_AuthUser');
        }
        return $this->_dbTable;
    }
    public function fetchAuthUserInfo ($member_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $req_cols = array('member_id', 'login_id', 'sec_passwd', 'user_salt', 
        'user_type_id', 'department_id', 'valid_from', 'valid_upto', 'is_active', 
        'remarks');
        $table_name = $this->getDbTable()->info('name');
        $select = $adapter->select()
            ->from($table_name, $req_cols)
            ->where('member_id = ?', $member_id);
        $auth_info = array();
        $auth_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $auth_info[$member_id];
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $member_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'member_id = ' . $member_id;
        return $dbtable->update($prepared_data, $where);
    }
}