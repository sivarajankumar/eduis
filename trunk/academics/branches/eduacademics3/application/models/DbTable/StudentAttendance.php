<?php
class Acad_Model_DbTable_StudentAttendance extends Acadz_Base_Model
{
    protected $_name = 'student_attendance';
    protected $logger;
    protected $dbSelect;
    public function init ()
    {
        $this->logger = Zend_Registry::get('logger');
        $this->dbSelect = $this->select();
    }
    public function totalSubjects ($rollno, $subjectType = 'TH')
    {
        $params = array($rollno);
        $sql = 'SELECT
  `subject`.`subject_code`,
  `subject`.`subject_name`,
  `subject_department`.`department_id`,
  `subject_department`.`degree_id`,
  `student_department`.`group_id`
FROM `nwaceis`.`subject_department`
  INNER JOIN `nwaceis`.`subject`
    ON (`subject_department`.`subject_code` = `subject`.`subject_code`)
  INNER JOIN `nwaceis`.`batch_semester`
    ON (`batch_semester`.`department_id` = `subject_department`.`department_id`)
      AND (`batch_semester`.`degree_id` = `subject_department`.`degree_id`)
      AND (`batch_semester`.`semester_id` = `subject_department`.`semester_id`)
  INNER JOIN `nwaceis`.`student_department`
    ON (`student_department`.`department_id` = `batch_semester`.`department_id`)
      AND (`student_department`.`degree_id` = `batch_semester`.`degree_id`)
      AND (`student_department`.`batch_start` = `batch_semester`.`batch_start`)
WHERE ( `student_department`.`student_roll_no` = ? ' . $subjectType . ');';
        if ($subjectType) {
            $subTypeStmt = ' AND `subject`.`subject_type_id` = ?';
            $params[] = $subjectType;
        }
        return $this->getAdapter()->fetchAll($sql, $params);
    }
    public function totalAbsent ($ttid, $rollno, $dateFrom = NULL, $dateTo = NULL)
    {
        $sql = $this->select()
            ->from($this->_name, 'COUNT(*) as counts')
            ->where('student_roll_no = ?', $rollno);
        if (isset($dateFrom) and isset($dateTo)) {
            $sql->where('period_date BETWEEN ? AND ?', $dateFrom, $dateTo);
        } else 
            if (isset($dateFrom)) {
                $sql->where('period_date BETWEEN ? AND CURDATE()', $dateFrom);
            }
        $first_ttid = array_shift($ttid);
        $ttidsql = "(timetable_id = '$first_ttid')";
        foreach ($ttid as $row => $value) {
            $ttidsql .= " OR (timetable_id = '$value')";
        }
        $sql->where($ttidsql);
        $this->logger->log('$first_ttid', Zend_Log::INFO);
        $this->logger->log($first_ttid, Zend_Log::DEBUG);
        $this->logger->log(
        'totalAbsent($ttid, $rollno, $dateFrom = NULL, $dateTo = NULL)', 
        Zend_Log::INFO);
        $this->logger->log($sql->assemble(), Zend_Log::DEBUG);
        return $this->getAdapter()->fetchRow($sql, '', Zend_Db::FETCH_COLUMN);
    }
    public function getMarkedStudentList ($timetable_arr, $period_date)
    {
        $this->dbSelect->reset();
        $this->dbSelect->from($this->_name);
        $ttidsql = " AND (";
        foreach ($timetable_arr as $key => $value) {
            $ttidsql = $ttidsql . "  timetable_id = " . $value['timetable_id'];
            if ($key < count($timetable_arr) - 1)
                $ttidsql = $ttidsql . ' OR ';
        }
        $ttidsql = $ttidsql . ")";
        $this->dbSelect->where("period_date = ?", $period_date);
        $sql = $this->dbSelect->__toString() . $ttidsql;
        $resultSet = $this->getAdapter()->fetchAll($sql);
        return $resultSet;
    }
}