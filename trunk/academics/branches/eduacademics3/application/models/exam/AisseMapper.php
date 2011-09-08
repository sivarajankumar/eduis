<?php
class Acad_Model_Exam_AisseMapper
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
     * fetches AISSE Exam details
     * @param Acad_Model_Exam_Aisse $aissce
     *@todo make memberId as basis
     */
    public function fetchMemberExamDetails (Acad_Model_Exam_Aisse $aisse)
    {
    	$u_regn_no = $aisse->getU_regn_no();
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
     * @param Acad_Model_Exam_Aisse $searchParams
     * @todo return memberIds
     */
    public function fetchMemberId (Acad_Model_Exam_Aisse $searchParams)
    {
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from(
        ($this->getDbTable()
            ->info('NAME')), 'u_regn_no');
        if (isset($searchParams->getMatric_board())) {
            $select->where('matric_board = ?', $searchParams->getMatric_board());
        }
        if (isset($searchParams->getMatric_roll_no())) {
            $select->where('matric_roll_no = ?', 
            $searchParams->getMatric_roll_no());
        }
        if (isset($searchParams->getMatric_marks_obtained())) {
            $select->where('matric_marks_obtained = ?', 
            $searchParams->getMatric_marks_obtained());
        }
        if (isset($searchParams->getMatric_total_marks())) {
            $select->where('matric_total_marks = ?', 
            $searchParams->getMatric_total_marks());
        }
        if (isset($searchParams->getMatric_percentage())) {
            $select->where('matric_percentage = ?', 
            $searchParams->getMatric_percentage());
        }
        if (isset($searchParams->getMatric_passing_year())) {
            $select->where('matric_passing_year = ?', 
            $searchParams->getMatric_passing_year());
        }
        if (isset($searchParams->getMatric_school_rank())) {
            $select->where('matric_school_rank = ?', 
            $searchParams->getMatric_school_rank());
        }
        if (isset($searchParams->getMatric_remarks())) {
            $select->where('matric_remarks = ?', 
            $searchParams->getMatric_remarks());
        }
        if (isset($searchParams->getMatric_institution())) {
            $select->where('matric_institution = ?', 
            $searchParams->getMatric_institution());
        }
        if (isset($searchParams->getMatric_city())) {
            $select->where('matric_city = ?', $searchParams->getMatric_city());
        }
        if (isset($searchParams->getMatric_state())) {
            $select->where('matric_state = ?', $searchParams->getMatric_state());
        }
        return $select->query()->fetchColumn();
    }
}
