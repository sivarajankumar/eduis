<?php
class Acad_Model_DbTable_AttendanceMarked extends Acadz_Base_Model
{
    protected $_name = 'att_marked_status';
    const TABLE_NAME = 'att_marked_status';
    /**
     * Stat for delievered periods. Its returns counts and duration of delievered periods.
     * 
     * Although, Most of the functions using it have almost same parameters, but their occurance
     * order is different as per requirement.
     * 
     * @param string $department_id
     * @param string $programme_id
     * @param int $semester_id
     * @param string $subject_code
     * @param string $subject_mode_id
     * @param string $group_id
     * @param string $faculty_id
     * @param int $delievered
     * @param int $total_duration
     * @return array List of periods with count and duration.
     */
    public function getAttendanceStat ($department_id = null, $programme_id = null, 
    $semester_id = null, $subject_code = null, $subject_mode_id = null, $group_id = null, 
    $faculty_id = null, $delievered = null, $total_duration = null)
    {
        $sql = $this->select()->from(self::TABLE_NAME, array());
        if (isset($department_id)) {
            $sql->where('department_id = ?', $department_id);
        } else {
            $sql->columns('department_id');
        }
        if (isset($programme_id)) {
            $sql->where('programme_id = ?', $programme_id);
        } else {
            $sql->columns('programme_id');
        }
        if (isset($semester_id)) {
            $sql->where('semester_id = ?', $semester_id);
        } else {
            $sql->columns('semester_id');
        }
        if (isset($subject_code)) {
            $sql->where('subject_code = ?', $subject_code);
        } else {
            $sql->columns('subject_code');
        }
        if (isset($subject_mode_id)) {
            $sql->where('subject_mode_id = ?', $subject_mode_id);
        } else {
            $sql->columns('subject_mode_id');
        }
        if (isset($group_id)) {
            $sql->where('group_id = ?', $group_id);
        } else {
            $sql->columns('group_id');
        }
        if (isset($faculty_id)) {
            $sql->where('faculty_id = ?', $faculty_id);
        } else {
            $sql->columns('faculty_id');
        }
        if (isset($delievered)) {
            if (isset($delievered['min'])) {
                $min = $delievered['min'];
                $sql->where('delievered >=', $min);
            }
            if (isset($delievered['max'])) {
                $max = $delievered['max'];
                $sql->where('delievered <=', $max);
            }
            $sql->columns('delievered');
        } else {
            $sql->columns('delievered');
        }
        if (isset($total_duration)) {
            if (isset($total_duration['min'])) {
                $min = $total_duration['min'];
                $sql->where('total_duration >=', $min);
            }
            if (isset($total_duration['max'])) {
                $max = $total_duration['max'];
                $sql->where('total_duration <=', $max);
            }
            $sql->columns('total_duration');
        } else {
            $sql->columns('total_duration');
        }
        return $sql->query()->fetchAll();
    }
    /**
     * Attendance counts on basis of subject.
     * 
     * @param string $subject
     * @param string $subject_mode_id
     * @param string $department_id
     * @param string $group_id
     */
    public function getSubjectAttendance ($subject, $subject_mode_id = null, 
    $department_id = null, $group_id = null)
    {
        return self::getAttendanceStat($department_id, null, null, $subject, 
        $subject_mode_id, $group_id);
    }
    /**
     * Attendance counts of faculty subject.
     * 
     * @param string $faculty_id
     * @param string $subject
     * @param string $subject_mode_id
     * @param string $department_id
     * @param string $group_id
     */
    public function getFacultySubjectAttendance ($faculty_id, $subject = null, 
    $subject_mode_id = null, $department_id = null, $group_id = null)
    {
        return self::getAttendanceStat($department_id, null, null, $subject, 
        $subject_mode_id, $group_id, $faculty_id);
        ;
    }
    /**
     * Attendance counts of faculty in class.
     * 
     * @param string $faculty_id
     * @param string $department_id
     * @param string $programme_id
     * @param int $semester_id
     */
    public function getClassAttendance ($department_id = null, $programme_id = null, 
    $semester_id = null, $subject_mode_id = null, $group_id = null, $faculty_id = null)
    {
        return self::getAttendanceStat($department_id, $programme_id, 
        $semester_id, null, $subject_mode_id, $group_id, $faculty_id);
    }
    /**
     * filteration on basis of periods delievered.
     * @deprecated It isnt seems so usefull to implement.
     * @param int $min
     * @param int $max
     * @param string $department_id
     * @param string $programme_id
     * @param int $semester_id
     */
    public function getDelieveredRange ($min = 1, $max = null, $department_id = null, 
    $programme_id = null, $semester_id = null)
    {
        ;
    }
}