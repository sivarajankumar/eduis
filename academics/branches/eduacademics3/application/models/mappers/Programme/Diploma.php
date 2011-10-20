<?php
class Acad_Model_Mapper_Programme_Diploma
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Programme_Diploma
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
     * 
     * @todo
     */
    public function save ()
    {}
    /**
     * Fetches Diploma Details of a student
     * @param Acad_Model_Programme_Diploma $diploma
     */
    public function fetchMemberExamInfo (Acad_Model_Programme_Diploma $diploma)
    {
        $member_id = $diploma->getMember_id();
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $required_fields = array('member_id', 'discipline_name', 
        'board_roll_no', 'marks_obtained', 'total_marks', 'percentage', 
        'passing_year', 'remarks', 'university', 'institution', 'city_name', 
        'state_name', 'migration_date');
        $select = $adapter->select()
            ->from($this->getDbTable()
            ->info('name'), $required_fields)
            ->where('member_id = ?', $member_id);
        $member_exam_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $member_exam_info[$member_id];
    }
    /**
     * Fetches Discipline Information ,viz, Name in this case
     * @param Acad_Model_Programme_Diploma $diploma
     */
    /*public function fetchDisciplineInfo (Acad_Model_Programme_Diploma $diploma)
    {
        $discipline_id = $diploma->getDiscipline_id();
        if (! isset($discipline_id)) {
            $error = 'Please provide the Discipline Id';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('discipline_id', 'discipline_name'=>'name');
            $select = $adapter->select()
                ->from('discipline', $required_fields)
                ->where('discipline_id = ?', $discipline_id);
            $discipline_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $discipline_info[$discipline_id];
        }
    }*/
    /**
     * Enter description here ...
     * @param Acad_Model_Programme_Diploma $diploma
     * @param array $property_range Example :array('name'=>array('from'=>n ,'to'=>m));
     * here 'from' stands for >= AND 'to' stands for <=
     * 
     */
    public function fetchStudents (Acad_Model_Programme_Diploma $diploma, 
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
            $diploma->$getter_string();
            $condition = $property_name . ' = ?';
            $select->where($condition, $value);
        }
        return $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
    }
}
