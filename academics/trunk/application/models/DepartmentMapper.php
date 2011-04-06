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
     * Fetch an overview of attendance status.
     * 
     * Fetch an overview of attendance status of all departments whose time table has been entered.
     * @param date $dateFrom
     */
    public function fetchAttendanceStat($dateFrom = null) {
        if (null == isset($dateFrom)) {
            $dateFrom = 'CURRENT_DATE';
        }
        $sql = "CALL prd_att_deptt_wise(?)";
        return $this->getDbTable()->getAdapter()->query($sql,$dateFrom)->fetchAll();
    }
    

    /**
     * 
     * Enter description here ...
     * @param Acad_Model_Department $dept
     * @param string $dateFrom
     * @param string $degree
     * @param int $semester
     */
    public function fetchAttendanceDetail(Acad_Model_Department $dept, 
                                            $dateFrom = null, 
                                            $degree = null, 
                                            $semester = null) {
                                                
                                                
        if (null == isset($dateFrom)) {
            $dateFrom = 'CURRENT_DATE';
        }
        
        $select = $this->getDbTable()->getAdapter()
                        ->select()->from('period_attendance',array('staff_id','marked_date'))
                        ->join('timetable',
                        	'`period_attendance`.`timetable_id` = `timetable`.`timetable_id`',
                            array('period.degree_id',
                            		'period.semester_id',
                            		'periods_covered',
                            		'subject_code',
                            		'subject_mode_id',
                            		'group_id'))
                        ->join('period', 
                    		'`timetable`.`period_id` = `period`.`period_id`',
                            array())
                        ->where('`period_attendance`.period_date = ?',$dateFrom)
                        ->where('timetable.department_id = ?', $dept->getDepartment());
                        
        return $select->query()->fetchAll();
    }
}