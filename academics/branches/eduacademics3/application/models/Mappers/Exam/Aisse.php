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
     * fetches AISSE Exam details
     * @param Acad_Model_Exam_Aisse $aissce
     *@todo make memberId as basis
     */
    public function fetchMemberExamDetails (Acad_Model_Exam_Aisse $aisse)
    {
        $member_id = $aisse->getMember_id();
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()
            ->from($this->getDbTable()
            ->info('NAME'))
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
     * returns REGISTRATION NUMBER
     * @param Acad_Model_Exam_Aisse $searchParams
     * @todo return memberIds
     */
    public function fetchMemberId (Acad_Model_Exam_Aisse $searchParams)
    {
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from(
        ($this->getDbTable()
            ->info('NAME')), 'member_id');
        $matric_board = $searchParams->getMatric_board();
        $matric_roll_no = $searchParams->getMatric_roll_no();
        $matric_marks_obtained = $searchParams->getMatric_marks_obtained();
        $matric_total_marks = $searchParams->getMatric_total_marks();
        $matric_percentage = $searchParams->getMatric_percentage();
        $matric_passing_year = $searchParams->getMatric_passing_year();
        $matric_school_rank = $searchParams->getMatric_school_rank();
        $matric_remarks = $searchParams->getMatric_remarks();
        $matric_institution = $searchParams->getMatric_institution();
        $matric_city = $searchParams->getMatric_city();
        $matric_state = $searchParams->getMatric_state();
        if (isset($matric_board)) {
            $select->where('matric_board = ?', $matric_board);
        }
        if (isset($matric_roll_no)) {
            $select->where('matric_roll_no = ?', $matric_roll_no);
        }
        if (isset($matric_marks_obtained)) {
            $select->where('matric_marks_obtained = ?', $matric_marks_obtained);
        }
        if (isset($matric_total_marks)) {
            $select->where('matric_total_marks = ?', $matric_total_marks);
        }
        if (isset($matric_percentage)) {
            $select->where('matric_percentage = ?', $matric_percentage);
        }
        if (isset($matric_passing_year)) {
            $select->where('matric_passing_year = ?', $matric_passing_year);
        }
        if (isset($matric_school_rank)) {
            $select->where('matric_school_rank = ?', $matric_school_rank);
        }
        if (isset($matric_remarks)) {
            $select->where('matric_remarks = ?', $matric_remarks);
        }
        if (isset($matric_institution)) {
            $select->where('matric_institution = ?', $matric_institution);
        }
        if (isset($matric_city)) {
            $select->where('matric_city = ?', $matric_city);
        }
        if (isset($matric_state)) {
            $select->where('matric_state = ?', $matric_state);
        }
        return $select->query()->fetchColumn();
    }
}
