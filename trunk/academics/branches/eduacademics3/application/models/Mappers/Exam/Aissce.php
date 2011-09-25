<?php
class Acad_Model_Mapper_Exam_Aissce
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Exam_Aissce
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
            $this->setDbTable('Acad_Model_DbTable_Aissce');
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
     * fetches AISSCE Exam details
     * @param Acad_Model_Exam_Aissce $aissce
     *@todo make memberId as basis
     */
    public function fetchMemberExamDetails (Acad_Model_Exam_Aissce $aissce)
    {
        $member_id = $aissce->getMember_id();
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()
            ->from('twelfth')
            ->where('member_id = ?', $member_id);
        $fetchall = $adapter->fetchAll($select);
        $result = array();
        foreach ($fetchall as $row) {
            foreach ($row as $columnName => $columnValue) {
                $result[$columnName] = $columnValue;
            }
        }
        return $result;
    }
    /**
     * returns member_id
     * @param Acad_Model_Exam_Aissce $searchParams
     * @todo return memberIds
     */
    public function fetchMemberId (Acad_Model_Exam_Aissce $searchParams)
    {
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from('twelfth', 'member_id');
        $board_roll = $searchParams->getBoard_roll();
        $marks_obtained = $searchParams->getMarks_obtained();
        $total_marks = $searchParams->getTotal_marks();
        $percentage = $searchParams->getPercentage();
        $pcm_percent = $searchParams->getPcm_percent();
        $passing_year = $searchParams->getPassing_year();
        $board = $searchParams->getBoard();
        $school_rank = $searchParams->getSchool_rank();
        $remarks = $searchParams->getRemarks();
        $institution = $searchParams->getInstitution();
        $institution_city = $searchParams->getInstitution_city();
        $institution_state = $searchParams->getInstitution_state();
        $migration_date = $searchParams->getMigration_date();
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
        if (isset($pcm_percent)) {
            $select->where('pcm_percent = ?', $pcm_percent);
        }
        if (isset($passing_year)) {
            $select->where('passing_year = ?', $passing_year);
        }
        if (isset($board)) {
            $select->where('board = ?', $board);
        }
        if (isset($school_rank)) {
            $select->where('school_rank = ?', $school_rank);
        }
        if (isset($remarks)) {
            $select->where('remarks = ?', $remarks);
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
