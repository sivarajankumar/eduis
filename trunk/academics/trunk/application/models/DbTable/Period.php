<?php
class Acad_Model_DbTable_Period extends Acadz_Base_Model_Dbtable
{
    protected $_name = 'period';
    /*
     * Get period's Id
     */
    public static function getPeriod ($department, $degree, $semester, 
    $weekday = NULL, $period = NULL, $periodType = 'REG')
    {
        $sql = self::getDefaultAdapter()->select()
            ->from('period', 'period_id')
            ->where('department_id = ?', $department)
            ->where('degree_id = ?', $degree)
            ->where('semester_id = ?', $semester);
        if ($weekday) {
            $sql->where('weekday_number = ?', $weekday);
        } else {
            $sql->columns('weekday_number');
        }
        if (isset($period)) {
            $sql->where('period_number = ?', $period);
        } else {
            $sql->columns('period_number');
        }
        if (isset($periodType)) {
            $sql->where('period_type_id = ?', $periodType);
        }
        return $sql->query()->fetchAll();
    }
    /*
     * Get Id's period
     */
    public static function getIdPeriod ($periodId)
    {
        $sql = self::getDefaultAdapter()->select()
            ->from('period', 
        array('department_id', 'degree_id', 'semester_id', 'weekday_number', 
        'period_number', 'period_type_id'))
            ->where('period_id = ?', $periodId);
        $result = $sql->query()->fetch();
        return $result;
    }
    /*
	//Should not be here, deprecated as $this->_name doesnot have period_date etc.
	public function totalLectures($ttid, $dateFrom = NULL, $dateTo = NULL) {
		$sql = $this->select ()->from ( $this->_name, 'COUNT(*) as counts' );
		
		if (isset ( $dateFrom ) and isset ( $dateTo )) {
			$sql->where ( 'period_date BETWEEN ? AND ?', $dateFrom, $dateTo );
		} else if (isset ( $dateFrom )) {
			$sql->where ( 'period_date BETWEEN ? AND CURDATE()', $dateFrom );
		}
		$first_ttid = array_shift ( $ttid );
		$ttidsql = "(timetable_id = '$first_ttid')";
		foreach ( $ttid as $row => $value ) {
			$ttidsql .= " OR (timetable_id = '$value')";
		}
		$sql->where ( $ttidsql );*/
    /*
		return $this->getAdapter ()->fetchRow ( $sql, '', Zend_Db::FETCH_COLUMN );
	}
	
	//deprecated, there is no timetable_id in $this->_name (see its coding)
	public function checkMarked($timetable_id, $checkdate) {
		$dbselect = $this->select ()->from ( $this->_name );
		$dbselect->where ( "timetable_id = ?", $timetable_id );
		$dbselect->where ( "period_date = ?", $checkdate );
		
		$dbstmt = $dbselect->query ();
		$result = $dbstmt->fetchAll ();
		if (count ( $result ) > 0) {
			return true;
		} else {
			return false;
		}
	
	}*/
    public static function getPeriodId ($department_id, $degree_id, $semester_id, 
    $weekday_number, $period_number)
    {
        $sql = self::getDefaultAdapter()->select()
            ->from('period', 'period_id')
            ->where('department_id = ?', $department_id)
            ->where('degree_id = ?', $degree_id)
            ->where('semester_id = ?', $semester_id)
            ->where('weekday_number = ?', $weekday_number)
            ->where('period_number = ?', $period_number);
        return $sql->query()->fetch();
    }
}