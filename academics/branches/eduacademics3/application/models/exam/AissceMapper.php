<?php
class Acad_Model_Exam_AissceMapper
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Exam_AissceMapper
     */
    public function setDbTable (Zend_Db_Table_Abstract $dbTable)
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
            $this->setDbTable('Acad_Model_DbTable_Address');
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
        $u_regn_no = $aissce->getU_regn_no();
    	$adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()
            ->from($this->getDbTable()
            ->info('NAME'))
            ->where('u_regn_no = ?', $u_regn_no);
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
     * @param Acad_Model_Exam_Aissce $searchParams
     * @todo return memberIds
     */
    public function fetchMemberId (Acad_Model_Exam_Aissce $searchParams)
    {
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from(
        ($this->getDbTable()
            ->info('NAME')), 'u_regn_no');
        if (isset($searchParams->getBoard_roll())) {
            $select->where('board_roll = ?', $searchParams->getBoard_roll());
        }
        if (isset($searchParams->getMarks_obtained())) {
            $select->where('marks_obtained = ?', 
            $searchParams->getMarks_obtained());
        }
        if (isset($searchParams->getTotal_marks())) {
            $select->where('total_marks = ?', $searchParams->getTotal_marks());
        }
        if (isset($searchParams->getPercentage())) {
            $select->where('percentage = ?', $searchParams->getPercentage());
        }
        if (isset($searchParams->getPcm_percent())) {
            $select->where('pcm_percent = ?', $searchParams->getPcm_percent());
        }
        if (isset($searchParams->getPassing_year())) {
            $select->where('passing_year = ?', $searchParams->getPassing_year());
        }
        if (isset($searchParams->getBoard())) {
            $select->where('board = ?', $searchParams->getBoard());
        }
        if (isset($searchParams->getSchool_rank())) {
            $select->where('school_rank = ?', $searchParams->getSchool_rank());
        }
        if (isset($searchParams->getRemarks())) {
            $select->where('remarks = ?', $searchParams->getRemarks());
        }
        if (isset($searchParams->getInstitution())) {
            $select->where('institution = ?', $searchParams->getInstitution());
        }
        if (isset($searchParams->getInstitution_city())) {
            $select->where('institution_city = ?', 
            $searchParams->getInstitution_city());
        }
        if (isset($searchParams->getInstitution_state())) {
            $select->where('institution_state = ?', 
            $searchParams->getInstitution_state());
        }
        if (isset($searchParams->getMigration_date())) {
            $select->where('migration_date = ?', 
            $searchParams->getMigration_date());
        }
        return $select->query()->fetchColumn();
    }
}
