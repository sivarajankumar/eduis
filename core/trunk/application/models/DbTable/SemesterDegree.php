<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage SemesterDegree
 * @since	   0.1
 */
/*
 * bla...bla
 */
class Core_Model_DbTable_SemesterDegree extends Corez_Base_Model {
	/*
	 * Model\'s Table Name
	 */
	protected $_name = 'semester_degree';
	const TABLE_NAME = 'semester_degree';
	
	/*
	 * All semesters of a given department\'s degree
	 */
	public static function semesters($department, $degree, $currentSession = NULL) {
		
		$sql = self::getDefaultAdapter()->select ()
		              ->distinct ()
		              ->from ( self::TABLE_NAME, 'semester_id' )
		              ->where ( 'degree_id = ?', $degree )
		              ->where ( 'handled_by_dept = ?', $department );
		
		if ($currentSession) {
			$sessionType = Core_Model_DbTable_AcademicSession::currentSessionType ();
			$sql->where ( '`semester_type_id` = ?', $sessionType );
		}
		return $sql->query ()->fetchAll ();
	}
	
	
	/* @deprecated
	 * Semesters in Current Session
	 */
	public static function allSemesters($department, $degree) {
		$sql = self::getDefaultAdapter()->select ()
		              ->from ( self::TABLE_NAME, 'semester_id' )
		              ->where ( 'degree_id = ?', $degree )
		              ->where ( 'department_id = ?', $department );
		return $sql->query ()->fetchAll ();
	}
	
	
	/*
	 * Get Slave departments of given department.
	 */
	public static function slaveDepartment($masterDepartment, $currentSession = NULL) {
		$sql = self::getDefaultAdapter()->select ()
		              ->distinct ()
		              ->from ( self::TABLE_NAME, 'department_id' )
		              ->where ( '`handled_by_dept` = ?', $masterDepartment );
		
		if ($currentSession) {
			$sessionType = Model_DbTable_AcademicSession::currentSessionType ();
			$sql->where ( '`semester_type_id` = ?', $sessionType );
		}
		
		return $sql->query ()->fetchAll (Zend_Db::FETCH_COLUMN);
	}

	
    /*
     * Get Slave Degree of given department.
     */
    public static function slaveDegree($masterDepartment, $slaveDepartment = NULL) {
    	
        $sql = self::getDefaultAdapter()->select ()
                      ->distinct ()
                      ->from ( self::TABLE_NAME, 'degree_id' )
                      ->where ( '`handled_by_dept` = ?', $masterDepartment );
                      
        if ($slaveDepartment) {
        	$sql->where ( '`department_id` = ?', $slaveDepartment );
        }
        
        return $sql->query ()->fetchAll ();
    }
    
    /* @Note : Not in use till now
     * All slave Department, Degree, Semesters
     */
    public static function slaveInfo($masterDepartment, $currentSession = NULL, $degree = FALSE, $semester = FALSE) {
    	
        $sql = self::getDefaultAdapter()->select ()
                      ->distinct ()
                      ->from ( self::TABLE_NAME, 'department_id' )
                      ->where ( 'handled_by_dept = ?', $masterDepartment );
        
        if ($currentSession) {
            $sessionType = Model_DbTable_AcademicSession::currentSessionType ();
            $sql->where ( '`semester_type_id` = ?', $sessionType );
        }
        
        if ($degree) {
        	$sql->columns('degree_id');
        }
        if ($semester) {
        	$sql->columns('semester_id');
        }
        return $sql->query ()->fetchAll ();
    }
    
	/* @deprecated
     * Check if multiple departments or just one.
     * 
     NOTE: It could be done via db query also but local check is preferred to avoid query
     */
	public static function isMultiDept(array $deptResult) {
		$dept = array ();
		foreach ( $deptResult as $key => $row ) {
			$dept [] = $row ['department_id'];
		}
		$count = count ( array_unique ( $dept ) );
		
		$status = (($count == 1) and ($count > 0)) ? 0 : $count;
		return $status;
	}

}