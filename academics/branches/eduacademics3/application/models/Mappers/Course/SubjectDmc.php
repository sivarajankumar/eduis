<?php
class Acad_Model_Mapper_Course_SubjectDmc
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Course_SubjectDmc
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
            $this->setDbTable('Acad_Model_DbTable_SubjectDmc');
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
     * @param Acad_Model_Course_SubjectDmc $subjectDmc
     */
    public function fetchSubjectMarksHistory (Acad_Model_Course_SubjectDmc $subjectDmc)
    {
        
        $member_id = $subjectDmc->getMember_id();
        $subjCode = $subjectDmc->getSubject_code();
        $appearType = $subjectDmc->getAppear_type();
        /*Zend_Registry::get('logger')->debug($member_id);
        Zend_Registry::get('logger')->debug($subjCode);
        Zend_Registry::get('logger')->debug($appearType);*/
        if (! isset($member_id) or ! isset($subjCode)) {
            throw new Exception(
            'Insufficient data provided.. both memberId and subCode are required');
        } else {
            $requiredFields = array('dmc_id','marks','appear_type');
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('dmc_record',$requiredFields)
                ->where('member_id = ?', $member_id)
                ->where('subject_code = ?', $subjCode);
            if (isset($appearType)) {
                $select->where('appear_type = ?', $appearType);
            }
            $subjectMarksHistory = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            //Zend_Registry::get('logger')->debug($subjectMarksHistory);
            return $subjectMarksHistory;
        }
    }
    /**
     * @todo  incomplete
     * 
     * @param Acad_Model_Course_SubjectDmc $subjectDmc
     */
    public function fetchDetails (Acad_Model_Course_SubjectDmc $subjectDmc)
    {
        /**
         * call getmarks history and add following to query 
         * where marks = (marks[0] or marks[1]
         * and get all dmc ids corresponding to a appear type
         * @var unknown_type
         */
        $member_id = $subjectDmc->getMember_id();
        $subjCode = $subjectDmc->getSubject_code();
        $marks = $subjectDmc->getMarks();
        if (! isset($member_id) or ! isset($subjCode) or ! isset($marks)) {
            throw new Exception(
            'Insufficient data provided..  memberId, subCode and subjMarks are ALL required');
        } else {
            $requiredFields = array('subject_code', 'marks', 'appear_type', 
            'custody_date', 'custody_date', 'is_granted', 'grant_date', 
            'recieving_date', 'is_copied', 'dispatch_date', 'member_id');
            $adapter = $this->getDbTable()->getAdapter();
            $table_name = $this->getDbTable()->info('name');
            $select = $adapter->select()
                ->from($table_name)
                ->joinInner('dmc_record', 'dmc_info.dmc_id = dmc_record.dmc_id');
        }
    }
    /**
     * @todo join
     * @param Acad_Model_Course_SubjectDmc $subjectDmc
     */
    public function fetchPassedSemestersInfo (
    Acad_Model_Course_SubjectDmc $subjectDmc)
    {
        $member_id = $subjectDmc->getMember_id();
        $requiredFields = array('semester_id', 'dmc_id', 'marks_obtained', 
        'total_marks');
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()
            ->from('dmc_total_marks', $requiredFields)
            ->joinInner('dmc_record', 
        'dmc_total_marks.dmc_id = dmc_record.dmc_id', null);
        $semester_dmc_records = array();
        $semester_dmc_records = $select->query()->fetchAll(
        Zend_Db::FETCH_UNIQUE);
        //Zend_Registry::get('logger')->debug($semester_dmc_records);
        $subjectDmc->setSem_dmc_records($semester_dmc_records);
    }
    /**
     * @todo incomplete
     * @param Acad_Model_Course_SubjectDmc $subjectDmc
     */
    public function fetchMemberId (Acad_Model_Course_SubjectDmc $subjectDmc)
    {}
}