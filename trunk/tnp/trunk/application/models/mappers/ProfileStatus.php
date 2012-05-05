<?php
class Tnp_Model_Mapper_ProfileStatus
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_ProfileStatus
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
            $this->setDbTable('Tnp_Model_DbTable_ProfileStatus');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @param integer $member_id
     */
    public function fetchInfo ($member_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $profile_status_table = $db_table->info('name');
        $required_cols = array('member_id', 'exists', 'is_locked', 
        'last_updated_on');
        $select = $adapter->select()
            ->from($profile_status_table, $required_cols)
            ->where('member_id = ?', $member_id);
        $member_profile_info = array();
        $member_profile_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $member_profile_info[$member_id];
    }
    public function fetchMemberIds ($exists = null, $is_locked = null, 
    $last_updated_on = null)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $profile_status_table = $db_table->info('name');
        $required_cols = array('member_id');
        $select = $adapter->select()->from($profile_status_table, 
        $required_cols);
        if (! empty($exists)) {
            $select->where('exists = ?', $exists);
        }
        if (! empty($is_locked)) {
            $select->where('is_locked = ?', $is_locked);
        }
        if (! empty($$last_updated_on)) {
            $select->where('last_updated_on = ?', $last_updated_on);
        }
        $member_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $member_ids;
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
?>