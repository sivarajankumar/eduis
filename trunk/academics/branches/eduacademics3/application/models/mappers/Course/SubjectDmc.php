<?php
class Acad_Model_Mapper_Course_SubjectDmc
{
    protected $_table_cols = null;
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * @return the $_table_cols
     */
    protected function getTable_cols ()
    {
        if (! isset($this->_table_cols)) {
            $this->setTable_cols();
        }
        return $this->_table_cols;
    }
    /**
     * @param field_type $_table_cols
     */
    protected function setTable_cols ()
    {
        $this->_table_cols = $this->getDbTable()->info('cols');
    }
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
    public function fetchSubjectMarksHistory (
    Acad_Model_Course_SubjectDmc $subjectDmc)
    {
        $member_id = $subjectDmc->getMember_id();
        $subjCode = $subjectDmc->getSubject_code();
        $appearType = $subjectDmc->getAppear_type();
        if (! isset($member_id) or ! isset($subjCode)) {
            throw new Exception(
            'Insufficient data provided.. both memberId and subCode are required');
        } else {
            $requiredFields = array('marks', 'dmc_id', 'appear_type');
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('dmc_record', $requiredFields)
                ->where('member_id = ?', $member_id)
                ->where('subject_code = ?', $subjCode)
                ->order(array('marks DESC'));
            if (isset($appearType)) {
                $select->where('appear_type = ?', $appearType);
            }
            $subjectMarksHistory = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $subjectMarksHistory;
        }
    }
    public function fetchDmcId (Acad_Model_Course_SubjectDmc $subjectDmc)
    {
        $member_id = $subjectDmc->getMember_id();
        $subjCode = $subjectDmc->getSubject_code();
        $marks = $subjectDmc->getMarks();
        if (! isset($member_id) or ! isset($subjCode) or ! isset($marks)) {
            throw new Exception(
            'Insufficient data provided..  memberId, subCode and subjMarks are ALL required');
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $req_fields = array('dmc_id');
            $select = $adapter->select()
                ->from('dmc_record', $req_fields)
                ->where('member_id = ?', $member_id)
                ->where('subject_code = ?', $subjCode)
                ->where('marks = ?', $marks);
            $dmc_id_array = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $dmc_id_array[0];
        }
    }
    /**
     * @todo  incomplete
     * 
     * @param Acad_Model_Course_SubjectDmc $subjectDmc
     */
    public function fetchDmcInfo (Acad_Model_Course_SubjectDmc $subjectDmc)
    {
        $dmc_id = null;
        $dmc_id_direct = $subjectDmc->getDmc_id();
        $dmc_info_fields = $this->getTable_cols();
        if (isset($dmc_id_direct)) {
            $dmc_id = $dmc_id_direct;
        } else {
            $dmc_id_calculated = $this->fetchDmcId($subjectDmc);
            if (isset($dmc_id_calculated)) {
                $dmc_id = $dmc_id_calculated;
            }
        }
        if (isset($dmc_id)) {
            $adapter = $this->getDbTable()->getAdapter();
            $select = $adapter->select()
                ->from($this->getDbTable()
                ->info('name'), $dmc_info_fields)
                ->where('dmc_id = ?', $dmc_id);
            $dmc_info = array();
            $dmc_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $dmc_info[$dmc_id];
        }
    }
    /**
     * 
     * @param Acad_Model_Course_SubjectDmc $subjectDmc
     */
    public function fetchPassedSemestersInfo (
    Acad_Model_Course_SubjectDmc $subjectDmc)
    {
        $member_id = $subjectDmc->getMember_id();
        $requiredFields = array('semester_id', 'dmc_id', 'marks_obtained', 
        'scaled_marks', 'total_marks');
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()
            ->from('dmc_total_marks', $requiredFields)
            ->join('dmc_record', 'dmc_total_marks.dmc_id = dmc_record.dmc_id', 
        'member_id')
            ->where('member_id = ?', $member_id);
        $considered_dmc_records = array();
        $considered_dmc_records = $select->query()->fetchAll(
        Zend_Db::FETCH_UNIQUE);
        if (sizeof($considered_dmc_records) == 0) {
            throw new Exception(
            'No passed semesters record exist for ' . $subjectDmc->getMember_id());
        }
        return $considered_dmc_records;
    }
    /**
     * @todo incomplete
     * @param Acad_Model_Course_SubjectDmc $subjectDmc
     */
    public function fetchMemberId (Acad_Model_Course_SubjectDmc $subjectDmc)
    {}
    /**
     * @todo incomplete
     * @param Acad_Model_Course_SubjectDmc $subjectDmc
     */
    public function fetchMemberDmcRecords (
    Acad_Model_Course_SubjectDmc $subjectDmc)
    {
        $member_id = $subjectDmc->getMember_id();
        $department_id = $subjectDmc->getDepartment_id();
        $programme_id = $subjectDmc->getProgramme_id();
        $semester_id = $subjectDmc->getSemester_id();
        $appear_type = $subjectDmc->getAppear_type();
        if (! isset($member_id) or ! isset($department_id) or
         ! isset($programme_id) or ! isset($semester_id)) {
            throw new Exception(
            'Insufficient data provided..  memberId, department_id,programme_id and semester_id are ALL required');
        } else {
            $dmcRecordFields = array('dmc_id', 'appear_type', 
            'marks_scored_uexam' => 'marks');
            $internalMarksFields = array('subject_code', 
            'marks_scored_internal' => 'marks_scored', 
            'marks_suggested_internal' => 'marks_suggested');
            $cond = 'internal_marks.member_id = dmc_record.member_id AND internal_marks.subject_code = dmc_record.subject_code';
            $adapter = $this->getDbTable()->getAdapter();
            //$key_for_resultset = array('internal_marks.subject_code');
            //$key_for_resultset = array('dmc_record.dmc_id');
            $select = $adapter->select()
                ->from('dmc_record', $dmcRecordFields)
                ->join('internal_marks', $cond, $internalMarksFields)
                ->where('internal_marks.member_id = ?', $member_id)
                ->where('department_id = ?', $department_id)
                ->where('programme_id = ?', $programme_id)
                ->where('semester_id = ?', $semester_id);
            if (isset($appear_type)) {
                $select->where('appear_type = ?', $appear_type);
            }
            $memberDmcRecords = $select->query()->fetchAll(Zend_Db::FETCH_GROUP);
            return $memberDmcRecords;
        }
    }
    public function helper (Acad_Model_Course_SubjectDmc $subjectDmc)
    {
        $member_id = $subjectDmc->getMember_id();
        $department_id = $subjectDmc->getDepartment_id();
        $programme_id = $subjectDmc->getProgramme_id();
        $semester_id = $subjectDmc->getSemester_id();
        if (! isset($member_id) or ! isset($department_id) or
         ! isset($programme_id) or ! isset($semester_id)) {
            throw new Exception(
            'Insufficient data provided..  memberId, department_id,programme_id and semester_id are ALL required');
        } else {
            $internalMarksFields = array('subject_code', 
            'marks_scored_internal' => 'marks_scored', 
            'marks_suggested_internal' => 'marks_suggested');
            $adapter = $this->getDbTable()->getAdapter();
            $select = $adapter->select()
                ->from('internal_marks', $internalMarksFields)
                ->where('department_id = ?', $department_id)
                ->where('programme_id = ?', $programme_id)
                ->where('semester_id = ?', $semester_id)
                ->where('member_id = ?', $member_id);
            $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $result;
        }
    }
}
