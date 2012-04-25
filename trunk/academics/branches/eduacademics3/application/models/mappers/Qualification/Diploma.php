<?php
class Acad_Model_Mapper_Qualification_Diploma
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Qualification_Diploma
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
            $this->setDbTable('Acad_Model_DbTable_Diploma');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches Diploma details of a member
     * 
     * @param integer $member_id
     */
    public function fetchInfo ($member_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $diploma_table = $db_table->info('name');
        $required_cols = array('member_id', 'qualification_id', 'discipline_id', 
        'board_roll_no', 'marks_obtained', 'total_marks', 
        'percentage', 'passing_year', 'remarks', 'university', 'institution', 
        'migration_date', 'city_name', 'state_name');
        $select = $adapter->select()
            ->from($diploma_table, $required_cols)
            ->where('member_id = ?', $member_id);
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