<?php
class Acad_Model_Mapper_Course_Class
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    //protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Course_Class
     */
    /*
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
    */
    /**
     * Get registered Zend_Db_Table instance
     * @return Zend_Db_Table_Abstract
     */
    /*
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('');
        }
        return $this->_dbTable;
    }
    */
    /**
     * Fetches Subject Codes of a class
     * 
     * @param Acad_Model_Class $class
     * @param string $subjectType
     * @param string $subjectMode
     * 
     */
    public function getSubjects (Acad_Model_Course_Class $class, 
    $subjectType = null, $subjectMode = null)
    {
        $sql = $this->getDbTable()
            ->getAdapter()
            ->select()
            ->from('subject_department', array())
            ->join('subject', 
        '`subject_department`.`subject_code` = `subject`.`subject_code`', 
        array('subject_code', 'subject_name', 'suggested_duration'))
            ->join('subject_mode', 
        '`subject`.`subject_type_id` = `subject_mode`.`subject_type_id`', 
        array('group_together'))
            ->where('department_id = ?', $class->getDepartment_id())
            ->where('programme_id = ?', $class->getProgramme_id())
            ->where('semester_id = ?', $class->getSemester_id());
        if (isset($subjectType)) {
            $sql->where('`subject_mode`.`subject_type_id` = ?', $subjectType);
        } else {
            $sql->columns('subject_mode`.`subject_type_id');
        }
        if (isset($subjectMode)) {
            $sql->where('subject_mode_id = ?', $subjectMode);
        } else {
            $sql->columns('subject_mode.subject_mode_id');
        }
        return $sql->query()->fetchAll();
    }
}