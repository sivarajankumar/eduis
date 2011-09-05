<?php
class Acad_Model_DbTable_FacultyAdjustment extends Acadz_Base_Model
{
    protected $_name = 'adjustment_faculty';
    const TABLE_NAME = 'adjustment_faculty';
    protected $tbltimetable = 'timetable';
    protected $objtimetable;
    public $dbselect;
    public function init ()
    {
        $this->objtimetable = new Acad_Model_DbTable_TimeTable();
        $this->dbselect = $this->select();
    }
    public function adjustperiod ($data)
    {
        $sql = 'INSERT INTO '.self::TABLE_NAME.' (`source_timetable_id`, `start_date`, `source_staff_id`,`target_timetable_id`,`target_staff_id`) VALUES ';
        $addComma = null;
        foreach ($data as $key => $values) {
            $source_timetable_id = $values['source_timetable_id'];
            $start_date = $values['start_date'];
            $source_staff_id = $values['source_staff_id'];
            $target_timetable_id = $values['target_timetable_id'];
            $target_staff_id = $values['target_staff_id'];
            //$end_date		= $values['end_date'];
            if ($addComma) {
                $sql .= ', ';
            }
            $sql .= "('$source_timetable_id','$start_date','$source_staff_id','$target_timetable_id','$target_staff_id')";
            $addComma = 1;
        }
        $status = $this->getDefaultAdapter()->query($sql);
        return $status;
    }
    public static function getAdjusted ($staff_id, $period_date)
    {
        $sql = self::getDefaultAdapter()->select()
            ->from(self::TABLE_NAME, 'source_timetable_id')
            ->where('source_staff_id = ?', $staff_id)
            ->where('start_date = ?', $period_date);
        $resultSet = $sql->query()->fetchAll();
        return $resultSet;
    }
    public static function getAdjustment ($staff_id, $period_date)
    {
        $sql = 'SELECT *
		FROM (SELECT
        timetable.period_id,
        tmp_result.source_timetable_id,
        tmp_result.subject_code,
        tmp_result.subject_name,
        tmp_result.subject_mode_id,
        tmp_result.subject_mode_name,
        tmp_result.department_id,
        tmp_result.degree_id,
        tmp_result.semester_id,
        tmp_result.source_staff_id
      FROM (SELECT
              timetable.period_id,
              '.self::TABLE_NAME.'.source_timetable_id,
              timetable.period_duration,
              timetable.subject_code,
              timetable.subject_mode_id,
              period.period_number,
              period.weekday_number,
              period.department_id,
              period.degree_id,
              period.semester_id,
              subject.subject_name,
              subject_mode.subject_mode_name,
              '.self::TABLE_NAME.'.source_staff_id
            FROM timetable
              INNER JOIN period
                ON timetable.period_id = period.period_id
              INNER JOIN SUBJECT
                ON timetable.subject_code = subject.subject_code
              INNER JOIN subject_mode
                ON timetable.subject_mode_id = subject_mode.subject_mode_id
              INNER JOIN '.self::TABLE_NAME.'
                ON '.self::TABLE_NAME.'.target_timetable_id = timetable.timetable_id
                  AND '.self::TABLE_NAME.'.target_staff_id = ?
                  AND '.self::TABLE_NAME.'.start_date = ?
                  AND ('.$period_date.' BETWEEN timetable.valid_from
                       AND timetable.valid_upto)
            GROUP BY timetable.period_id) AS tmp_result
        INNER JOIN timetable
          ON tmp_result.source_timetable_id = timetable.timetable_id) AS tmp_2
  INNER JOIN period
    ON tmp_2.period_id = period.period_id';
        $resultSet = self::getDefaultAdapter()->fetchAll($sql, 
        array($staff_id, $period_date));
        return $resultSet;
    }
    public static function cancelAdjustment ($period_id, $staff_id, $period_date)
    {
        $result = Acad_Model_DbTable_Timetable::getPeriodIdTimetable(
        $period_id, $period_date, $staff_id);
        $where = "source_staff_id='$staff_id'";
        $where .= "AND start_date='$period_date'";
        $where .= 'AND ( ';
        $or_stmt = '';
        foreach ($result as $column => $value) {
            $or_stmt = $or_stmt . 'source_timetable_id= ' .
             $value['timetable_id'];
            if (! ($column == count($result) - 1)) {
                $or_stmt .= ' OR ';
            }
        }
        $or_stmt .= ')';
        $where = $where . $or_stmt;
        return self::getDefaultAdapter()->delete(self::TABLE_NAME, $where);
    }
}