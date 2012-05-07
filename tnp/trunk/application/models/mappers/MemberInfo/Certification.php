<?php
class Tnp_Model_Mapper_MemberInfo_Certification
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_MemberInfo_Certification
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
            $this->setDbTable('Tnp_Model_DbTable_StudentCertification');
        }
        return $this->_dbTable;
    }
    public function fetchInfo ($member_id, $certification_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $certification_table = $db_table->info('name');
        $required_cols = array('member_id', 'certification_id', 'start_date', 
        'complete_date');
        $select = $adapter->select()
            ->from($certification_table, $required_cols)
            ->where('member_id = ?', $member_id)
            ->where('certification_id = ?', $certification_id);
        $certification_info = array();
        $certification_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $certification_info[$member_id];
    }
    public function fetchCertificationIds ($member_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $certification_table = $db_table->info('name');
        $required_cols = array('certification_id');
        $select = $adapter->select()
            ->from($certification_table, $required_cols)
            ->where('member_id = ?', $member_id);
        $member_ids = array();
        $member_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $member_ids;
    }
    public function fetchMemberIds ($certification_id = null, $start_date = null, 
    $complete_date = null)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $certification_table = $db_table->info('name');
        $required_cols = array('member_id');
        $select = $adapter->select()->from($certification_table, $required_cols);
        if (! empty($certification_id)) {
            $select->where('certification_id = ?', $certification_id);
        }
        if (! empty($start_date)) {
            $select->where('start_date = ?', $start_date);
        }
        if (! empty($complete_date)) {
            $select->where('complete_date = ?', $complete_date);
        }
        $member_ids = array();
        $member_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $member_ids;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $member_id, $certification_id)
    {
        $dbtable = $this->getDbTable();
        $where1 = 'member_id = ' . $member_id;
        $where2 = 'certification_id = ' . $certification_id;
        return $dbtable->update($prepared_data, array($where1, $where2));
    }
}