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
}
