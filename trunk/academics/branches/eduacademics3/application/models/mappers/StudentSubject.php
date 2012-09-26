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
     * @param int $member_id
     * @param int $class_id

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
        foreach ($student_subjects as $stu_sub_id => $sub_id) {
            $subjects[$stu_sub_id] = $sub_id['subject_id'];
        }
        return $subjects;
    }
    /**
     * 
     * Enter description here ...
     * @param int $member_id
     * @param int $class_id
     * @param int $subject_id
     */
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
        if (empty($stu_subject_id)) {
            return false;
        } else {
            return $stu_subject_id[$member_id];
        }
    }
    /**
     * Fetches Class in which a student Studied the given Subject
     * @param int $member_id
     * @param int $subject_id
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
     * 
     * Enter description here ...
     * @param array $prepared_data
     */
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    /**
     * 
     * Enter description here ...
     * @param array $prepared_data
     * @param int $member_id
     * @param int $class_id
     * @param int $subject_id
     */
    public function update ($prepared_data, $member_id = null, $class_id = null, 
    $subject_id = null)
    {
        $dbtable = $this->getDbTable();
        if (! empty($member_id)) {
            $where1 = 'member_id = ' . $member_id;
        }
        if (! empty($class_id)) {
            $where2 = 'class_id =' . $class_id;
        }
        if (! empty($subject_id)) {
            $where3 = 'subject_id = ' . $subject_id;
        }
        return $dbtable->update($prepared_data, 
        array($where1, $where2, $where3));
    }
}
?>