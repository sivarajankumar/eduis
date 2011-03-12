<?php
class Acad_Model_ClassMapper
{
      /*
	 * Fetches Subject Codes of a class
	 */
    public static function getSubjects ($department, $degree, $semester, 
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
        if (isset($subjectType)) {
                $sql .= ' AND (`sub`.subject_type_id = ?)';
                $data[] = $subjectType;
            }
            $sql .= ' ORDER BY `subject_name` ASC';
        return self::getDefaultAdapter()->fetchAll($sql, $data, Zend_Db::FETCH_GROUP);
    }
    
    /**
     * Fetch semester students.
     * @throws Zend_Exception
     * @return array semester students.
     */
    public static function fetchSemesterStudents ($department, $degree, $semester, $group)
    {
        
        $cacheManager = Zend_Registry::get('cacheManager');
        $cache = $cacheManager->getCache('remote');
        
        if (isset($group)) {
            $stuCache = strtolower($department . $degree . $semester.$group);
        } else {
            $stuCache = strtolower($department . $degree . $semester);
        }
        $students = $cache->load($stuCache);
        // see if a cache already exists:
        if ($students === false) {
            $semesterStuURL = 'http://' . CORE_SERVER . '/semester/getstudents';
            $client = new Zend_Http_Client($semesterStuURL);
            $client->setCookie('PHPSESSID', $_COOKIE['PHPSESSID'])
                ->setParameterGet('department_id', $department)
                ->setParameterGet('degree_id', $degree)
                ->setParameterGet('semester_id', $semester);
            if (isset($group)) {
                $client->setParameterGet('group_id', $group);
            }
            $response = $client->request();
            if ($response->isError()) {
                $remoteErr = 'REMOTE ERROR: (' . $response->getStatus() . ') ' .
                 $response->getMessage();
                throw new Zend_Exception($remoteErr, Zend_Log::ERR);
            } else {
                $jsonContent = $response->getBody();
                $students = Zend_Json_Decoder::decode($jsonContent);
                $cache->save($students, $stuCache);
            }
        }
        return $students;
    }
    
    
    public static function getMinMarks()
    {
        
    }
    public static function getMaxMarks()
    {
        
    }
 public function save(Acad_Model_Class $class)
    {
        $data = array(
        'department_id'=>$class->getDepartment(),
        'degree_id' =>$class->getDegree(),
        'batchstart'=>$class->getBatchStart ()
        );
    }
}