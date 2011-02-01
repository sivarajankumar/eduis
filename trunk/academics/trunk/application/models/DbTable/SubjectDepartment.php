<?php
class Acad_Model_DbTable_SubjectDepartment extends Acadz_Base_Model
{
    protected $_name = 'subject_department';
    /*
	 * Fetches Subject Codes of a class
	 */
    public static function getSemesterSubjects ($department, $degree, $semester, 
    $subjectType = NULL)
    {
        $sql = 'SELECT
    `subject`.`subject_code`
    , `subject`.`subject_name`
    , `subject`.`subject_type_id`
    , `subject`.`suggested_duration`
    , `subject_mode`.`subject_mode_id`
    , `subject_mode`.`group_together`
FROM
    `subject_department`
    INNER JOIN `subject` 
        ON (`subject_department`.`subject_code` = `subject`.`subject_code`)
    INNER JOIN `subject_mode` 
        ON (`subject_mode`.`subject_type_id` = `subject`.`subject_type_id`)
        WHERE (`subject_department`.semester_id = ?)
    AND (`subject_department`.degree_id = ?)
    AND (`subject_department`.department_id = ?)';
        $data = array($semester, $degree, $department);
        /*
        self::getDefaultAdapter()->select()
            ->from(array('sdep' => 'subject_department'), 'subject_code')
            ->join(array('sub' => 'subject'), 
        '`sub`.subject_code = `sdep`.subject_code', 'subject_name')
            ->where('`sdep`.semester_id = ?', $semester)
            ->where('`sdep`.degree_id = ?', $degree)
            ->where('`sdep`.department_id = ?', $department)
            ->order('subject_name');
        if (isset($subjectType)) {
            $sql->where('`sub`.subject_type_id = ?', $subjectType);
        }
        return $sql->query()->fetchAll(Zend_Db::FETCH_GROUP);*/
        
        if (isset($subjectType)) {
                $sql .= ' AND (`sub`.subject_type_id = ?)';
                $data[] = $subjectType;
            }
            $sql .= ' ORDER BY `subject_name` ASC';
        return self::getDefaultAdapter()->fetchAll($sql, $data, Zend_Db::FETCH_GROUP);
    }
    /*
     * Faculty of a class
     */
    public static function getSemesterFaculty ($department, $degree, $semester, 
    $subjectType = NULL)
    {
        $sql = self::getDefaultAdapter()->select()
            ->distinct()
            ->from(array('subfac' => 'subject_faculty'), 'staff_id')
            ->join(array('subdep' => 'subject_department'), 
        '`subfac`.subject_code = `subdep`.subject_code', array())
            ->join(array('staffper' => 'staff_personal'), 
        '`subfac`.staff_id = `staffper`.staff_id', 
        array('first_name', 'last_name', 'department_id'))
            ->where('`subdep`.semester_id = ?', $semester)
            ->where('`subdep`.degree_id = ?', $degree)
            ->where('`subdep`.department_id = ?', $department)
            ->order(array('first_name'));
        if (isset($subjectType)) {
            $sql->where('`subfac`.subject_type_id = ?', $subjectType);
        }
        return $sql->query()->fetchAll();
    }
/**
 * Used in reportstuwiseAction in StudentattendanceController. Kindly correct if necessory. Its not optimised.
 * @param $department
 * @param $degree
 * @param $semester
 * @param $group
 * @param $subjectType
 * @deprecated Dosent seems usefull. Its similar to  getSemesterSubjects() and includes $groups which not much significant.
 */
/*
public static function getActiveSubjects($department, $degree, $semester, $group, $subjectType = 'TH') {
		$sql = 'SELECT DISTINCT `timetable`.`department_id`, 
                `timetable`.`degree_id`, 
                `timetable`.`semester_id`, 
                `timetable`.`subject_code`,
                `subject`.`subject_name`
		FROM `timetable` `timetable`
		      INNER JOIN `subject` `subject` ON 
		     (`subject`.`subject_code` = `timetable`.`subject_code`)
		WHERE ( `timetable`.`semester_id` = ? )
		       AND ( `timetable`.`department_id` = ? )
		       AND ( `timetable`.`degree_id` = ? )
		       AND ( `timetable`.`group_id` = ?)
		       AND ( `subject`.`subject_type_id` = ? )';
		
		$params = array($semester, $department, $degree, $group, $subjectType  );
		return self::getDefaultAdapter ()->fetchAll ( $sql, $params );
	}*/
/*
    // Deprecated
    public function getDepartmentSubjectInfo($params,$cols) {
        
        $this->select()->from ( $this->_name,$cols )->distinct();
        foreach ( $params as $column => $value ) {
            $this->select()->where ( "$column = ?", $value );
            
        }
        $dbStatement = $this->select()->query ();
        $resultSet = $dbStatement->fetchAll ();
        return $resultSet;
        
    
    }*/
}