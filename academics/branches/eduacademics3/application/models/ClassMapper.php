<?php
class Acad_Model_ClassMapper
{
    /**
     * @var Acadz_Base_Model
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * @param  Acadz_Base_Model $dbTable 
     * @return Acad_Model_ClassMapper
     */
    public function setDbTable ($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (! $dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    /**
     * Get registered Zend_Db_Table instance
     *
     * Lazy loads Acadz_Base_Model if no instance registered
     * As there no corrosponding DbTable so base model is used.
     * @return Acadz_Base_Model
     */
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Acadz_Base_Model');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches Subject Codes of a class
     * 
     * @param Acad_Model_Class $class
     * @param string $subjectType
     * @param string $subjectMode
     * 
     */
    public function getSubjects (Acad_Model_Class $class, $subjectType = null, 
    $subjectMode = null)
    {
        $sql = $this->getDbTable()
            ->getAdapter()
            ->select()
            ->from('subject_department', array())
            ->join('subject', 
        '`subject_department`.`subject_code` = `subject`.`subject_code`', 
        array('subject_code', 'subject_name', 'suggested_duration'))
            ->join('subject_mode', 
        '`subject`.`subject_type_id` = `subject_mode`.`subject_type_id`', 
        array('group_together'))
            ->where('department_id = ?', $class->getDepartment())
            ->where('degree_id = ?', $class->getDegree())
            ->where('semester_id = ?', $class->getSemester());
        if (isset($subjectType)) {
            $sql->where('`subject_mode`.`subject_type_id` = ?', $subjectType);
        } else {
            $sql->columns('subject_mode`.`subject_type_id');
        }
        if (isset($subjectMode)) {
            $sql->where('subject_mode_id = ?', $subjectMode);
        } else {
            $sql->columns('subject_mode.subject_mode_id');
        }
        return $sql->query()->fetchAll();
    }
    /**
     * Fetch class students from core server.
     * 
     * @param Acad_Model_Class $class
     * @param string $group that belongs to class.
     * @throws Exception
     * @return array class students.
     */
    public static function fetchSemesterStudents (Acad_Model_Class $class, 
    $group)
    {
        $department = $class->getDepartment();
        $degree = $class->getDegree();
        $semester = $class->getSemester();
        $cacheManager = Zend_Registry::get('cacheManager');
        $cache = $cacheManager->getCache('remote');
        if (isset($group)) {
            $stuCache = strtolower($department . $degree . $semester . $group);
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
                throw new Exception($remoteErr, Zend_Log::ERR);
            } else {
                $jsonContent = $response->getBody();
                $students = Zend_Json_Decoder::decode($jsonContent);
                $cache->save($students, $stuCache);
            }
        }
        return $students;
    }
    /**
     * Get Attendance status of class in detail
     * 
     * @param Acad_Model_Class $class
     * @param string $subjectCode
     * @param string $subjectMode
     * @param date $dateFrom
     * @param date $dateUpto
     * @param string $subjectType
     */
    public function getAttendanceDetail (Acad_Model_Class $class, 
    $subjectType = null, $subjectMode = null, $dateFrom = null, $dateUpto = null)
    {
        $data = array();
        $sql = $this->getDbTable()
            ->getAdapter()
            ->select();
        $fetchMode = null;
        $subjects = $class->getSubjects($subjectType, $subjectMode);
        $where = '';
        $setOr = false;
        foreach ($subjects as $key => $subject) {
            if ($setOr) {
                $where .= ' OR ';
            }
            $setAnd = false;
            $where .= ' ( ';
            $selCol = array('subject_code' => 1, 'department_id' => 2);
            $subject = array_diff_key($subject, $selCol);
            foreach ($subject as $column => $value) {
                if ($setAnd) {
                    $where .= ' AND ';
                }
                $where .= $this->model->getAdapter()->quoteInto("$column = ?", 
                $value);
                $setAnd = true;
            }
            $where .= ' ) ';
            $setOr = true;
        }
        $sql->from('attendance', 
        array('period_date', 'subject_mode_id', 'group_id', 'student_roll_no'))->where(
        $where);
        //@TODO do smthing
        if ($dateFrom != null) {
            $data['dateFrom'] = $dateFrom;
            if ($dateUpto != null) {
                $data['dateUpto'] = $dateUpto;
                $sql->where('`period_date` BETWEEN :dateFrom AND :dateUpto');
            } else {
                $sql->where('`period_date` = :dateFrom');
            }
        }
        return $sql->query(null, $data)->fetchAll($fetchMode);
    }
    /**
     * 
     * Get Attendance status of class in a subject
     * 
     * @param Acad_Model_Class $class
     * @param string $subjectCode
     * @param string $subjectMode
     * @param date $dateFrom
     * @param date $dateUpto
     * @param string $subjectType
     */
    public function getSubjectAttendanceDetail (Acad_Model_Class $class, 
    $subjectCode, $subjectMode = null, $dateFrom = null, $dateUpto = null)
    {
        $data = array();
        $sql = $this->getDbTable()
            ->getAdapter()
            ->select();
        $fetchMode = null;
        if ($subjectCode != null) {
            $sql->from('attendance', 
            array('period_date', 'subject_mode_id', 'group_id', 
            'student_roll_no'))
                ->where('subject_code = ?', $subjectCode)
                ->where('department_id = ?', $class->getDepartment());
            $fetchMode = Zend_db::FETCH_GROUP;
        } else {
            $subjects = $class->getSubjects();
            $sql->from('attendance', 
            array('period_date', 'subject_mode_id', 'group_id', 
            'student_roll_no'));
            foreach ($subjects as $key => $subject) {
                $sql->where('subject_code = ?', $subjectCode)->where(
                'department_id = ?', $class->getDepartment());
            }
             //@TODO do smthing
        }
        if ($dateFrom != null) {
            $data['dateFrom'] = $dateFrom;
            if ($dateUpto != null) {
                $data['dateUpto'] = $dateUpto;
                $sql->where('`period_date` BETWEEN :dateFrom AND :dateUpto');
            } else {
                $sql->where('`period_date` = :dateFrom');
            }
        }
        return $sql->query(null, $data)->fetchAll($fetchMode);
    }
    
    public function getUnmarkedAttendance (Acad_Model_Class $class)
    {
        $sql = 'SELECT
  totalprd.*,
  unmarked.pending
FROM (SELECT
        staff_id,
        subject_name,
        subject_mode_name,
        department_id,
        degree_id,
        semester_id,
        COUNT(1)          AS total
      FROM periodinfo
      GROUP BY staff_id,subject_code,subject_mode_id) AS totalprd
  JOIN (SELECT
          staff_id,
          subject_name,
          subject_mode_name,
          department_id,
          degree_id,
          semester_id,
          COUNT(1)          AS pending
        FROM unmarkedattendance
        GROUP BY staff_id,subject_code,subject_mode_id) AS unmarked
    ON (totalprd.staff_id = unmarked.staff_id
        AND totalprd.subject_name = unmarked.subject_name
        AND totalprd.subject_mode_name = unmarked.subject_mode_name
        AND totalprd.department_id = unmarked.department_id
        AND totalprd.degree_id = unmarked.degree_id
        AND totalprd.semester_id = unmarked.semester_id)
WHERE totalprd.department_id = ?
    AND totalprd.degree_id = ?
    AND totalprd.semester_id = ?';
        $bind = array($class->getDepartment(),
                        $class->getDegree(), 
                        $class->getSemester());
                        
        return $this->getDbTable()->getAdapter()->query($sql,$bind)->fetchAll();
    }
    
    public function fetchFaculties(Acad_Model_Class $class) {
        $sql = 'SELECT
                  `subject_faculty`.`staff_id`,
                  `subject_department`.`subject_code`,
                  `subject_faculty`.`subject_mode_id`,
                  `subject`.`subject_name`,
                  `subject`.`subject_type_id`
                FROM `academics`.`subject_faculty`
                  INNER JOIN `academics`.`subject_department`
                    ON (`subject_faculty`.`department_id` = `subject_department`.`department_id`)
                  INNER JOIN `academics`.`subject`
                    ON (`subject_department`.`subject_code` = `subject`.`subject_code`)
                      AND (`subject_faculty`.`subject_code` = `subject`.`subject_code`)
                WHERE (`subject_department`.`department_id` = ?
                       AND `subject_department`.`degree_id` = ?
                       AND `subject_department`.`semester_id` = ?)';
        
        $bind = array($class->getDepartment(),
                        $class->getDegree(), 
                        $class->getSemester());
                        
                      
        return $this->getDbTable()->getAdapter()->query($sql,$bind)->fetchAll(Zend_Db::FETCH_GROUP);
    }
    /**
     * 
     * Enter description here ...
     * @param Acad_Model_Class $class
     * @FIXME It is not complete
     */
    public function save (Acad_Model_Class $class)
    {
        $data = array('department_id' => $class->getDepartment(), 
        'degree_id' => $class->getDegree(), 
        'batchstart' => $class->getBatchStart());
    }
}