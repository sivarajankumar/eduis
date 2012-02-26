<?php
class Acad_Model_Mapper_Programme_Subject
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Programme_Subject
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
            $this->setDbTable('Acad_Model_DbTable_Subject');
        }
        return $this->_dbTable;
    }
    /**
     * @todo correct names of classes tables and params
     * Enter description here ...
     * @param array $options
     * @param Acad_Model_Programme_Subject $subject
     */
    public function save ($options, Acad_Model_Programme_Subject $subject = null)
    {
        /*$adapter = $dbtable->getAdapter();
        $table = $dbtable->info('name');
        $adapter->beginTransaction();
        try {
            $sql = $adapter->insert($table, $data);
            $adapter->commit();
        } catch (Exception $exception) {
            $adapter->rollBack();
            throw $exception;
        }*/
    }
    /**
     * 
     * ONLY ONE PARAM MUST BE SET AT A TIME
     * @param Acad_Model_Programme_Subject $subject
     * @param boolean $deptt_flag
     * @param boolean $programme_flag
     * @param boolean $sem_flag
     * @param boolean $students_flag
     * @throws Exception
     */
    public function fetchAssociations (Acad_Model_Programme_Subject $subject, 
    $deptt_flag = false, $programme_flag = false, $sem_flag = false, $students_flag = false)
    {
        $subject_code = $subject->getSubject_code(); // neccessary condition
        if (empty($subject_code) or ($subject_code == null)) {
            throw new Exception(
            'Insufficient data provided..  Please provide a Subject_code');
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $select = $adapter->select();
            if ($deptt_flag === true) {
                $required_field = 'department_id';
                $select->from('subject_department', $required_field)->where(
                'subject_code = ?', $subject_code);
            }
            if ($programme_flag === true) {
                $department_id = $subject->getDepartment_id();
                $required_field = 'programme_id';
                $select->from('subject_department', $required_field)
                    ->where('subject_code = ?', $subject_code)
                    ->where('department_id = ?', $department_id);
            }
            if ($sem_flag === true) {
                $department_id = $subject->getDepartment_id();
                $programme_id = $subject->getProgramme_id();
                $required_field = 'semester_id';
                $select->from('subject_department', $required_field)
                    ->where('subject_code = ?', $subject_code)
                    ->where('department_id = ?', $department_id)
                    ->where('programme_id = ?', $programme_id);
            }
            if ($students_flag === true) {
                $department_id = $subject->getDepartment_id();
                $programme_id = $subject->getProgramme_id();
                $semester_id = $subject->getSemester_id();
                $required_field = 'member_id';
                $select->from('subject_department', $required_field)
                    ->where('subject_code = ?', $subject_code)
                    ->where('department_id = ?', $department_id)
                    ->where('programme_id = ?', $programme_id)
                    ->where('semester_id = ?', $semester_id);
            }
            $result = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
            if (sizeof($result) == 0) {
                throw new Exception(
                'NO SUBJECTS HAVE BEEN REGISTERED FOR ' . $department_id . ', ' .
                 $programme_id . ', ' . 'SEMESTER ' . $semester_id . '.');
            } else {
                return $result;
            }
        }
    }
    /**
     * 
     * Enter description here ...
     * @param Acad_Model_Programme_Subject $subject
     */
    public function fetchSemesterSubjects (Acad_Model_Programme_Subject $subject)
    {
        $department_id = $subject->getDepartment_id();
        $programme_id = $subject->getProgramme_id();
        $semester_id = $subject->getSemester_id();
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()
            ->from('subject_department', 'subject_code')
            ->where('department_id = ?', $department_id)
            ->where('programme_id = ?', $programme_id)
            ->where('semester_id = ?', $semester_id);
        $result = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        if (sizeof($result) == 0) {
            throw new Exception(
            'NO SUBJECTS HAVE BEEN REGISTERED FOR ' . $department_id . ', ' .
             $programme_id . ', ' . 'SEMESTER ' . $semester_id . '.');
        } else {
            return $result;
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
?>