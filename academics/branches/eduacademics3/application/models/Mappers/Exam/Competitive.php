<?php
class Acad_Model_Mapper_Exam_Competitive
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Exam_Competitive
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
            $this->setDbTable('Acad_Model_Exam_Competitive');
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
     * fetches Competitive Exam details
     *@todo make memberId as basis
     *@param Acad_Model_Exam_Competitive $competitiveExam
     */
    public function fetchMemberExamDetails (
    Acad_Model_Exam_Competitive $competitiveExam)
    {
        $member_id = $competitiveExam->getMember_id();
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()
            ->from('competitive_exam')
            ->joinInner('competitive_exam', 
        'student_competitive_exam.competitive_exam_id = competitive_exam.competitive_exam_id', 
        array('competitive_exam_name', 'competitive_exam_abbr', 
        'competitive_exam_id', 'member_id', 'exam_roll_no', 'exam_date', 
        'total_score', 'all_india_rank'))
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
     * @param Acad_Model_Exam_Competitive $searchParams
     * @todo return memberIds
     */
    public function fetchMemberId (Acad_Model_Exam_Competitive $searchParams)
    {
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from('competitive_exam', 'member_id');
        $competitive_exam_name = $searchParams->getCompetitive_exam_name();
        $competitive_exam_abbr = $searchParams->getCompetitive_exam_abbr();
        if (isset($competitive_exam_name) or isset($competitive_exam_abbr)) {
            $logger = Zend_Registry::get('logger');
            $logger->debug(
            'Can not use Competitive_exam_name or Competitive_exam_abbr.Please use Competitive_exam_id');
        }
        $competitive_exam_id = $searchParams->getCompetitive_exam_id();
        $exam_roll_no = $searchParams->getExam_roll_no();
        $exam_date = $searchParams->getExam_date();
        $total_score = $searchParams->getTotal_score();
        $all_india_rank = $searchParams->getAll_india_rank();
        if (isset($competitive_exam_id)) {
            $select->where('competitive_exam_id = ?', $competitive_exam_id);
        }
        if (isset($exam_roll_no)) {
            $select->where('exam_roll_no = ?', $exam_roll_no);
        }
        if (isset($exam_date)) {
            $select->where('exam_date = ?', $exam_date);
        }
        if (isset($total_score)) {
            $select->where('total_score = ?', $total_score);
        }
        if (isset($all_india_rank)) {
            $select->where('all_india_rank = ?', $all_india_rank);
        }
        return $select->query()->fetchColumn();
    }
}