<?php
/**
 * 
 * @author Avtar, Hemant
 * @since 0.1
 * @version 2.0
 *
 */
class Acad_Model_DbTable_TimeTable extends Aceis_Base_Model {
	protected $_name = 'timetable';
	const TABLE_NAME = 'timetable';
	/*
	 * Customized insert
	 * @version 2.0
	 */
	public function insert(array $data) {
		//TODO Include Block and Rooms
		$data ['block_id'] = 'ADM_B1';
		$data ['room_id'] = '1';
		$periodsCovered = $data ['period'];
		for($i = 1; $i < $data ['period_duration']; ++ $i) {
			$nextPeriod = $data ['period'] + $i;
			$periodsCovered .= ',' . $nextPeriod;
		}
		$data ['periods_covered'] = $periodsCovered;
		
		$date = new Zend_Date ();
		$date->setDate ( $data ['valid_from'], 'dd/MM/YYYY' );
		$data ['valid_from'] = $date->toString ( 'YYYY-MM-dd' );
		$data ['valid_upto'] = Model_DbTable_AcademicSession::getSessionEndDate ();
		$currentPeriodStatus = self::currentPeriodStatus ( $data ['period_id'], TRUE );
		if ($currentPeriodStatus ['STATUS'] != 'EMPTY') {
			
			self::updateCurrentValidity ( $currentPeriodStatus, $data ['group_id'], $data ['valid_from'], $data ['periods_covered'] );
		}
		
		unset ( $data ['period'] );
		unset ( $data ['degree_id'] );
		unset ( $data ['semester_id'] );
		unset ( $data ['weekday_number'] );
		return parent::insert ( $data );
	}
	
	/**
	 * Update validity of current Timtable entry
	 * @version 2.0
	 * @param $currentPeriodStatus
	 * @param $group_id
	 * @param $endvalidityDate
	 * @param $periodCovered
	 */
	public static function updateCurrentValidity(array $currentPeriodStatus, $group_id, $endvalidityDate, $periodCovered) {
		//         //TEMP\\
		$logger = Zend_Registry::get ( 'logger' ); //Kindly delete this and related lines after finalization.
		//         \\TEMP//
		$params = array ();
		$params [] = $currentPeriodStatus ['periodStatus'] [0] ['department_id'];
		$params [] = $currentPeriodStatus ['periodStatus'] [0] ['degree_id'];
		$params [] = $currentPeriodStatus ['periodStatus'] [0] ['semester_id'];
		$params [] = $currentPeriodStatus ['periodStatus'] [0] ['weekday_number'];
		$groupStmt = '';
		$prdNumberSmt = '';
		$periodCovrdArry = explode ( ',', $periodCovered );
		$isGroupAvailable = FALSE;
		switch ($group_id) {
			
			//If Current period is alloted for ALL then period\'s groups can be ignored here.
			case ($currentPeriodStatus ['occupiedGroups'] == 'ALL' and $group_id != 'ALL') :
				$logger->debug ( 'CASE 1 :- CURRENT:ALL, NEXT: Any' );
				$groupStmt = ' AND (`timetable`.`group_id` = "ALL" OR `timetable`.`group_id` = ?) ';
				$params [] = $group_id;
				$prdNumberSmt = ' AND ( ';
				$setOr = false;
				foreach ( $periodCovrdArry as $key => $periodNumber ) {
					if ($setOr) {
						$prdNumberSmt .= ' OR ';
					}
					$prdNumberSmt .= ' FIND_IN_SET(?, periods_covered) ';
					$params [] = $periodNumber;
					$setOr = true;
				}
				$prdNumberSmt .= ' ) ';
				break;
			case ($currentPeriodStatus ['occupiedGroups'] == 'ALL' and $group_id == 'ALL') :
				$logger->debug ( 'CASE 2 :- CURRENT:ALL, NEXT: Any' );
				$groupStmt = ' AND (`timetable`.`group_id` = "ALL") ';
				$prdNumberSmt = ' AND ( ';
				$setOr = false;
				foreach ( $periodCovrdArry as $key => $periodNumber ) {
					if ($setOr) {
						$prdNumberSmt .= ' OR ';
					}
					$prdNumberSmt .= ' FIND_IN_SET(?, periods_covered) ';
					$params [] = $periodNumber;
					$setOr = true;
				}
				$prdNumberSmt .= ' ) ';
				break;
			
			// Current as well as new allotment is for a group.
			case ($currentPeriodStatus ['occupiedGroups'] != 'ALL' and $group_id != 'ALL') :
				$logger->debug ( 'CASE 3 :- CURRENT: GroupWise, NEXT: GroupWise' );
				foreach ( $currentPeriodStatus ['availableGroups'] as $key => $group ) {
					if ($group == $group_id) {
						$isGroupAvailable = TRUE;
						break;
					}
				}
				if (! $isGroupAvailable) {
					foreach ( $currentPeriodStatus ['periodStatus'] as $key => $timetable ) {
						if ($timetable ['group_id'] == $group_id) {
							$groupStmt = ' AND (  `timetable`.`group_id` = ? ) ';
							$params [] = $group_id;
							$prdNumberSmt = ' AND ( ';
							$setOr = false;
							foreach ( $periodCovrdArry as $key => $periodNumber ) {
								if ($setOr) {
									$prdNumberSmt .= ' OR ';
								}
								$prdNumberSmt .= ' FIND_IN_SET(?, periods_covered) ';
								$params [] = $periodNumber;
								$setOr = true;
							}
							
							$prdNumberSmt .= ' ) ';
						}
					}
				}
				
				break;
			
			//Current is groupwise and New allotment for ALL 
			case ($currentPeriodStatus ['occupiedGroups'] != 'ALL' and $group_id == 'ALL') :
				$logger->debug ( 'CASE 4 :- CURRENT: GroupsWise, NEXT: ALL' );
				$setOr = false;
				$groupStmt = ' AND ( ';
				foreach ( $currentPeriodStatus ['periodStatus'] as $key => $timetable ) {
					if ($setOr) {
						$groupStmt .= ' OR ';
					}
					$groupStmt .= ' `timetable`.`group_id` = ? ';
					$params [] = $timetable ['group_id'];
					$setOr = true;
				}
				$groupStmt .= ' ) ';
				$prdNumberSmt = ' AND ( ';
				$setOr = false;
				foreach ( $periodCovrdArry as $key => $periodNumber ) {
					if ($setOr) {
						$prdNumberSmt .= ' OR ';
					}
					$prdNumberSmt .= ' FIND_IN_SET(?, periods_covered) ';
					$params [] = $periodNumber;
					$setOr = true;
				}
				$prdNumberSmt .= ' ) ';
		}
		
		//Final SQL query
		if (! $isGroupAvailable) {
			$sql = 'UPDATE timetable AS tmp1
JOIN (SELECT 
         `timetable`.timetable_id
FROM `nwaceis`.`timetable`
  INNER JOIN `nwaceis`.`period`
    ON (`timetable`.`period_id` = `period`.`period_id`
        AND (CURDATE() BETWEEN valid_from
             AND valid_upto))
WHERE (`period`.`department_id` = ?
       AND `period`.`degree_id` = ?
       AND `period`.`semester_id` = ?
       AND `period`.`weekday_number` = ?
       AND `period`.period_type_id != "BRK" 
       ' . $groupStmt . $prdNumberSmt . ')) AS tmp2 ON
	   tmp1.timetable_id = tmp2.timetable_id
SET tmp1.valid_upto = DATE_SUB(?, INTERVAL 1 DAY);';
			$params [] = $endvalidityDate;
			return self::getDefaultAdapter ()->query ( $sql, $params );
		} else {
			$logger->debug ( 'Group is available. No update required.' );
			return TRUE;
		}
	}
	
	/*
	public static function updateCurrentValidity_old($periodId, $group_id, $endvalidityDate, $currentPeriodStatus, $duration) {
		$period = Department_Model_DbTable_Period::getIdPeriod ( $periodId );
		//$date = new Zend_Date();
		//$date->setDate($expectedValidFrom, 'dd/MM/YYYY');
		
		$params = array ($endvalidityDate, 
						$period ['department_id'], 
						$period ['degree_id'], 
						$period ['semester_id'], 
						$period ['weekday_number']);
						
		$sql = 'UPDATE timetable AS tmp
INNER JOIN (SELECT
         `timetable`.timetable_id
       FROM `nwaceis`.`period`
         JOIN `nwaceis`.`timetable`
           ON (`period`.`period_id` = `timetable`.`period_id`
               AND (CAST(? AS DATE)BETWEEN valid_from
                    AND valid_upto))
       WHERE (`period`.department_id = ?
              AND `period`.degree_id = ?
              AND `period`.semester_id = ?
              AND `period`.weekday_number = ?';
						
		if ('ALL' != $currentPeriodStatus[occupiedGroups] and 'ALL' != $group_id) {
			$periods = $currentPeriodStatus[periodStatus];
			$setOr = false;
			foreach ( $periods as $num => $prd ) {
				if ($prd[group_id] == $group_id ) {
					$sql .= ' AND `timetable`.group_id = ? ';
					$params[] = $prd[group_id];
				}
			}
		}
						
        $sql .= 'AND `period`.period_type_id != "BRK")
           AND FIND_IN_SET(?, periods_covered)) AS tmp1 ON
	   tmp.timetable_id = tmp1.timetable_id
SET tmp.valid_upto = DATE_SUB(?, INTERVAL 1 DAY)';
		
        $params[] = $period ['period_number'];
		$params[] = $endvalidityDate;
		
		return self::getDefaultAdapter ()->query ( $sql, $params );
	}
	
	/*
	 * Determines the status of a period in current timetable.
	 * @version 2.0
	 */
	public static function currentPeriodStatus($periodId, $detail = FALSE) {
		$period = Department_Model_DbTable_Period::getIdPeriod ( $periodId );
		//$date = new Zend_Date();
		//$date->setDate($expectedValidFrom, 'dd/MM/YYYY');
		$sql = 'SELECT
  `timetable`.timetable_id,
  `period`.department_id,
  `period`.degree_id,
  `period`.semester_id,
  `period`.`weekday_number`,
  `timetable`.subject_code,
  `timetable`.subject_mode_id,
  `timetable`.group_id,
  `timetable`.period_duration,
  `timetable`.periods_covered,
  `timetable`.valid_from,
  `timetable`.valid_upto
FROM `nwaceis`.`period`
  JOIN `nwaceis`.`timetable`
    ON (`period`.`period_id` = `timetable`.`period_id`
       AND ( CURDATE() BETWEEN valid_from AND valid_upto ))
WHERE (`period`.department_id = ?
       AND `period`.degree_id = ?
       AND `period`.semester_id = ?
       AND `period`.weekday_number = ?
       AND `period`.period_type_id != "BRK"
    AND FIND_IN_SET(?, periods_covered)) order by `timetable`.group_id';
		
		$params = array ($period ['department_id'], $period ['degree_id'], $period ['semester_id'], $period ['weekday_number'], $period ['period_number'] );
		$totalgroups = Model_DbTable_Groups::getClassGroups ( $period ['department_id'], $period ['degree_id'], TRUE );
		$periodStatus = self::getDefaultAdapter ()->fetchAll ( $sql, $params );
		$finalStatus = array ();
		
		if (! $periodStatus) {
			$status = 'EMPTY';
		} elseif ('ALL' == strtoupper ( $periodStatus [0] ['group_id'] )) {
			if ($detail) {
				$finalStatus ['periodStatus'] = $periodStatus;
			}
			$finalStatus ['occupiedGroups'] = 'ALL';
			$status = 'FULL';
		} else {
			$occupiedGroups = array ();
			foreach ( $periodStatus as $key => $group ) {
				$occupiedGroups [] = $group ['group_id'];
			}
			$finalStatus ['occupiedGroups'] = $occupiedGroups;
			$tmpavailableGroups = array_diff ( $totalgroups, $occupiedGroups );
			if ($detail) {
				$finalStatus ['periodStatus'] = $periodStatus;
			}
			if (count ( $tmpavailableGroups )) {
				// $tmpavailableGroups has unordered keys so $availableGroups is created.
				foreach ( $tmpavailableGroups as $key => $value ) {
					$availableGroups [] = $value;
				}
				$finalStatus ['availableGroups'] = $availableGroups;
				$status = 'PARTIAL';
			} else {
				$status = 'FULL';
			}
		
		}
		
		$finalStatus ['maxGroups'] = $totalgroups;
		$finalStatus ['STATUS'] = $status;
		return $finalStatus;
	}
	
	/*
	 * Determines the status of future period.
	 * @version 2.0
	 */
	public function periodStatus($periodId, $detail = FALSE) {
		$period = Department_Model_DbTable_Period::getIdPeriod ( $periodId );
		$sql = 'SELECT
  `timetable`.subject_code,
  `timetable`.subject_mode_id,
  `timetable`.group_id,
  `timetable`.period_duration,
  `timetable`.periods_covered,
  `timetable`.valid_from,
  `timetable`.valid_upto
FROM `nwaceis`.`period`
  JOIN `nwaceis`.`timetable`
    ON (`period`.`period_id` = `timetable`.`period_id`
       AND ( CURDATE() < `timetable`.valid_upto AND CURDATE() < `timetable`.valid_from))
WHERE (`period`.department_id = ?
       AND `period`.degree_id = ?
       AND `period`.semester_id = ?
       AND `period`.weekday_number = ?
       AND `period`.period_type_id != "BRK")
    AND FIND_IN_SET(?, periods_covered);';
		
		$params = array ($period ['department_id'], $period ['degree_id'], $period ['semester_id'], $period ['weekday_number'], $period ['period_number'] );
		$totalgroups = Model_DbTable_Groups::getClassGroups ( $period ['department_id'], $period ['degree_id'], TRUE );
		$periodStatus = self::getDefaultAdapter ()->fetchAll ( $sql, $params );
		$finalStatus = array ();
		
		if (! $periodStatus) {
			$status = 'EMPTY';
		} elseif ('ALL' == strtoupper ( $periodStatus [0] ['group_id'] )) {
			if ($detail) {
				$finalStatus ['periodStatus'] = $periodStatus;
			}
			$finalStatus ['occupiedGroups'] = 'ALL';
			$status = 'FULL';
		} else {
			$occupiedGroups = array ();
			foreach ( $periodStatus as $key => $group ) {
				$occupiedGroups [] = $group ['group_id'];
			}
			$finalStatus ['occupiedGroups'] = $occupiedGroups;
			$tmpavailableGroups = array_diff ( $totalgroups, $occupiedGroups );
			if ($detail) {
				$finalStatus ['periodStatus'] = $periodStatus;
			}
			if (count ( $tmpavailableGroups )) {
				// $tmpavailableGroups has unordered keys so $availableGroups is created.
				foreach ( $tmpavailableGroups as $key => $value ) {
					$availableGroups [] = $value;
				}
				$finalStatus ['availableGroups'] = $availableGroups;
				$status = 'PARTIAL';
			} else {
				$status = 'FULL';
			}
		
		}
		
		$finalStatus ['maxGroups'] = $totalgroups;
		$finalStatus ['STATUS'] = $status;
		return $finalStatus;
	}
	
	/**
	 * It fetches the faculty\'s scheduled periods.
	 * 
	 * @param string $staff_id
	 * @param int $weekday_number
	 * @param string $department_id
	 * @version 2.0
	 */
	public function getFacultyDayPeriods($staff_id,$period_date, $weekday_number = null, $department_id = null) {
		try {
			$sql = "SELECT timetable.timetable_id,timetable.period_id,
  subject.subject_name,
  timetable.subject_code,
  timetable.subject_mode_id,
  subject_mode.subject_mode_name,
  period.period_number,
  timetable.period_duration,
  period.weekday_number,
  period.department_id,
  period.degree_id,
  period.semester_id,
  weekday.weekday_name,
  timetable.staff_id
  FROM timetable
  INNER JOIN period
    ON period.period_id = timetable.period_id
  INNER JOIN SUBJECT
    ON subject.subject_code = timetable.subject_code
    INNER JOIN subject_mode
    ON timetable.subject_mode_id = subject_mode.subject_mode_id
    INNER JOIN WEEKDAY ON period.weekday_number = weekday.weekday_number
WHERE timetable.staff_id = ?
       AND ( '$period_date' between `timetable`.valid_from AND `timetable`.valid_upto)";
			
			$param = array ($staff_id );
			if (isset ( $weekday_number )) {
				$sql .= ' AND period.weekday_number = ?';
				array_push ( $param, $weekday_number );
			}
			if (isset ( $department_id )) {
				$sql .= ' AND timetable.department_id = ?';
				array_push ( $param, $department_id );
			}
			$sql .= ' GROUP BY timetable.period_id order by period.weekday_number';
			
			$resultSet = self::getDefaultAdapter ()->query ( $sql, $param )->fetchAll ();
			//return $sql;
		return $resultSet;
		} catch ( Exception $ex ) {
			return $ex->getMessage ();
		}
	
	}
	
	///////////////////////////////////////////////All about GROUPS//////////////////////////////
	

	/**
	 * Get groups in period.
	 * @param $period_id
	 * @param $department_id
	 * @param $degree_id
	 * @param $staff_id
	 */
	public static function getGroupsInPeriod($period_id, $department_id, $degree_id,$period_date, $staff_id = NULL) {
		$sql = self::getDefaultAdapter ()->select ()->from ( 'timetable', array ('timetable_id', 'group_id' ) )->where ( "period_id = ?  ", $period_id )->where ( "'$period_date' between `timetable`.valid_from AND `timetable`.valid_upto" );
		
		if (isset ( $staff_id )) {
			$sql->where ( "staff_id = ?", $staff_id );
		}
		
		self::getDefaultAdapter ()->select ()->group ( 'group_id' )->order ( 'group_id' );
		$groups = $sql->query ()->fetchAll ();
		$resultSet = null;
		$is_all = false;
		$timetable_id = '';
		foreach ( $groups as $key => $value ) {
			if (strtoupper ( $value ['group_id'] ) == 'ALL') {
				$is_all = true;
				$timetable_id = $value ['timetable_id'];
				break;
			}
		}
		if ($is_all) {
			$all_Groups = Model_DbTable_Groups::getClassGroups ( $department_id, $degree_id );
			foreach ( $all_Groups as $key => $value ) {
				$resultSet [$key] ['group_id'] = $value ['group_id'];
				$resultSet [$key] ['timetable_id'] = $timetable_id;
			}
			return $resultSet;
		} else {
			return $groups;
		}
	
	}
	
	/**
	 * Get Timetable of given period Id
	 * @param int $period_id
	 * @param string $staff_id
	 * @version 2.0
	 */
	public static function getPeriodIdTimetable($period_id,$period_date, $staff_id = null) {
		$sql = self::getDefaultAdapter ()->select ()->from ( 'timetable', array ('timetable_id', 'subject_code', 'subject_mode_id', 'group_id' ) )->join ( 'period', 'timetable.period_id = period.period_id', array ('department_id', 'degree_id', 'semester_id' ) )
		->where ( 'timetable.period_id = ?', $period_id )
		->where ( 'timetable.staff_id = ?', $staff_id )
		->where ( "'$period_date' BETWEEN timetable.valid_from AND timetable.valid_upto" );
		return $sql->query ()->fetchAll ();
	
	}
	
	/*
	 * @return all Time-Table Ids of a subject regardless of its type.
	 * deprecated
	 */
	public static function getSubjectTimetableids($department, $degree, $semester, $subjectcode, $subjectmode = NULL, $group = NULL, $current = FALSE) {
		$sql = self::getDefaultAdapter ()->select ()->from ( 'timetable', 'timetable_id' )
		->joinInner ( 'period', 'timetable.period_id = period.period_id', array () )
		->where ( "timetable.subject_code = ?", $subjectcode )
		->where ( "period.department_id = ?", $department )
		->where ( "period.degree_id = ?", $degree )
		->where ( "period.semester_id = ?", $semester );
		
		if ($group) {
			$sql->where ( "timetable.group_id = ?", $group );
		}
		if ($subjectmode) {
			$sql->where ( "timetable.subject_mode_id = ?", $subjectmode );
		}
		
		if ($current) {
			$sql->where ( 'curdate() between timetable.valid_from and timetable.valid_upto' );
		}
		return $sql->query ()->fetchAll ( Zend_db::FETCH_COLUMN );
	
	}
	
	public static function getMarkedSubjectTimetableids($department, $degree, $semester, $subjectcode, $subjectmode = NULL, $group = NULL, $current = TRUE) {
		$sql = self::getDefaultAdapter ()->select ()->from ( 'timetable', 'timetable_id' )->joinInner ( 'period', 'timetable.period_id = period.period_id', array () )->where ( "period.department_id = ?", $department )->where ( "period.degree_id = ?", $degree )->where ( "period.semester_id = ?", $semester )->where ( "timetable.subject_code = ?", $subjectcode );
		
		if ($group) {
			$sql->where ( "timetable.group_id = ?", $group );
		}
		if ($subjectmode) {
			$sql->where ( "timetable.subject_mode_id = ?", $subjectmode );
		}
		
		if ($current) {
			$sql->where ( 'curdate() between timetable.valid_from and timetable.valid_upto' );
		}
		return $sql->query ()->fetchAll ();
	
	}
}


	// OUT OF CLASS
	/*
     * @about  Get Information   from timetable
     * @param  Array()
     * @return Array() 
     */
	
	
	/*
     * Not fully occupied periods of a day. i.e. Empty or partial filled
     * return array Periods which are empty or partial filled
     *
	public static function notFullOccupiedPeriods($department, $degree, $semester, $weekday) {
		$sql = 'CALL notFullOccupied(?, ?, ?, ?)';
		return self::getDefaultAdapter ()->fetchAll ( $sql, array ($department, $degree, $semester, $weekday ) );
	}
	
	/*
	 * Totally empty periods excluding breaks.
	 *
	public static function emptyPeriods($department, $degree, $semester, $weekday) {
		$sql = 'SELECT
				  `period`.`period_id` as pid, `period`.`period_number`
				FROM `nwaceis`.`period`
				  LEFT JOIN `nwaceis`.`timetable`
				    ON (`period`.`period_id` = `timetable`.`period_id`
				        AND (`timetable`.valid_upto > CURDATE()
				              OR `timetable`.valid_upto IS NULL))
				WHERE (`period`.department_id = ?
				       AND `period`.degree_id = ?
				       AND `period`.semester_id = ?
				       AND `period`.weekday_number = ?
				       AND `period`.period_type_id != "BRK"
				       AND `timetable`.period_id IS NULL)';
		return self::getDefaultAdapter ()->fetchAll ( $sql, array ($department, $degree, $semester, $weekday ) );
	}
	
	/*
	 * Partial Occupied Periods Only
	 *
	public static function partialOccupiedPeriods($department, $degree, $semester, $weekday) {
		$notFullPeriods = self::notFullOccupiedPeriods ( $department, $degree, $semester, $weekday );
		$emptyPeriods = self::emptyPeriods ( $department, $degree, $semester, $weekday );
		return array_diff_assoc ( $notFullPeriods, $emptyPeriods );
	}
	
	/*
	 * Determines if a given period id is completely occupied or not.
	 * return boolean TRUE if period is completly occupied else FALSE
	 *
	public static function isFullOccupied($periodId) {
		$period = Department_Model_DbTable_Period::getIdPeriod ( $periodId );
		$notFullOccupied = self::notFullOccupiedPeriods ( $period ['department_id'], $period ['degree_id'], $period ['semester_id'], $period ['weekday_number'] );
		// NOTE: If you provide any invalid period id, then also it will return FULL so use this fn wisely.
		foreach ( $notFullOccupied as $key => $partialPeriod ) {
			if ($partialPeriod ['pid'] == $periodId) {
				return FALSE;
			}
		}
		return 'FULL';
	}
	
	/*
	 * Determines if a period is partial occupied or not.
	 *
	public static function isPartialOccupied($periodId) {
		$period = Department_Model_DbTable_Period::getIdPeriod ( $periodId );
		$partialPrd = self::partialOccupiedPeriods ( $period ['department_id'], $period ['degree_id'], $period ['semester_id'], $period ['weekday_number'] );
		foreach ( $partialPrd as $key => $partialPeriod ) {
			if ($partialPeriod ['pid'] == $periodId) {
				return 'PARTIAL';
			}
		}
		return FALSE;
	}
	
	/*
     * Determines if a period is partial occupied or not.
     *
	public static function isEmptyPeriod($periodId) {
		$period = Department_Model_DbTable_Period::getIdPeriod ( $periodId );
		$emptyPeriods = self::emptyPeriods ( $period ['department_id'], $period ['degree_id'], $period ['semester_id'], $period ['weekday_number'] );
		foreach ( $emptyPeriods as $key => $emptyPeriod ) {
			if ($emptyPeriod ['pid'] == $periodId) {
				return 'EMPTY';
			}
		}
		return FALSE;
	}
	
	/*
	 * Check if period is covered by any previous period's duration
	 *
	public static function isPeriodCovered($periodId) {
		$period = Department_Model_DbTable_Period::getIdPeriod ( $periodId );
	
	}
	*/


	/*
     * Available group(s) in a partial period only.
     * 
     * Note: For proper result, period should be of PARTIAL status only.
     * @return array
     */
	/*public static function availableGroup($periodId) {
		$periodId = mysql_escape_string ( $periodId );
		$period = Department_Model_DbTable_Period::getIdPeriod ( $periodId );
		$totalgroups = Model_DbTable_Groups::getClassGroups ( $period ['department_id'], $period ['degree_id'] );
		$sql = 'SELECT
                  group_id
                FROM timetable
                WHERE (`timetable`.valid_upto > CURDATE()
                        OR `timetable`.valid_upto IS NULL)
                        AND `timetable`.period_id = ?
                        AND `timetable`.group_id <> "ALL"';
		
		$occupiedGroups = self::getDefaultAdapter ()->fetchAll ( $sql, $periodId );
		return array_diff_assoc ( $totalgroups, $occupiedGroups );
	}
	public function groupPeroidDuration($periodId, $group_id) {
		$sql = $this->select ()->from ( $this->_name, array ('group_id', 'period_duration' ) );
		$sql->where ( "period_id = ?", $periodId );
		$sql->where ( "valid_upto is NULL " );
		
		$first_group = array_shift ( $group_id );
		$first_group = $first_group ['group_id'];
		$grpsql = "(group_id = '$first_group')";
		foreach ( $group_id as $row => $value ) {
			$grpid = $value ['group_id'];
			$grpsql .= " OR (group_id = '$grpid')";
		}
		
		$sql->where ( $grpsql );
		//$sql = 'SELECT  group_id,period_duration FROM timetable WHERE period_id = ? AND valid_upto IS NULL ' ;
		return self::getDefaultAdapter ()->fetchAll ( $sql->__toString () );
	
	}*/
	// OUT OF CLASS
	

	/*///////////////////////////////////////////////All about period//////////////////////////////
 * /*public $dbselect;
	public function init() {
		$this->dbselect = $this->select ();
		parent::init ();
	}*/
	/*public static function getTTidDetails($timetable_id) {
		$sql = 'SELECT
				  timetable.timetable_id,
				  timetable.period_duration,
				  timetable.subject_code,
				  timetable.subject_mode_id,
				  period.period_number,
				  timetable.period_duration,
				  period.department_id,
				  period.degree_id,
				  period.semester_id,
				  subject.subject_name,
				  subject_mode.subject_mode_name
				  FROM timetable
				  INNER JOIN period
				    ON timetable.period_id = period.period_id
				    INNER JOIN SUBJECT ON timetable.subject_code = subject.subject_code
				    INNER JOIN subject_mode ON timetable.subject_mode_id = subject_mode.subject_mode_id
				      AND timetable.timetable_id = ?
				      AND timetable.valid_upto IS NULL';
		return self::getDefaultAdapter ()->fetchAll ( $sql, array ($timetable_id ) );
	}*/
	/*
	 * @return Unique time-table Id
	 * It is not being used I think..... If it is in use then del this comment else this fn after 14 April
	 */
	/*public function getuniquettid($params) {
		
		$sql = $this->select ()->from ( $this->_name, 'timetable_id' );
		
		foreach ( $params as $column => $value ) {
			$sql->where ( "$column = ?", $value );
		}
		
		$stmt = $sql->query ();
		$result = $stmt->fetch ( Zend_Db::FETCH_NUM );
		
		if (1 == count ( $result )) {
			return $result [0];
		} else {
			return false;
		}
	
	}*/
	/*
	 * Hey!! How can this function be getStudentSubject??
	 * Either it is misnamed or it should have student roll etc...
	 */
	/*public static function getStudentSubject($department, $degree, $semester, $group, $subjectType = 'TH') {
		$sql = 'SELECT DISTINCT `timetable`.`department_id`, 
                `timetable`.`degree_id`, 
                `timetable`.`semester_id`, 
                `timetable`.`subject_code`,
                `subject`.`subject_name`
		FROM `timetable` `timetable`
		      INNER JOIN `subject` `subject` ON 
		     (`subject`.`subject_code` = `timetable`.`subject_code`)
		WHERE ( `timetable`.`semester_id` = "' . $semester . '" )
		       AND ( `timetable`.`department_id` = "' . $department . '" )
		       AND ( `timetable`.`degree_id` = "' . $degree . '" )
		       AND ( `timetable`.`group_id` = "' . $group . '")
		       AND ( `subject`.`subject_type_id` = "' . $subjectType . '" )';
		return self::getDefaultAdapter ()->fetchAll ( $sql );
	}*/
	
	/*
	 * Previously written :Subject's Student ( It should return Semester and Group in Array)
	 * 
	 * But strange?? It should return students. Its just returning dept, degree, semester!!
	 */
	/*public function getSubjectStudent($subjectcode) {
		$sql = $this->select ()->distinct ()->from ( $this->_name, array ('department_id', 'degree_id', 'semester_id' ) )->where ( "subject_code = ?", $subjectcode );
		$stmt = $sql->query ();
		return $stmt->fetchAll ();
	}*/