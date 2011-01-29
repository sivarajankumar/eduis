<?php
/**
 * @category   EduIS
 * @package    Core
 * @subpackage Groups
 * @since	   0.1
 */
class Acad_Model_DbTable_SemesterDegree extends Acadz_Base_Model
{
    /**
     * Get information about current session.
     * Enter description here ...
     * @throws Zend_Exception
     * @return array Information about current session.
     */
    protected static function fetchSlaveInfo ($masterDepartment, 
    $currentSession = NULL, $degree = FALSE, $semester = FALSE)
    {
        $cache = self::getCache('remote');
        $slaveDept = $cache->load('slaveDept');
        // see if a cache already exists:
        if ($slaveDept === false || ! isset($slaveDept[$masterDepartment])) {
            $groupsInfoURL = 'http://' . CORE_SERVER .
             '/semesterdegree/getslaveinfo' .
             "?masterDepartment=$masterDepartment" .
             "&currentSession=$currentSession" . "&degree=$degree" .
             "&semseter=$semester";
            $client = new Zend_Http_Client($groupsInfoURL);
            $client->setCookie('PHPSESSID', $_COOKIE['PHPSESSID']);
            $response = $client->request();
            if ($response->isError()) {
                $remoteErr = 'REMOTE ERROR: (' . $response->getStatus() . ') ' .
                 $response->getMessage();
                throw new Zend_Exception($remoteErr, Zend_Log::ERR);
            } else {
                $jsonContent = $response->getBody();
                $slaveDept[$masterDepartment] = Zend_Json_Decoder::decode(
                $jsonContent);
                $cache->save($slaveDept, 'slaveDept');
            }
        } else {
            self::getLogger()->log('$slaveDept from cache', Zend_Log::INFO);
            self::getLogger()->log($slaveDept, Zend_Log::DEBUG);
        }
        return $slaveDept[$masterDepartment];
    }
    /**
     * All slave Department, Degree, Semesters
     */
    public static function slaveInfo ($masterDepartment, $currentSession = NULL, 
    $degree = FALSE, $semester = FALSE)
    {
        return self::fetchSlaveInfo($masterDepartment, $currentSession = NULL, 
        $degree = FALSE, $semester = FALSE);
    }
}