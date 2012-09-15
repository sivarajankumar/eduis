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
    public function memberIdCheck ($member_id)
    {
        $member_ids = $this->getDbTable()->find($member_id);
        if (0 == count($member_ids)) {
            return false;
        } else {
            return true;
        }
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
            ->joinInner('casts', 'casts.cast_id = members.cast_id')
            ->joinInner('nationalities', 
        'nationalities.nationality_id = members.nationality_id')
            ->joinInner('religions', 
        'religions.religion_id = members.religion_id')
            ->where('member_id = ?', $member_id);
        $student_info = array();
        $student_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        if (empty($student_info)) {
            return false;
        } else {
            return $student_info[$member_id];
        }
    }
    public function fetchStudents ($exact_property = null, $property_range = null)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $stu_table = $db_table->info('name');
        $required_cols = array('member_id');
        $select = $adapter->select()->from($stu_table, $required_cols);
        if (! empty($property_range)) {
            foreach ($property_range as $key => $range) {
                if (! empty($range['from'])) {
                    $select->where("$key >= ?", $range['from']);
                }
                if (! empty($range['to'])) {
                    $select->where("$key <= ?", $range['to']);
                }
            }
        }
        if (! empty($exact_property)) {
            foreach ($exact_property as $exact_key => $exact_range) {
                $select->where("$exact_key = ?", $exact_range);
            }
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
    public function update ($prepared_data, $member_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'member_id = ' . $member_id;
        return $dbtable->update($prepared_data, $where);
    }
}