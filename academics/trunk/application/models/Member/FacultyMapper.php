<?php
/**
 * Student data mapper
 *
 * Implements the Data Mapper design pattern:
 * http://www.martinfowler.com/eaaCatalog/dataMapper.html
 * 
 * @uses       Default_Model_DbTable_Guestbook
 * @package    QuickStart
 * @subpackage Model
 */
class Acad_Model_Member_FacultyMapper
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_FacultyMapper
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
     * Lazy loads Default_Model_DbTable_Guestbook if no instance registered
     * 
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Zend_Db_Table');
        }
        return $this->_dbTable;
    }
    public function listMarkedAttendance (Acad_Model_Member_Faculty $faculty, 
                                        $periodDate = NULL, 
                                        $department = NULL, 
                                        $programme = NULL, 
                                        $semester = NULL, 
                                        $limit = 25)
    {
        $faculty_id = $faculty->getMemberId();
        $select = Zend_Db_Table::getDefaultAdapter()->select()
                    ->from('period_attendance2',
                                    array('attendance_id',
                                            'period_date',
                                            'department_id',
                                            'programme_id',
                                            'semester_id',
                                            'group_id',
                                            'subject_code',
                                            'subject_mode_id',
                                            'duration',
                                            'weekday_number',
                                            'period_number',
                                            'period_type',
                                            'marked_date'))
                    ->join('student_attendance2', 
                    		'`period_attendance2`.`attendance_id` = `student_attendance2`.`attendance_id`',
                        array('COUNT(`student_attendance2`.`student_roll_no`) AS absent'))
                    ->where('faculty_id = ?',$faculty_id)
                    ->group('period_attendance2.attendance_id')
                    ->order('period_date DESC')
                    ->limit($limit);
        return $select->query()->fetchAll();
    }
    public function listUnMarkedAttendance (Acad_Model_Member_Faculty $faculty, $department_id = null)
    {
        $sql = $this->getDbTable()
            ->getAdapter()
            ->select()
            ->from('UnMarkedAttendance')
            ->where('staff_id = ?', $faculty->getMemberId());
        if (! is_null($department_id)) {
            $sql->where('department_id = ?', $department_id);
        }
        return $sql->query()->fetchAll();
    }
    

    public function listUnMarkedAttendanceStat (Acad_Model_Member_Faculty $faculty, $department_id = null)
    {
        $sql = 'SELECT
  totalprd.*,
  unmarked.pending
FROM (SELECT
        staff_id,
        subject_name,
        subject_mode_name,
        department_id,
        degree_id,
        semester_id,
        COUNT(1)          AS total
      FROM periodinfo
      GROUP BY staff_id,subject_code,subject_mode_id) AS totalprd
  JOIN (SELECT
          staff_id,
          subject_name,
          subject_mode_name,
          department_id,
          degree_id,
          semester_id,
          COUNT(1)          AS pending
        FROM unmarkedattendance
        GROUP BY staff_id,subject_code,subject_mode_id) AS unmarked
    ON (totalprd.staff_id = unmarked.staff_id
        AND totalprd.subject_name = unmarked.subject_name
        AND totalprd.subject_mode_name = unmarked.subject_mode_name
        AND totalprd.department_id = unmarked.department_id
        AND totalprd.degree_id = unmarked.degree_id
        AND totalprd.semester_id = unmarked.semester_id)
WHERE totalprd.staff_id = ? ';
        $bind = array($faculty->getMemberId());
        if (! is_null($department_id)) {
            $sql .= ' AND totalprd.department_id = ?';
            $bind[] = $department_id;
        }
        return $this->getDbTable()->getAdapter()->query($sql,$bind)->fetchAll();
    }
    
	/**
     * Get Faculty Subjects
     * @param Acad_Model_Member_Faculty $faculty
     * @return array
     */
    public function fetchSubjects (Acad_Model_Member_Faculty $faculty, 
                                    Acad_Model_Class $class = NULL, 
                                    $showModes = NULL){
        $select = $this->getDbTable()->getAdapter()->select();
        $select->distinct()
                ->from('subject_faculty',
                            array('subject_code'))
                ->join('subject', 
                		'subject_faculty.subject_code = subject.subject_code',
                        array('subject_name'))
                ->join('subject_department', 
                		'subject_department.subject_code = subject.subject_code',
                        array())
                ->where('subject_faculty.staff_id = ?',$faculty->getMemberId());
                
        if (isset($showModes)) {
            $select->columns('subject_mode_id');
        }
        
        if (isset($class)) {
            $select->where('subject_department.department_id = ?', $class->getDepartment())
                    ->where('subject_department.degree_id = ?', $class->getDegree())
                    ->where('subject_department.semester_id = ?', $class->getSemester());
        }
        
        return  $select->query()->fetchAll(Zend_Db::FETCH_GROUP);
    }
}
