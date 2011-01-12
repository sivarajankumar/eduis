<?php
/** 
 * @author Hemant
 * 
 * 
 */
class Core_Model_DbTable_AcademicSession extends Corez_Base_Model {
	protected $_name = 'academic_session';

	public static function currentSessionType() {
		$sql = self::getDefaultAdapter()->select()
		              ->from('academic_session', 'semester_type')
		              ->where('CURRENT_DATE() BETWEEN `start_date` AND  `end_date`');
		return $sql->query()->fetchColumn();
	}
	
	public static function getSessionStartDate()
	{
		$sql = self::getDefaultAdapter()->select()
		              ->from('academic_session', 'start_date')
		              ->where('CURRENT_DATE() BETWEEN `start_date` AND  `end_date`');
		return $sql->query()->fetchColumn();
	}
	
	public static function getSessionEndDate()
	{
		$sql = self::getDefaultAdapter()->select()
		              ->from('academic_session', 'end_date')
		              ->where('CURRENT_DATE() BETWEEN `start_date` AND  `end_date`');
		return $sql->query()->fetchColumn();
	}


}

?>