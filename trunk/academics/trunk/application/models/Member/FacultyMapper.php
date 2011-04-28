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
    public function listMarkedAttendance (Acad_Model_Member_Faculty $faculty)
    {
        $sql = 'SELECT
              `period_attendance`.`period_date`,
              `period_attendance`.`marked_date`,
              `period`.`period_number`,
              LOWER(`subject`.subject_name) AS subject_name,
              `period`.`department_id`,
              `period`.`degree_id`,
              `period`.`semester_id`,
              `timetable`.`group_id`
            FROM
                `period_attendance`
                INNER JOIN `timetable` 
                    ON (`period_attendance`.`timetable_id` = `timetable`.`timetable_id`)
                INNER JOIN `period` 
                    ON (`timetable`.`period_id` = `period`.`period_id`)
                INNER JOIN `subject` 
                    ON (`subject`.`subject_code` = `timetable`.`subject_code`)
            WHERE (`period_attendance`.`marked_date` IS NOT NULL
                   AND `timetable`.`staff_id` = ?)
            ORDER BY `period_attendance`.`period_date` DESC LIMIT 20';
        return $this->getDbTable()
            ->getAdapter()
            ->query($sql, $faculty->getMemberId())
            ->fetchAll();
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
