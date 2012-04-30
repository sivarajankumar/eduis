<?php
class Acad_Model_Mapper_StudentSubject
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_StudentSubject
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
            $this->setDbTable('Acad_Model_DbTable_StudentSubject');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches Subject Studied by a Student in the given Class
     * 
     * @param integer $member_id
     */
    public function fetchSubjects ($member_id, $class_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $stu_subject_table = $db_table->info('name');
        $required_cols = array('student_subject_id', 'subject_id');
        $select = $adapter->select()
            ->from($stu_subject_table, $required_cols)
            ->where('member_id = ?', $member_id)
            ->where('class_id = ?', $class_id);
        $student_subjects = array();
        $student_subjects = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $student_info;
    }
    public function fetchStudentSubjectId ($member_id, $class_id, $subject_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $stu_subject_table = $db_table->info('name');
        $required_cols = array('member_id', 'student_subject_id');
        $select = $adapter->select()
            ->from($stu_subject_table, $required_cols)
            ->where('member_id = ?', $member_id)
            ->where('class_id = ?', $class_id)
            ->where('subject_id = ?', $subject_id);
        $stu_subject_id = array();
        $stu_subject_id = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $stu_subject_id[$member_id];
    }
    /**
     * Fetches Class in which a student Studied the given Subject
     * 
     * @param  $subject_id
     */
    public function fetchClassIds ($member_id, $subject_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $stu_subject_table = $db_table->info('name');
        $required_cols = array('class_id');
        $select = $adapter->select()
            ->from($stu_subject_table, $required_cols)
            ->where('member_id = ?', $member_id)
            ->where('subject_id = ?', $subject_id);
        $class_ids = array();
        return $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
    }
    /**
     * Fetches Marks scored by the student in the given Subject
     * A student may have studied a Subject more than Once but in Different classes. Ex - Detained Student,
     * therefore subject_id and class_id are required.
     * @param  $subject_id
     */
    public function fetchDMC ($member_id, $class_id, $subject_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $stu_subject_table = $db_table->info('name');
        $required_cols = array('class_id');
        $select = $adapter->select()
            ->from($stu_subject_table, $required_cols)
            ->where('member_id = ?', $member_id)
            ->where('subject_id = ?', $subject_id)
            ->where('class_id = ?', $class_id);
        $class_ids = array();
        return $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
    }
    public function fetchResultTypes ()
    {
        $db_table = new Acad_Model_DbTable_ResultType();
        $adapter = $db_table->getAdapter();
        $result_type_table = $db_table->info('name');
        $required_cols = array('result_type_id', 'result_type_name');
        $select = $adapter->select()->from($result_type_table, $required_cols);
        $result_types = array();
        return $select->query()->fetchAll();
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        try {
            $row_id = $dbtable->insert($prepared_data);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
?>