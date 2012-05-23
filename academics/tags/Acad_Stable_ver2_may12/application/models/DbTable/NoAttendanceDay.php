<?php
class Acad_Model_DbTable_NoAttendanceDay extends Acadz_Base_Model_Dbtable
{
    protected $_name = 'no_attendanceday';
    public static function isnoattendanceday ($check_date, $department_id, 
    $degree_id = NULL, $semester_id = NULL)
    {
        $sql = self::getDefaultAdapter()->select()
            ->from('no_attendanceday', 
        array('date_from', 'date_upto', 'purpose_id'))
            ->where('department_id = ?', $department_id)
            ->where('date_from <= ?', $check_date)
            ->where('date_upto >= ?', $check_date);
        if (isset($degree_id)) {
            $sql->where('degree_id = ?', $degree_id);
        }
        if (isset($semester_id)) {
            $sql->where('semester_id =?', $semester_id);
        }
        $resultSet = $sql->query()->rowCount();
        return $resultSet;
    }
}