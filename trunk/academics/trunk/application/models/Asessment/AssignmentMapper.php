<?php
class Acad_Model_Assessment_AssignmentMapper
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Assessment_AssignmentMapper
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
     *
     * Lazy loads Acad_Model_Assessment_Assignment if no instance registered
     * 
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Acad_Model_DbTable_TestInfo');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches the marks of a particular student
     * @todo modify to adjust the behaviour if all marks are needed etc
     */
    public function fetchMarks ($deg, $dep, $sem, $stuRoll, $type)
    {
        $sql = 'SELECT
    `subject`.`subject_name`
    ,`test_info`.`test_id`
    , `test_info`.`subject_code`
    , `test_info`.`test_info_id`
    , `test_marks`.`status`
    , `test_marks`.`marks_scored`
    , `test_info`.`pass_marks`
    , `test_info`.`max_marks`
FROM
    `academics`.`test_marks`, 
    `academics`.`test_info`
    INNER JOIN `academics`.`subject` 
        ON (`test_info`.`subject_code` = `subject`.`subject_code`)
WHERE (`test_info`.`degree_id` =?
    AND `test_info`.`department_id` =?
    AND `test_info`.`semester_id` =?
    AND `test_info`.`test_type_id` =?
    AND `test_info`.`is_locked` =?
    AND `test_marks`.`student_roll_no` =?)';
        $bind = array($deg, $dep, $sem, $type, 1, $stuRoll);
        $result = $this->getDbTable()
            ->getAdapter()
            ->query($sql, $bind)->fetchAll();
        return $result;
    }
}
