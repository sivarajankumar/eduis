<?php
class Tnp_Model_Mapper_StudentClass
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_StudentClass
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
            $this->setDbTable('Tnp_Model_DbTable_StudentClass');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches Experience details of a student
     * 
     * @param integer $student_experience_id
     */
    public function fetchInfo ($student_experience_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $student_experience_table = $db_table->info('name');
        $required_cols = array('student_experience_id', 'member_id', 
        'industry_id', 'functional_area_id', 'role_id', 'experience_months', 
        'experience_years', 'organisation', 'start_date', 'end_date', 
        'is_parttime', 'description');
        $select = $adapter->select()
            ->from($student_experience_table, $student_experience_id)
            ->where('student_experience_id = ?', $student_experience_id);
        $student_experience_info = array();
        $student_experience_info = $select->query()->fetchAll(
        Zend_Db::FETCH_UNIQUE);
        return $student_experience_info[$student_experience_id];
    }
    public function fetchStudentExperienceIds ($member_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $student_experience_table = $db_table->info('name');
        $required_cols = array('student_experience_id');
        $select = $adapter->select()
            ->from($student_experience_table, $required_cols)
            ->where('member_id = ?', $member_id);
        $class_ids = array();
        return $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
    }
    /**
     * 
     * @todo add more parameters with default values=null, and add where statements
     * @param bool $industry_id
     */
    public function fetchMemberIds ($industry_id = null)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $student_experience_table = $db_table->info('name');
        $required_cols = array('member_id');
        $select = $adapter->select()->from($student_experience_table, 
        $required_cols);
        if (isset($industry_id)) {
            $select->where('industry_id = ?', $industry_id);
        }
        $member_ids = array();
        return $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $student_experience_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'student_experience_id = ' . $student_experience_id;
        return $dbtable->update($prepared_data, $where);
    }
}
?>