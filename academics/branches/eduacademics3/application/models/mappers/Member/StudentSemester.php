<?php
class Acad_Model_Mapper_Member_StudentSemester
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Member_StudentSemester
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
            $this->setDbTable('Acad_Model_DbTable_StudentSemester');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * Enter description here ...
     * @param array $options
     * @param Acad_Model_Member_StudentSemester $student_sem
     */
    public function save ($options, 
    Acad_Model_Member_StudentSemester $student_sem = null)
    {
        $save_stu_sem = $student_sem->getSave_stu_sem();
        $save_student = $student_sem->getSave_student();
        if (isset($student_sem)) {
            $dbtable = new Acad_Model_DbTable_StudentSemester();
        }
        if (isset($save_student)) {
            $dbtable = new Acad_Model_DbTable_Student();
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
            $data[$key_name] = $student_sem->$str();
        }
        //$adapter = $this->getDbTable()->getAdapter();
        //$where = $adapter->quoteInto("$this->correctDbKeys('member_id') = ?", $student_sem->getMember_id());
        $adapter = $dbtable->getAdapter();
        $table = $dbtable->info('name');
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
     * 
     * Enter description here ...
     * @param Acad_Model_Member_StudentSemester $student_sem
     */
    public function fetchMemberID (
    Acad_Model_Member_StudentSemester $student_sem)
    {
        $roll_no = $student_sem->getRoll_no();
        $department_id = $student_sem->getDepartment_id();
        $programme_id = $student_sem->getProgramme_id();
        $semester_id = $student_sem->getSemester_id();
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
    /**
     * 
     * Enter description here ...
     * @param unknown_type $student_sem
     */
    public function fetchRollNo (Acad_Model_Member_StudentSemester $student_sem)
    {
        $member_id = $student_sem->getMember_id();
        $department_id = $student_sem->getDepartment_id();
        $programme_id = $student_sem->getProgramme_id();
        $semester_id = $student_sem->getSemester_id();
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
?>