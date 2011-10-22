<?php
/**
 * Subject Mapper
 *
 * Data Mapper pattern to persist data.
 * 
 */
class Acad_Model_Course_SubjectMapper
{
    /**
     * @var Acad_Model_DbTable_Subject
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Acad_Model_DbTable_Subject $dbTable 
     * @return Acad_Model_Course_SubjectMapper
     */
    public function setDbTable ($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (! $dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Zend_Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    /**
     * Get registered Zend_Db_Table instance
     *
     * Lazy loads Acad_Model_DbTable_Subject if no instance registered
     * 
     * @return Acad_Model_DbTable_Subject
     */
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Acad_Model_DbTable_Subject');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches possible modes of subject.
     * 
     * @param Acad_Model_Course_Subject $subject
     */
    public function getSubjectModes (Acad_Model_Course_Subject $subject)
    {
        $sql = $this->getDbTable()
            ->getAdapter()
            ->select()
            ->from('subject_mode', 'subject_mode_id')
            ->join('subject', 
        'subject.subject_type_id = subject_mode.subject_type_id', 
        array())
            ->where('subject_code = ?', $subject->getSubject_code());
            
        return $sql->query()->fetchAll(Zend_Db::FETCH_COLUMN);
    }
    /**
     * Fetches only those semesters in which subject is taught
     * 
     * @param Acad_Model_Course_Subject $subject
     * @return array of department,degree,semester in which subject is taught
     */
    public function getSemesters (Acad_Model_Course_Subject $subject)
    {
        $sql = $this->getDbTable()
            ->select()
            ->from(`subject_department`, 
        array('department_id', 'degree_id', 'semester_id'))
            ->where('subject_code = ?', $subject->getCode());
        return $sql->query()->fetchAll();
    }
    /**
     * Fetches Faculty members who are assigned the subject
     * 
     * @param Acad_Model_Course_Subject $subject
     * @return array of department,degree,semester,faculty id,mode in which subject is taught
     */
    public function getFaculties (Acad_Model_Course_Subject $subject)
    {
        $sql = $this->getDbTable()
            ->select()
            ->from(`subject_department`, 
        array('department_id', 'degree_id', 'semester_id'))
            ->join('subject_faculty', 
        '(`subject_faculty`.`department_id` = `subject_department`.`department_id`)
        AND (`subject_faculty`.`subject_code` = `subject_department`.`subject_code`)', 
        array('`staff_id`', '`subject_mode_id`'))
            ->where('`subject_code` = ?', $subject->getCode());
        return $sql->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
    }
    public function fetchTest (Acad_Model_Course_Subject $subject, 
    $locked = FALSE)
    {
        $select = $this->getDbTable()
            ->getAdapter()
            ->select()
            ->from('test_info', 
        array('test_info_id', 'degree_id', 'semester_id', 'test_id'))
            ->join('test_type', 
        '`test_info`.`test_type_id` = `test_type`.`test_type_id`')
            ->where('`test_info`.`department_id` = ?', 
        $subject->getDepartment())
            ->where('`test_info`.`subject_code` = ?', 
        $subject->getSubject_code());
        if ($locked) {
            $select->where('`test_info`.`is_locked` = 1');
        } else {
            $select->where('`test_info`.`is_locked` = 0');
            ;
        }
        /*$sql = 'SELECT
        `test_info`.`test_info_id`,
        `test_info`.`degree_id`,
        `test_info`.`semester_id`,
        `test_info`.`test_id`,
        `test_type`.`test_type_id`,
        `test_type`.`test_type_name`
        FROM `test_info`
        INNER JOIN `test_type`
        ON (`test_info`.`test_type_id` = `test_type`.`test_type_id`)
        WHERE (`test_info`.`department_id` = ?
        AND `test_info`.`subject_code` = ? )
        AND `test_info`.`is_locked` = 0';
        $data=array ($subject->getDepartment(),$subject->getSubject_code());
        $result = Zend_Db_Table::getDefaultAdapter()->query($sql,$data)->fetchAll();*/
        return $select->query()->fetchAll();
    }
    public function fetchLocked (Acad_Model_Course_Subject $subject)
    {
        $sql = 'SELECT
        `test_info`.`test_info_id`,
        `test_info`.`degree_id`,
        `test_info`.`semester_id`,
        `test_info`.`test_id`,
        `test_type`.`test_type_id`,
        `test_type`.`test_type_name`
        FROM `test_info`
        INNER JOIN `test_type`
        ON (`test_info`.`test_type_id` = `test_type`.`test_type_id`)
        WHERE (`test_info`.`department_id` = ?
        AND `test_info`.`subject_code` = ? )
        AND `test_info`.`is_locked` = 1';
        $data = array($subject->getDepartment(), $subject->getSubject_code());
        $result = Zend_Db_Table::getDefaultAdapter()->query($sql, $data)->fetchAll();
        return $result;
    }
    /**
     * Total delievered, total duration, corrosponding groups and modes.
     * 
     * @param Acad_Model_Course_Subject $subject
     * @param date|Zend_date $dateFrom
     * @param date|Zend_date $dateUpto
     * @return array mode-wise attendanceTotal
     * @throws Exception If subject code not available.
     */
    public function fetchAttendanceTotal (Acad_Model_Course_Subject $subject, 
    $dateFrom = NULL, $dateUpto = NULL, $group_id = NULL)
    {
        $subject_code = $subject->getSubject_code();
        $department = $subject->getDepartment();
        $groupByCols = array('department_id',
            				'programme_id',
            				'semester_id',
            				'group_id',
            				'subject_code',
            				'subject_mode_id');
        
        $select = $this->getDbTable()
            ->getAdapter()
            ->select();
        $select->from('period_attendance2', 
        array('subject_mode_id', 
        'delievered' => 'COUNT(attendance_id)', 
        'total_duration' => 'SUM(duration)'))
            ->where('subject_code = ?', $subject_code)
            ->group($groupByCols);
        if ($department) {
            $select->where('department_id = ?', $department);
        }
        if ($dateFrom) {
            $select->where('period_date >= ?', $dateFrom);
        }
        if ($dateUpto) {
            $select->where('period_date <= ?', $dateUpto);
        }
        if ($group_id) {
            $select->where('group_id = ?', $group_id);
        } else {
            $select->columns('group_id');
        }
        
        $modeString = self::_subjectModeQuery($subject);
        $select->where($modeString);
        
        //Zend_Registry::get('logger')->debug($select->__toString());
        $dbResult = $select->query()->fetchAll(Zend_Db::FETCH_GROUP);
        
        /**
         * Data is required to be in understandable format.
         * @var array
         */
        $processedResult = array();
        foreach ($dbResult as $subjectMode => $groups) {
            foreach ($groups as $key => $group) {
                $gid = $group['group_id'];
                $processedResult[$subjectMode][$gid] = array_diff_key($group, 
                                                                array('group_id'=>'dummy'));
            }
            
        }
        return $processedResult;
    }
    /**
     * 
     * Enter description here ...
     * @param Acad_Model_Course_Subject $subject
     * @param unknown_type $dateFrom
     * @param unknown_type $dateUpto
     * @param unknown_type $status
     * @param unknown_type $group_id
     * @param unknown_type $subject_mode_id
     */
    public function fetchStudentAttendance (Acad_Model_Course_Subject $subject, 
    $dateFrom = NULL, $dateUpto = NULL, $status = NULL, $group_id = NULL)
    {
        $subject_code = $subject->getSubject_code();
        $department = $subject->getDepartment();
        $groupByCols = array('department_id',
            				'programme_id',
            				'semester_id',
            				'group_id',
            				'subject_code',
            				'subject_mode_id',
                            'student_roll_no');
        
        $select = $this->getDbTable()
            ->getAdapter()
            ->select()
            ->from('vw_student_attendance', 
                    array('subject_mode_id', 'student_roll_no', 'status',
                    'counts' => 'COUNT(student_roll_no)'))
            ->where('subject_code = ?', $subject_code)
            ->group($groupByCols)
            ->group('status');
            
        if ($department) {
            $select->where('department_id = ?', $department);
        }
        if ($dateFrom) {
            $select->where('period_date >= ?', $dateFrom);
        }
        if ($dateUpto) {
            $select->where('period_date <= ?', $dateUpto);
        }
        if ($status) {
            $select->where('status = ?', $status);
        }
        if ($group_id) {
            $select->where('group_id = ?', $group_id);
        } else {
            $select->columns('group_id');
        }
        
        $modeString = self::_subjectModeQuery($subject);
        $select->where($modeString);
        
        return $select->query()->fetchAll(Zend_Db::FETCH_GROUP);
    }
    
    /**
     * Just an shortcut to insert available modes in where query.
     * As it is being used multiple times.
     * @param Acad_Model_Course_Subject $subject
     * @return string
     */
    protected function _subjectModeQuery (Acad_Model_Course_Subject $subject)
    {
        $subject_modes = $subject->getModes();
        $orArray = NULL;
        foreach ($subject_modes as $key => $subject_mode) {
            $orArray[] = "(subject_mode_id = '$subject_mode')";
        }
        
        return implode(' OR ', $orArray);
    }
}
?>