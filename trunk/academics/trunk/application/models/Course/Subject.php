<?php
/**
 * Subject model
 *
 * Utilizes the Data Mapper pattern to persist data. Represents a single 
 * subject.
 * 
 * @uses       Acad_Model_SubjectMapper
 */
class Acad_Model_Course_Subject
{
    /**
     * Subject code
     * @var string
     */
    protected $_subject_code;
    /**
     * Subject name
     * @var string
     */
    protected $_subject_name;
    /**
     * Subject department
     * @var string
     */
    protected $_department;
    /**
     * Subject Mode(s)
     * @example LEC: Lecture | TUT: Tutorial | PRC: Practical
     * @var array
     */
    protected $_modes;
    /**
     * Class/Semester in which subject is taught
     * @var array
     */
    protected $_semester;
    /**
     * Class/semester wise subject faculty and corresponding mode
     * @var array
     */
    protected $_faculty;
    /**
     * Subject Mapper
     * @var Acad_Model_Course_SubjectMapper
     */
    protected $_mapper;
    /**
     * A whole set of student attendance related to subject.
     * @var array
     */
    protected $_studentAttendance;
    /**
     * A total attendance related to subject.
     * @var array
     */
    protected $_totalAttendance;
    /**
     * Processed attentdance result.
     * Summary or abstract of attendance.
     * @var unknown_type
     */
    protected $_attendanceStat;
    /**
     * Set Subject Mapper
     * @param Acad_Model_Course_SubjectMapper $mapper - Subject Mapper
     * @return Acad_Model_Test_Sessional
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * Get Subject Mapper
     * @return Acad_Model_Course_SubjectMapper $mapper - Subject Mapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Course_SubjectMapper());
        }
        return $this->_mapper;
    }
    /**
     * Set subject code
     * @param string $code subject code
     * @return Acad_Model_Course_Subject
     */
    public function setSubject_code ($subject_code)
    {
        $this->_subject_code = $subject_code;
        return $this;
    }
    /**
     * Get subject code
     * @return string $code subject code
     */
    public function getSubject_code ()
    {
        if (empty($this->_subject_code)) {
            throw new Exception('Subject code is required!!', Zend_Log::ERR);
        }
        return $this->_subject_code;
    }
    /**
     * Set subject department
     * @param string $department - subject department
     * @return Acad_Model_Course_Subject
     */
    public function setDepartment ($department = null)
    {
        if ($department != null) {
            $this->_department = $department;
        } elseif (Zend_Auth::getInstance()->hasIdentity()) {
            $authInfo = Zend_Auth::getInstance()->getStorage()->read();
            $this->_department = $authInfo['department_id'];
        } else {
            throw new Zend_Exception('Could not determine department', 
            Zend_Log::ERR);
        }
        return $this;
    }
    /**
     * Get department
     * @return string $department - department
     */
    public function getDepartment ()
    {
        if (! $this->_department) {
            $this->setDepartment();
        }
        return $this->_department;
    }
    /**
     * Set possible modes of subject.
     * @param array $modes subject modes
     * @example array('LEC','TUT') or array('PRC')
     * @return Acad_Model_Course_Subject
     */
    public function setModes ($modes = NULL)
    {
        if (! empty($modes)) {
            if (!is_array($modes)) {
                $modes = array($modes);
            }
            $this->_modes = $modes;
        } else {
            $this->_modes = $this->getMapper()->getSubjectModes($this);
        }
        
        return $this;
    }
    /**
     * Get subject modes
     * @return array $modes subject modes
     */
    public function getModes ()
    {
        if (null === $this->_modes) {
            $this->setModes();
        }
        return $this->_modes;
    }
    /**
     * Set Class/Semester in which subject is taught
     * @param array $semester Class/Semester in which subject is taught
     * @return Acad_Model_Course_Subject
     */
    public function setSemester ()
    {
        $this->_semester = $this->getMapper()->getSemesters($this);
        return $this;
    }
    /**
     * Get class/semester in which subject is taught
     * @return array $semester class/semester in which subject is taught
     */
    public function getSemester ()
    {
        if (null === $this->_semester) {
            $this->setSemester();
        }
        return $this->_semester;
    }
    /**
     * Set class/semester wise faculty of subject and corresponding mode.
     * If no faculty is provided then it will try to fetch faculties from subject_faculty.
     * @param array $faculty class/semester wise faculty of subject and corresponding mode
     * @return Acad_Model_Course_Subject
     */
    public function setFaculty (array $faculty = NULL)
    {
        if (! empty($faculty)) {
            $this->_faculty = $faculty;
        } else {
            $this->_faculty = $this->getMapper()->getFaculties($this);
        }
        return $this;
    }
    /**
     * Get class/semester wise faculty of subject and corresponding mode of subject.
     * @return array $faculty class/semester wise faculty of subject and corresponding mode of subject.
     */
    public function getFaculty ()
    {
        if (null === $this->_faculty) {
            $this->setFaculty();
        }
        return $this->_faculty;
    }
    /**
     * Fetches all tests etc related to subject
     */
    public function getTest ($locked = FALSE)
    {
        return $this->getMapper()->fetchTest($this, $locked);
    }
    /**
     * Total delievered, total duration, corrosponding groups and modes.
     * 
     * @param date $dateFrom
     * @param date $dateUpto
     */
    public function getAttendanceTotal ($dateFrom = NULL, $dateUpto = NULL, 
    $group_id = NULL, $forceUpdate = FALSE)
    {
        if (empty($this->_totalAttendance) or $forceUpdate) {
            $this->_totalAttendance = $this->getMapper()->fetchAttendanceTotal($this, $dateFrom, 
            $dateUpto, $group_id);
        }
        return $this->_totalAttendance;
    }
    /**
     * Attendance of students enrolled in subject.
     * The detailed attendance of students. By default, it will return ABSENT count in <i>counts</i>
     * @param date $dateFrom
     * @param date $dateUpto
     */
    public function getStudentAttendance ($dateFrom = NULL, $dateUpto = NULL, 
    $status_id = NULL, $group_id = NULL, $forceUpdate = FALSE)
    {
        $rawAttendance = array();
        if (empty($this->_studentAttendance) or $forceUpdate) {
            $rawAttendance = $this->getMapper()
                        ->fetchStudentAttendance($this, $dateFrom, $dateUpto, 
                                                $status_id, $group_id);
                                                
        
            foreach ($rawAttendance as $subject_mode => $studentsList) {
                foreach ($studentsList as $key => $student) {
                    $group = isset($student['group_id'])?$student['group_id']:$group_id;
                    $status = $student['status'];
                    $roll = $student['student_roll_no'];
                    $this->_studentAttendance[$subject_mode][$group][$roll][$status] = $student['counts'];
                }
            }
        }
    
        return $this->_studentAttendance;
    }
    /**
     * Total number of students enrolled in subject and their average attendance percentage.
     * 
     * @param date $dateFrom
     * @param date $dateUpto
     */
    public function getStudentAttendanceStat ($dateFrom = NULL, $dateUpto = NULL, $status = NULL, 
                                                $group_id = NULL)
    {
        if (empty($this->_studentAttendance)) {
            self::getStudentAttendance($dateFrom, $dateUpto, 
                                        $status, $group_id);
        }
        
        if (empty($this->_totalAttendance)) {
            self::getStudentAttendance ($dateFrom, $dateUpto, 
                                        $status, $group_id);
        }
        $this->_attendanceStat = $this->_totalAttendance;
        foreach ($this->_studentAttendance as $subject_mode => $groups) {
            foreach ($groups as $group => $students) {
                $stuCount = count($students);
                $avg = array();
                foreach ($students as $roll => $records) {
                    foreach ($records as $stuStatus => $counts) {
                        if (!isset($avg[$stuStatus]['counts'])) {
                            $avg[$stuStatus]['counts'] = 0;
                        }
                        $avg[$stuStatus]['counts'] = $avg[$stuStatus]['counts']+$counts;
                    }
                }
                /**
                 * @todo The STUDENTS should be the students enrolled to the subject.
                 * So it should call $this->studentsEnrolled($subject_mode, $group)
                 */
                $this->_attendanceStat[$subject_mode][$group]['STUDENTS']=$stuCount;
                foreach ($avg as $stuStatus => $counts) {
                    $this->_attendanceStat[$subject_mode][$group]['AVERAGE'][$stuStatus] = 
                                                        round($counts['counts']/$stuCount);
                }
            }
        }
        return $this->_attendanceStat;
    }
    /**
     * Students enrolled in a subject.
     * 
     * @param year $sessionYear
     */
    public function studentsEnrolled($subject_mode = NULL, $group = NULL, $sessionYear = NULL) {
        ;
    }
}
?>