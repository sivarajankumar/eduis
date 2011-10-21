<?php
class Acad_Model_Mapper_Exam_Aisse
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Exam_Aisse
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
            $this->setDbTable('Acad_Model_DbTable_Aisse');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @todo
     */
    public function save ()
    {}
    /**
     * 
     * Enter description here ...
     * @param Acad_Model_Exam_Aisse $aisse
     */
    public function fetchMemberExamInfo (Acad_Model_Exam_Aisse $aisse)
    {
        $member_id = $aisse->getMember_id();
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $required_fields = array('member_id', 'board', 'board_roll_no', 
        'marks_obtained', 'total_marks', 'percentage', 'passing_year', 
        'school_rank', 'remarks', 'institution', 'city_name', 'state_name');
        $select = $adapter->select()
            ->from('matric', $required_fields)
            ->where('member_id = ?', $member_id);
        $member_exam_info = array();
        $member_exam_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $member_exam_info[$member_id];
    }
    /**
     * Enter description here ...
     * @param Acad_Model_Exam_Aisse $aisse
     * @param array $property_range Example :array('name'=>array('from'=>n ,'to'=>m));
     * here 'from' stands for >= AND 'to' stands for <=
     * 
     */
    public function fetchStudents (Acad_Model_Exam_Aisse $aisse, 
    array $setter_options = null, array $property_range = null)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()->from(
        ($this->getDbTable()
            ->info('name')), 'member_id');
        foreach ($property_range as $key => $range) {
            if (! empty($range['from'])) {
                $select->where("$key >= ?", $range['from']);
            }
            if (! empty($range['to'])) {
                $select->where("$key <= ?", $range['to']);
            }
        }
        foreach ($setter_options as $property_name => $value) {
            $getter_string = 'get' . ucfirst($property_name);
            $aisse->$getter_string();
            $condition = $property_name . ' = ?';
            $select->where($condition, $value);
        }
        $result = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        if (! empty($result)) {
            $serach_error = 'No results match your search criteria.';
            return $serach_error;
        } else {
            return $result;
        }
    }
}
