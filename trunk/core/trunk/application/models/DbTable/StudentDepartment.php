<?php
class Core_Model_DbTable_StudentDepartment extends Corez_Base_Model
{
    protected $_name = 'student_department';
    public static function getStudentInfo ($rollno)
    {
        $sql = self::getDefaultAdapter()->select()
            ->from(array('stuper' => 'student_personal'), 
        array('student_roll_no', 'first_name'))
            ->join(array('studept' => 'student_department'), 
        '(`stuper`.`student_roll_no` = `studept`.`student_roll_no`)', 
        array('group_id', 'department_id', 'degree_id'))
            ->join(array('batsem' => 'batch_semester'), 
        '(`batsem`.`department_id` = `studept`.`department_id`)
                            AND (`batsem`.`degree_id` = `studept`.`degree_id`)
                            AND (`batsem`.`batch_start` = `studept`.`batch_start`)', 
        array('semester_id'))
            ->where('`stuper`.`student_roll_no` = ?', $rollno)
            ->where('`studept`.`is_active` = 1');
        $result = $sql->query()->fetchAll();
        // Roll number is unique so only one record will appear.
        if (count($result)) {
            return $result[0];
        } else {
            return false;
        }
    }
    // Deprecated. See fn below it
    /*public function getstudentlist ($params)
    {
        $where = ' where 1=1 ';
        $fromJoin = ' FROM aceis.batch_semester INNER JOIN aceis.batch
			        ON (batch_semester.department_id = batch.department_id) AND (batch_semester.degree_id = batch.degree_id) AND (batch_semester.batch_start = batch.batch_start)
			    INNER JOIN aceis.student_department 
			        ON (student_department.department_id = batch.department_id) AND (student_department.degree_id = batch.degree_id) AND (student_department.batch_start = batch.batch_start)
			    INNER JOIN aceis.student_personal 
			        ON (student_department.student_roll_no = student_personal.student_roll_no)';
        foreach ($params as $column => $value) {
            $where = $where . ' and ' . $column . '=' . "'" . $value . "'";
        }
        $sql = 'SELECT
			    student_department.student_roll_no
			    , student_personal.first_name
			    , student_personal.middle_name
			    , student_personal.last_name
			    , student_personal.gender_id';
        $sql .= $fromJoin . $where;
        return $this->getAdapter()->fetchAll($sql);
    }*/
    /*
	 * List of Students in a class
	 */
    public static function getClassStudent ($department, $degree, $semester, 
    $group = NULL)
    {
        $sql = self::getDefaultAdapter()->select()
            ->from(array('batsem' => 'batch_semester'), array())
            ->join(array('bat' => 'batch'), 
        '(`batsem`.department_id = `bat`.department_id)
                                AND (`batsem`.degree_id = `bat`.degree_id)
                                AND (`batsem`.batch_start = `bat`.batch_start)', 
        array())
            ->join(array('studept' => 'student_department'), 
        '(`studept`.department_id = `bat`.department_id)
                                AND (`studept`.degree_id = `bat`.degree_id)
                                AND (`studept`.batch_start = `bat`.batch_start)', 
        array())
            ->join(array('stuper' => 'student_personal'), 
        '(`stuper`.student_roll_no = `studept`.student_roll_no)', 
        array('student_roll_no', 'first_name', 'last_name'))
            ->where('`batsem`.department_id = ?', $department)
            ->where('`batsem`.degree_id = ?', $degree)
            ->where('`batsem`.semester_id = ?', $semester)
            ->where('`studept`.`is_active` = 1');
        if (isset($group)) {
            $sql->where("`studept`.group_id = ?", $group);
        } else {
            $sql->columns('group_id', 'studept');
        }
        return $sql->query()->fetchAll();
    }
}