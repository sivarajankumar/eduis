<?php
/**
 * 
 * @author Heavi
 * @since 1.0
 *
 */
class Acad_Model_DbTable_PeriodAttendance extends Aceis_Base_Model {
	protected $_name = 'period_attendance';
	const TABLE_NAME = 'period_attendance';
	
	/**
	 * 
	 * @param $ttids
	 * @param $dateFrom
	 * @param $dateTo
	 * @version 2.0
	 */
	public static function totalLectures($ttids, $dateFrom = NULL, $dateTo = NULL) {
		$sql = self::getDefaultAdapter ()
					->select ()->
					from ( self::TABLE_NAME, 'COUNT(*) as counts' )
					->where ( "marked_date IS NOT NULL" );
		
		if (isset ( $dateFrom ) and isset ( $dateTo )) {
			$sql->where ( 'period_date BETWEEN ? AND ?', $dateFrom, $dateTo );
		} else if (isset ( $dateFrom )) {
			$sql->where ( 'period_date BETWEEN ? AND CURDATE()', $dateFrom );
		}
		$first_ttid = array_shift ( $ttids );
		$ttidsql = "(timetable_id = '$first_ttid')";
		foreach ( $ttids as $row => $value ) {
			$ttidsql .= " OR (timetable_id = '$value')";
		}
		$sql->where ( $ttidsql );
		return $sql->query ()->fetchColumn ();
	}
	
	/**
	 * 
	 * @param unknown_type $ttids
	 * @param unknown_type $dateFrom
	 * @param unknown_type $dateTo
	 * @version 2.0
	 */
	public static function expectedLectures($ttids, $dateFrom = NULL, $dateTo = NULL) {
		$sql = self::getDefaultAdapter ()
					->select ()
					->from ( self::TABLE_NAME, 'COUNT(*) as counts' );
		
		if (isset ( $dateFrom ) and isset ( $dateTo )) {
			$sql->where ( 'period_date BETWEEN ? AND ?', $dateFrom, $dateTo );
		} else if (isset ( $dateFrom )) {
			$sql->where ( 'period_date BETWEEN ? AND CURDATE()', $dateFrom );
		}
		$first_ttid = array_shift ( $ttids );
		$ttidsql = "(timetable_id = '$first_ttid')";
		foreach ( $ttids as $row => $value ) {
			$ttidsql .= " OR (timetable_id = '$value')";
		}
		$sql->where ( $ttidsql );
		return $sql->query ()->fetchColumn ();
	}
	
	public function checkMarked($timetable_arr, $checkdate) {
		$dbselect = $this->select ()->from ( self::TABLE_NAME );
		$ttidsql = " AND (";
		foreach ( $timetable_arr as $key => $value ) {
			$ttidsql = $ttidsql . "  timetable_id = " . $value ['timetable_id'];
			if ($key < count ( $timetable_arr ) - 1)
				$ttidsql = $ttidsql . ' OR ';
		}
		$ttidsql = $ttidsql . ")";
		$dbselect->where ( "period_date = ?", $checkdate );
		$dbselect->where ( "marked_date is not null" );
		$sql = $dbselect->__toString () . $ttidsql;
		
		$resultSet = $this->getAdapter ()->fetchAll ( $sql );
		if (count ( $resultSet ) > 0) {
			return true;
		} else {
			return false;
		}
	
	}
	public function markPeriodAttendance($period_date, $timetable_id, $staff_id, $marked_date) {
		$set = array ('marked_date' => $marked_date, 'staff_id' => $staff_id );
		$where [] = $this->getAdapter ()->quoteInto ( 'period_date = ?', $period_date );
		$where [] = $this->getAdapter ()->quoteInto ( 'timetable_id = ?', $timetable_id );
		$rows_affected = $this->update ( $set, $where );
		return $rows_affected;
	}
	public static function isPeriodExists($period_date, $timetable_id, $staff_id) {
		//$dbselect = self::getDefaultAdapter()->select ()->from ( self::TABLE_NAME );
		//$dbselect->where ( "period_date = ?", $period_date );
		//$dbselect->where ( "timetable_id = ? " ,$timetable_id );
		//$sql = $dbselect->__toString () ;
		//return $sql;
		$sql = self::getDefaultAdapter ()->query ("SELECT * FROM period_attendance WHERE timetable_id = $timetable_id AND period_date = '$period_date'");
		//return $sql->__toString();
		return count($sql->fetchAll());
	}
}