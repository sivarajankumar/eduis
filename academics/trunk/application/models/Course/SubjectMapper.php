<?php
/**
 * Subject Mapper
 *
 * Data Mapper pattern to persist data.
 * 
 */
class Acad_Model_Course_SubjectMapper
{
    /**
     * @var Acad_Model_DbTable_Subject
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Acad_Model_DbTable_Subject $dbTable 
     * @return Acad_Model_Course_SubjectMapper
     */
    public function setDbTable ($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (! $dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Zend_Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    /**
     * Get registered Zend_Db_Table instance
     *
     * Lazy loads Acad_Model_DbTable_Subject if no instance registered
     * 
     * @return Acad_Model_DbTable_Subject
     */
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Acad_Model_DbTable_Subject');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches only those modes which are in subject_faculty
     * 
     * @param Acad_Model_Course_Subject $subject
     */
    public function getSubjectModes (Acad_Model_Course_Subject $subject)
    {
        $sql = $this->getDbTable()
            ->select()
            ->from('`subject_faculty`', '`subject_mode_id`')
            ->where('`subject_code` = ?', $subject->getCode())
            ->where('`department_id` = ?', $subject->getDepartment());
        return $sql->query()->fetchColumn();
    }
    /**
     * Fetches only those semesters in which subject is taught
     * 
     * @param Acad_Model_Course_Subject $subject
     * @return array of department,degree,semester in which subject is taught
     */
    public function getSemesters (Acad_Model_Course_Subject $subject)
    {
        $sql = $this->getDbTable()
            ->select()
            ->from(`subject_department`, 
        array('department_id', 'degree_id', 'semester_id'))
            ->where('`subject_code` = ?', $subject->getCode());
        return $sql->query()->fetchAll();
    }
    /**
     * Fetches Faculty members who teaches subject
     * 
     * @param Acad_Model_Course_Subject $subject
     * @return array of department,degree,semester,faculty id,mode in which subject is taught
     */
    public function getFaculties (Acad_Model_Course_Subject $subject)
    {
        $sql = $this->getDbTable()
            ->select()
            ->from(`subject_department`, 
        array('department_id', 'degree_id', 'semester_id'))
            ->join('subject_faculty', 
        '(`subject_faculty`.`department_id` = `subject_department`.`department_id`) 
        AND (`subject_faculty`.`subject_code` = `subject_department`.`subject_code`)',
            array('`staff_id`','`subject_mode_id`'))
            ->where('`subject_code` = ?', $subject->getCode());
        return $sql->query()->fetchAll();
    }
}
?>