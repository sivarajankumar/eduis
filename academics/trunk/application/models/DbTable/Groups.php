<?php
/**
 * @category   EduIS
 * @package    Core
 * @subpackage Groups
 * @since	   0.1
 */
class Acad_Model_DbTable_Groups extends Acadz_Base_Model
{
    /**
     * Get information about current session.
     * Enter description here ...
     * @throws Zend_Exception
     * @return array Information about current session.
     */
    protected static function fetchGroupInfo ($department, $degree)
    {
        $cache = self::getCache('remote');
        $classGroups = $cache->load('classGroups');
        // see if a cache already exists:
        if ($classGroups === false ||
         ! isset($classGroups[$degree][$department])) {
            $groupsInfoURL = 'http://' . CORE_SERVER . '/groups/getgroup' .
             "?department_id=$department" . "&degree_id=$degree";
            $client = new Zend_Http_Client($groupsInfoURL);
            $client->setCookie('PHPSESSID', $_COOKIE['PHPSESSID']);
            $response = $client->request();
            if ($response->isError()) {
                $remoteErr = 'REMOTE ERROR: (' . $response->getStatus() . ') ' .
                 $response->getMessage();
                throw new Zend_Exception($remoteErr, Zend_Log::ERR);
            } else {
                $jsonContent = $response->getBody();
                $classGroups[$degree][$department] = Zend_Json_Decoder::decode(
                $jsonContent);
                $cache->save($classGroups, 'classGroups');
            }
        } else {
            self::getLogger()->log('classGroups from cache', Zend_Log::INFO);
            self::getLogger()->log($classGroups, Zend_Log::DEBUG);
        }
        return $classGroups[$degree][$department];
    }
    public static function getClassGroups ($department, $degree)
    {
        return self::fetchGroupInfo($department, $degree);
    }
}