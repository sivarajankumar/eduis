<?php
class Core_Model_Mapper_MemberRelatives
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Core_Model_Mapper_MemberRelatives
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
            $this->setDbTable('Core_Model_DbTable_MemberRelatives');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches details of Relatives of a Member
     * 
     * @param integer $member_id
     */
    public function fetchInfo ($member_id, $relation_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $relatives_table = $db_table->info('name');
        $required_cols = array('member_id', 'relation_id', 'name', 'occupation', 
        'designation', 'office_add', 'contact', 'annual_income', 'landline_no', 
        'email');
        $relations_db_table = new Core_Model_DbTable_Relations();
        $relations_table = $relations_db_table->info('name');
        $relations_cols = 'relation_name';
        $cond = $relatives_table . '.relation_id=' . $relations_table .
         '.relation_id';
        $select = $adapter->select()
            ->from($relatives_table, $required_cols)
            ->joinInner($relations_table, $cond, $relations_cols)
            ->where('member_id = ?', $member_id)
            ->where(strval($relatives_table . '.relation_id = ?'), $relation_id);
        $relative_info = array();
        $relative_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        if (empty($relative_info)) {
            return false;
        } else {
            return $relative_info[$member_id];
        }
    }
    /**
     * Fetches Relation of a Member
     * 
     * @param integer $member_id
     */
    public function fetchRelationIds ($member_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $relative_table = $db_table->info('name');
        $required_cols = array('relation_id');
        $select = $adapter->select()
            ->from($relative_table, $required_cols)
            ->where('member_id = ?', $member_id);
        $relation_ids = array();
        $relation_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $relation_ids;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $member_id, $relation_id)
    {
        $dbtable = $this->getDbTable();
        $where1 = 'member_id = ' . $member_id;
        $where2 = 'relation_id = ' . $relation_id;
        return $dbtable->update($prepared_data, array($where1, $where2));
    }
    public function fetchStudents ($exact_property, $property_range)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $relative_table = $db_table->info('name');
        $required_cols = array('member_id');
        $select = $adapter->select()->from($relative_table, $required_cols);
        foreach ($property_range as $key => $range) {
            if (! empty($range['from'])) {
                $select->where("$key >= ?", $range['from']);
            }
            if (! empty($range['to'])) {
                $select->where("$key <= ?", $range['to']);
            }
        }
        foreach ($exact_property as $exact_key => $exact_range) {
            $select->where("$exact_key = ?", $exact_range);
        }
        $member_ids = array();
        $member_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $member_ids;
    }
}
?>