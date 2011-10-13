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
        $required_fields = array('member_id', 'discipline_id', 'board_roll_no', 
        'marks_obtained', 'total_marks', 'percentage', 'passing_year', 'remarks', 
        'university', 'institution', 'city_id', 'state_id', 'migration_date');
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
    public function fetchDisciplineInfo (Acad_Model_Programme_Diploma $diploma)
    {
        $discipline_id = $diploma->getDiscipline_id();
        if (! isset($discipline_id)) {
            $error = 'Please provide the Discipline Id';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('discipline_id', 'name as discipline_name');
            $select = $adapter->select()
                ->from('discipline', $required_fields)
                ->where('discipline_id = ?', $discipline_id);
            $discipline_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $discipline_info[$discipline_id];
        }
    }
    /**
     * 
     * @param Acad_Model_Programme_Diploma $searchParams
     * @todo return memberIds
     */
    public function fetchMemberId (Acad_Model_Programme_Diploma $searchParams)
    {
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from('diploma', 'member_id');
        $board_roll = $searchParams->getBoard_roll();
        $marks_obtained = $searchParams->getMarks_obtained();
        $percentage = $searchParams->getPercentage();
        $total_marks = $searchParams->getTotal_marks();
        $remarks = $searchParams->getRemarks();
        $passing_year = $searchParams->getPassing_year();
        $branch = $searchParams->getBranch();
        $board = $searchParams->getBoard();
        $institution = $searchParams->getInstitution();
        $institution_city = $searchParams->getInstitution_city();
        $migration_date = $searchParams->getMigration_date();
        $institution_state = $searchParams->getInstitution_state();
        if (isset($board_roll)) {
            $select->where('board_roll = ?', $board_roll);
        }
        if (isset($marks_obtained)) {
            $select->where('marks_obtained = ?', $marks_obtained);
        }
        if (isset($total_marks)) {
            $select->where('total_marks = ?', $total_marks);
        }
        if (isset($percentage)) {
            $select->where('percentage = ?', $percentage);
        }
        if (isset($remarks)) {
            $select->where('remarks = ?', $remarks);
        }
        if (isset($passing_year)) {
            $select->where('passing_year = ?', $passing_year);
        }
        if (isset($branch)) {
            $select->where('branch = ?', $branch);
        }
        if (isset($board)) {
            $select->where('board = ?', $board);
        }
        if (isset($institution)) {
            $select->where('institution = ?', $institution);
        }
        if (isset($institution_city)) {
            $select->where('institution_city = ?', $institution_city);
        }
        if (isset($institution_state)) {
            $select->where('institution_state = ?', $institution_state);
        }
        if (isset($migration_date)) {
            $select->where('migration_date = ?', $migration_date);
        }
        return $select->query()->fetchColumn();
    }
}
