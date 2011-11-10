<?php
class Acad_Model_Mapper_Course_Dmc
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
     * @return Acad_Model_Mapper_Course_Dmc
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
            $this->setDbTable('Acad_Model_DbTable_DmcInfo');
        }
        return $this->_dbTable;
    }
    public function fetchStudentSubjectsInfo (Acad_Model_Course_Dmc $dmc)
    {
        $member_id = $dmc->getMember_id();
        $department_id = $dmc->getDepartment_id();
        $programme_id = $dmc->getProgramme_id();
        $semester_id = $dmc->getSemester_id();
        if (! isset($member_id) or ! isset($department_id) or
         ! isset($programme_id) or ! isset($semester_id)) {
            throw new Exception(
            'Insufficient data provided..   member_id,department_id,programme_id and semester_id are ALL required');
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $select = $adapter->select()
                ->from('student_subject', 
            array('subject_code', 'stu_sub_id'))
                ->where('department_id = ?', $department_id)
                ->where('programme_id = ?', $programme_id)
                ->where('semester_id = ?', $semester_id)
                ->where('member_id = ?', $member_id);
            $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
           // Zend_Registry::get('logger')->debug($result);
            return $result;
        }
    }
    public function fetchDmcInfoIds (Acad_Model_Course_Dmc $dmc)
    {
        $member_id = $dmc->getMember_id();
        $adapter = $this->getDbTable()->getAdapter();
        $table = $this->getDbTable()->info('name');
        $select = $adapter->select()
            ->from($table, 'dmc_info_id')
            ->where('member_id = ?', $member_id);
        $result = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $result;
    }
    public function fetchStuSubId (Acad_Model_Course_Dmc $dmc)
    {
        $member_id = $dmc->getMember_id();
        $department_id = $dmc->getDepartment_id();
        $programme_id = $dmc->getProgramme_id();
        $semester_id = $dmc->getSemester_id();
        $subject_code = $dmc->getSubject_code();
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()
            ->from('student_subject', 'stu_sub_id')
            ->where('member_id = ?', $subject_code);
        $result = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $result;
    }
    /**
     * @todo reg no
     * Enter description here ...
     * @param unknown_type $dmc
     */
    public function fetchMemberID (Acad_Model_Course_Dmc $dmc)
    {
        $roll_no = $dmc->getRoll_no();
        $department_id = $dmc->getDepartment_id();
        $programme_id = $dmc->getProgramme_id();
        $semester_id = $dmc->getSemester_id();
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()
            ->from('student_semester', 'member_id')
            ->where('department_id = ?', $department_id)
            ->where('programme_id = ?', $programme_id)
            ->where('semester_id = ?', $semester_id)
            ->where('roll_no = ?', $roll_no);
        $result = $select->query()->fetchAll(Zend_Db::FETCH_NAMED);
        return $result[0];
    }
    public function fetchRollNo (Acad_Model_Course_Dmc $dmc)
    {
        $member_id = $dmc->getMember_id();
        $department_id = $dmc->getDepartment_id();
        $programme_id = $dmc->getProgramme_id();
        $semester_id = $dmc->getSemester_id();
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()
            ->from('student_semester', 'roll_no')
            ->where('department_id = ?', $department_id)
            ->where('programme_id = ?', $programme_id)
            ->where('semester_id = ?', $semester_id)
            ->where('member_id = ?', $member_id);
        $result = $select->query()->fetchAll(Zend_Db::FETCH_NAMED);
        return $result[0];
    }
    /**
     * 
     * Enter description here ...
     * @param array $options
     * @param Acad_Model_Course_Dmc $dmc
     */
    public function save ($options, Acad_Model_Course_Dmc $dmc)
    {
        $dmcInfo = $dmc->getSave_info();
        $dmcData = $dmc->getSave_data();
        $dmcTotalMarks = $dmc->getSave_total_marks();
        if (isset($dmcInfo)) {
            $dbtable = new Acad_Model_DbTable_DmcInfo();
        }
        if (isset($dmcData)) {
            $dbtable = new Acad_Model_DbTable_DmcData();
        }
        if (isset($dmcTotalMarks)) {
            $dbtable = new Acad_Model_DbTable_DmcTotalMarks();
        }
        $cols = $dbtable->info('cols');
        //$db_options is $options with keys renamed a/q to db_columns
        $db_options = array();
        foreach ($options as $key => $value) {
            $db_options[$this->correctDbKeys($key)] = $value;
        }
        $db_options_keys = array_keys($db_options);
        $recieved_keys = array_intersect($db_options_keys, $cols);
        $data = array();
        foreach ($recieved_keys as $key_name) {
            $str = "get" . ucfirst($this->correctModelKeys($key_name));
            $data[$key_name] = $dmc->$str();
        }
        //$adapter = $this->getDbTable()->getAdapter();
        //$where = $adapter->quoteInto("$this->correctDbKeys('member_id') = ?", $student->getMember_id());
        $adapter = $this->getDbTable()->getAdapter();
        $table = $this->getDbTable()->info('name');
        $adapter->beginTransaction();
        try {
            $sql = $adapter->insert($table, $data);
            $adapter->commit();
        } catch (Exception $exception) {
            $adapter->rollBack();
            throw $exception;
        }
    }
    /**
     * Provides correct db column names corresponding to model properties
     * @todo add correct names where required
     * @param string $key
     */
    protected function correctDbKeys ($key)
    {
        switch ($key) {
            /*case 'nationalit':
                return 'nationality';
                break;*/
            default:
                return $key;
                break;
        }
    }
    /**
     * Provides correct model property names corresponding to db column names
     * @todo add correct names where required
     * @param string $key
     */
    protected function correctModelKeys ($key)
    {
        switch ($key) {
            /*case 'nationality':
                return 'nationalit';
                break;*/
            default:
                return $key;
                break;
        }
    }
}