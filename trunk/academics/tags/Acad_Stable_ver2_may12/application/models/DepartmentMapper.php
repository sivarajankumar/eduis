<?php
class Acad_Model_DepartmentMapper
{
    /**
     * @var Acadz_Base_Model
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * @param  Acadz_Base_Model $dbTable 
     * @return Acad_Model_ClassMapper
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
     * Lazy loads Acadz_Base_Model if no instance registered
     * As there no corrosponding DbTable so base model is used.
     * @return Acadz_Base_Model
     */
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable(new Zend_Db_Table());
        }
        return $this->_dbTable;
    }

    /**
     * An semesterwise overview of student attendance.
     * @param Acad_Model_Department $department
     * @param string $programme
     * @param date_string $date_from
     * @param date_string $date_upto
     * @param int $semester
     */
    public function fetchAttendance(Acad_Model_Department $department, $programme = NULL, 
                                $date_from = NULL, $date_upto = NULL,$semester = null) {
                                    
        $dept = $department->getDepartment(); 
        $studentAttendance = new Acad_Model_DbTable_StudentAttendance2();
        
        $order = array('semester_id','subject_mode_id', 'subject_code','group_id');
        $rawResult = $studentAttendance->stats($dept, $programme ,$semester,null,null,null,
                                                $date_from,$date_upto,true,$order);
        $processed = array();
        foreach ($rawResult as $department_id => $attendanceList) {
            foreach ($attendanceList as $key => $attendance) {
                
                $subjectCode = $attendance['subject_code'];
                $subjectMode = $attendance['subject_mode_id'];
                $group_id = $attendance['group_id'];
                $semester_id = $attendance['semester_id'];
                
                unset($attendance['subject_code']);
                unset($attendance['subject_mode_id']);
                unset($attendance['group_id']);
                unset($attendance['semester_id']);
                
                $processed[$semester_id][$subjectMode][$subjectCode][$group_id][] = $attendance;
            }
            
        }
        return $processed;
    }
}