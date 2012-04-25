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
    public function fetchInfo ($member_id,$relation_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $relaives_table = $db_table->info('name');
        $required_cols = array('member_id', 'relation_id', 'name', 'occupation', 
        'designation', 'office_add', 'contact', 'annual_income', 'landline_no', 
        'email');
        $relations_db_table = new Core_Model_DbTable_Relations();
        $relations_table = $relations_db_table->info('name');
        $relations_cols = 'relation_name';
        $cond = $relaives_table . '.relation_id=' . $relations_table .
         '.relation_id';
        $select = $adapter->select()
            ->from($relaives_table, $required_cols)
           ->joinInner($relations_table, $cond, $relations_cols)
            ->where('member_id = ?', $member_id)
            ->where(strval($relaives_table . '.relation_id = ?'),$relation_id );
        $student_info = array();
        $student_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $student_info[$member_id];
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        try {
            $row_id = $dbtable->insert($prepared_data);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
?>