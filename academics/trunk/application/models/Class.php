<?php
class Acad_Model_Class
{
    /**
     * Class department
     * @var string
     */
    protected $_department;
    /**
     * Class degree
     * @var string
     */
    protected $_degree;
    /**
     * Semester of class
     * @var int
     */
    protected $_semester;
    /**
     * Batch of class
     * @var int
     */
    protected $_batchStart;
    /**
     * Set class department
     * @param string $department class department
     * @return Acad_Model_Class
     */
    public function setDepartment ($department)
    {
        return $this;
    }
    /**
     * Get class department
     * @return string $department class department
     */
    public function getDepartment ()
    {
        return $this->_department;
    }
    /**
     * Set class degree
     * @param string $degree class degree
     * @return Acad_Model_Class
     */
    public function setDegree ($degree)
    {
        return $this;
    }
    /**
     * Get class degree
     * @return string $degree class degree
     */
    public function getDegree ()
    {
        return $this->_degree;
    }
    /**
     * Set semester of class
     * @param int $semester semester of class
     * @return Acad_Model_Class
     */
    public function setSemester ($semester)
    {
        return $this;
    }
    /**
     * Get semester of class
     * @return int $semester semester of class
     */
    public function getSemester ()
    {
        return $this->_semester;
    }
    /**
     * Set batch of class
     * @param int $batchStart batch of class
     * @return Acad_Model_Class
     */
    public function setBatchStart ($batchStart)
    {
        return $this;
    }
    /**
     * Get batch of class
     * @return int $batchStart batch of class
     */
    public function getBatchStart ()
    {
        if (null === $this->_batchStart) {
            //do smting
        }
        return $this->_batchStart;
    }
    /**
     * Get class students
     * @return array Class students
     */
    public function getStudents ($group = null)
    {
        if (isset($this->_batchStart)) {
            ;
        } elseif (isset($this->_semester)) {
            $this->_students = self::fetchSemesterStudents(
            $this->getDepartment(), $this->getDegree(), $this->getSemester(), 
            $group);
        }
        return $this->_students;
    }
    /**
     * Fetch semester students.
     * @throws Zend_Exception
     * @return array semester students.
     */
    public static function fetchSemesterStudents ($department, $degree, 
    $semester, $group)
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
}
?>