<?php
class Core_Model_Mapper_Member_Student
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Core_Model_Mapper_Member_Student
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
            $this->setDbTable('Core_Model_DbTable_Members');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches CRITICAL information of a Student
     * 
     * @param integer $member_id
     */
    public function fetchCriticalInfo ($member_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $req_cols = array('member_id', 'member_type_id', 'first_name', 
        'last_name', 'middle_name', 'dob', 'blood_group', 'gender', 
        'religion_id', 'cast_id', 'nationality_id', 'join_date', 'relieve_date', 
        'image_no', 'is_active');
        $table_name = $this->getDbTable()->info('name');
        $select = $adapter->select()
            ->from($table_name, $req_cols)
            ->where('member_id = ?', $member_id);
        $student_info = array();
        $student_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $student_info[$member_id];
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        try {
            $member_id = $dbtable->insert($prepared_data);
            return $member_id;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}