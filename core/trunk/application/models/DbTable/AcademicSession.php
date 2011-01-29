<?php
/** 
 * @author Hemant
 * 
 * 
 */
class Core_Model_DbTable_AcademicSession extends Corez_Base_Model
{
    protected $_name = 'academic_session';
    const TABLE_NAME = 'academic_session';
    public static function currentSessionInfo ()
    {
        $cache = self::getCache();
        $acadSession = $cache->load('academicSession');
        // see if a cache already exists:
        if ($acadSession === false) {
            $sql = self::getDefaultAdapter()->select()
                ->from(self::TABLE_NAME, 
            array('semester_type', 'start_date', 'end_date'))
                ->where('CURRENT_DATE() BETWEEN `start_date` AND  `end_date`');
            $acadSession = $sql->query()->fetch();
        }
        return $acadSession;
    }
    public static function currentSessionType ()
    {
        $session = self::currentSessionInfo();
        return $session['semester_type'];
    }
    public static function getSessionStartDate ()
    {
        $session = self::currentSessionInfo();
        return $session['start_date'];
    }
    public static function getSessionEndDate ()
    {
        $session = self::currentSessionInfo();
        return $session['end_date'];
    }
}
?>