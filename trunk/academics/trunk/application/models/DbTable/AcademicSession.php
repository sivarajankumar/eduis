<?php
/** 
 * @author Hemant
 * 
 * 
 */
class Acad_Model_DbTable_AcademicSession extends Acadz_Base_Model
{
    /**
     * Get information about current session.
     * Enter description here ...
     * @throws Zend_Exception
     * @return array Information about current session.
     */
    public static function fetchSessionInfo ()
    {
        $cache = self::getCache('remote');
        $acadSession = $cache->load('academicSession');
        // see if a cache already exists:
        if ($acadSession === false) {
            $sessionInfoURL = 'http://' . CORE_SERVER . '/session/getsessioninfo';
            $client = new Zend_Http_Client($sessionInfoURL);
            $client->setCookie('PHPSESSID', $_COOKIE['PHPSESSID']);
            $response = $client->request();
            if ($response->isError()) {
                $remoteErr = 'REMOTE ERROR: (' . $response->getStatus() . ') ' .
                 $response->getMessage();
                throw new Zend_Exception($remoteErr, Zend_Log::ERR);
            } else {
                $jsonContent = $response->getBody($response);
                $acadSession = Zend_Json_Decoder::decode($jsonContent);
                $cache->save($acadSession, 'academicSession');
            }
        }
        return $acadSession;
    }
    /**
     * Get semester type of current session. i.e. EVEN or ODD
     */
    public static function currentSessionType ()
    {
        $acadSession = self::fetchSessionInfo();
        return $acadSession['semester_type'];
    }
    /**
     * Get start date of current session semester.
     */
    public static function getSessionStartDate ()
    {
        $acadSession = self::fetchSessionInfo();
        return $acadSession['start_date'];
    }
    /**
     * Get end date of current session semester.
     */
    public static function getSessionEndDate ()
    {
        $acadSession = self::fetchSessionInfo();
        return $acadSession['end_date'];
    }
}
?>