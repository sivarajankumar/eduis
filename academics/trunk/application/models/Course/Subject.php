<?php
/**
 * Subject model
 *
 * Utilizes the Data Mapper pattern to persist data. Represents a single 
 * subject.
 * 
 * @uses       Acad_Model_SubjectMapper
 */
class Acad_Model_Course_Subject extends Acadz_Base_Model
{
    
     const PASS = 'pass';
     const AVERAGE = 'average';
     const FAIL = 'fail';
     
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
     * Processed attentdance result from db.
     * Data for summary of attendance.
     * @var array
     */
    protected $_attendanceStat;
    
    /**
     * Processed attentdance result.
     * Summary or abstract of attendance.
     * @var unknown_type
     */
    protected $_summary;
    
    /**
     * Student wise Processed attentdance result.
     * Student wise Summary or abstract of attendance in each mode.
     * @var unknown_type
     */
    protected $_stuModeWiseAtt;
    
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
	 * @return $_subject_name
	 */
	public function getSubject_name() {
	    if (!isset($this->_subject_name)) {
	        $this->setSubject_name();
	    }
	    return $this->_subject_name;
	}

	/**
	 * @param string $_subject_name
	 */
	public function setSubject_name($_subject_name = NULL) {
	    if ($_subject_name != NULL) {
		    $this->_subject_name = $_subject_name;
	    } else {
	        $this->_subject_name = $this->getMapper()->getSubjectName($this);
	    }
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
    public function setFaculty (array $faculty = NULL,$dateFrom = NULL, $dateUpto = NULL)
    {
        if (! empty($faculty)) {
            $this->_faculty = $faculty;
        } else {
            $this->_faculty = $this->getMapper()->getFaculties($this,$dateFrom, $dateUpto);
        }
        return $this;
    }
    /**
     * Get class/semester wise faculty of subject and corresponding mode of subject.
     * @return array $faculty class/semester wise faculty of subject and corresponding mode of subject.
     * @param date $dateFrom - faculty teaching the subject from given date
     * @param date $dateUpto - faculty teaching the subject upto given date
     */
    public function getFaculty ($dateFrom = NULL, $dateUpto = NULL)
    {
        if (null === $this->_faculty) {
            $this->setFaculty(NULL,$dateFrom, $dateUpto);
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
    $status_id = NULL, $group_id = NULL, $minPercentage = NULL, $maxPercentage = NULL,$forceUpdate = FALSE)
    {
        $rawAttendance = array();
    
        self::getAttendanceTotal($dateFrom, $dateUpto, $group_id, $forceUpdate);
    
        $maxAbsent = $minAbsent = null;
        foreach ($this->_totalAttendance as $subjectMode => $group) {
            foreach ($group as $group => $delieveredInGroup) {
                    $delievered = $delieveredInGroup['delievered'];
                if (isset($minPercentage)) {
                    $maxAbsent = ((100- $minPercentage)/100)*$delievered;
                    //$this->getLogger()->debug('$maxAbsent: '.$minPercentage.'% of '.$delievered.' is '.$maxAbsent.' in '.$subjectMode);
                    
                }
            
                if (isset($maxPercentage)) {
                    $minAbsent = ((100- $maxPercentage)/100)*$delievered;
                    //$this->getLogger()->debug('$minAbsent: '.$maxPercentage.'% of '.$delievered.' is '.$maxAbsent.' in '.$subjectMode);
                }
                
                $subjectModeWiseResult = $this->getMapper()
                    ->fetchStudentAttendance($this, $dateFrom, $dateUpto, 
                                            $status_id, $group_id, $maxAbsent,$minAbsent,$subjectMode);
                $rawAttendance[$subjectMode] = isset($subjectModeWiseResult[$subjectMode])?$subjectModeWiseResult[$subjectMode]:array();
            }
        }
        
        //$this->getLogger()->info('raw attendance');
        //$this->getLogger()->debug($rawAttendance);
        if (empty($this->_studentAttendance) or $forceUpdate) {
            
            
            
            foreach ($rawAttendance as $subjectMode => $studentsList) {
                foreach ($studentsList as $key => $student) {
                    $group = isset($student['group_id'])?$student['group_id']:$group_id;
                    $status = $student['status'];
                    $roll = $student['student_roll_no'];
                    $this->_studentAttendance[$subjectMode][$group][$roll][$status] = $student['counts'];
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
    public function getStudentAttendanceStat ()
    {
        if (isset($this->_attendanceStat)) {
            return $this->_attendanceStat;
        }
        if (NULL === $this->_totalAttendance) {
            throw new Exception('Subject attendance is not set.(Hint: call getAttendanceTotal() first.)', Zend_Log::DEBUG);
        }
        
        $this->_attendanceStat = $this->_totalAttendance;
        
        if (!empty($this->_studentAttendance)) {
            foreach ($this->_studentAttendance as $subject_mode => $groups) {
                foreach ($groups as $group => $students) {
                    $stuCount = count($students);
                    $avg = array();
                    foreach ($students as $roll => $records) {
                        foreach ($records as $stuStatus => $counts) {
                            if (!isset($avg[$stuStatus]['counts'])) {
                                $avg[$stuStatus]['counts'] = 0;
                            }
                            $avg[$stuStatus]['counts'] += $counts;
                        }
                    }
                    /**
                     * @todo The STUDENTS should be the number of students enrolled to the subject.
                     * So it should call $this->studentsEnrolled($subject_mode, $group)
                     */
                    $this->_attendanceStat[$subject_mode][$group]['STUDENTS']=$stuCount;
                    foreach ($avg as $stuStatus => $counts) {
                        $this->_attendanceStat[$subject_mode][$group]['AVERAGE'][$stuStatus] = 
                                                            round($counts['counts']/$stuCount);
                    }
                }
            }
        } else {
            $this->getLogger()->debug('Student attendance is empty.(Hint: call getStudentAttendance() first.)');
        }
        
        return $this->_attendanceStat;
    }
    
    /**
     * Set Attendance summary and Students attendance list(Mode wise)
     * @param int $lowerThreshold
     * @param int $upperThreshold
     * @return Acad_Model_Course_Subject
     */
    protected function _attendanceSummary($lowerThreshold = 65, $upperThreshold = 75) {
                                                    
        $attendanceSet = $this->_studentAttendance;
        $stat = $this->_attendanceStat;
        $facultySet = $this->getFaculty();
        $summary = array();
        $stuModeWiseAtt = array();
        if (empty($attendanceSet)) {
            throw new Exception('Student attendance is empty. So cannot generate a summary.', Zend_Log::NOTICE);
        }
        if (empty($stat)) {
            throw new Exception('Attendance Stats are empty. So cannot generate a summary.', Zend_Log::NOTICE);
        }
        
        foreach ($attendanceSet as $subjectMode => $groups) {
            foreach ($groups as $group_id => $students) {
                $totalDelievered = (int) $stat[$subjectMode][$group_id]['delievered'];
                $avgPresent = $totalDelievered - $stat[$subjectMode][$group_id]['AVERAGE']['ABSENT'];
                $avgPercentage = ($avgPresent / $totalDelievered) * 100;
                $summary[$subjectMode][$group_id]['total_delievered'] = $totalDelievered;
                $summary[$subjectMode][$group_id]['total_duration'] = $stat[$subjectMode][$group_id]['total_duration'];
                $summary[$subjectMode][$group_id]['average_attedance'] = round($avgPercentage);
                $summary[$subjectMode][$group_id][self::PASS] = 0;
                $summary[$subjectMode][$group_id][self::AVERAGE] = 0;
                $summary[$subjectMode][$group_id][self::FAIL] = 0;
                foreach ($students as $rollNo => $student) {
                    $present = $totalDelievered - $student['ABSENT'];
                    $percentage = ($present / $totalDelievered) * 100;
                    $attendance = round($percentage);
                    $stuModeWiseAtt[$rollNo][$subjectMode] = $attendance;
                    $division = ceil($attendance);
                    switch ($division) {
                        case 0:
                        case ($division < $lowerThreshold):
                            $summary[$subjectMode][$group_id][self::FAIL] += 1;
                            break;
                        case ($division < $upperThreshold):
                            $summary[$subjectMode][$group_id][self::AVERAGE] += 1;
                            break;
                        default:
                            $summary[$subjectMode][$group_id][self::PASS] += 1;
                            break;
                    }
                }
                foreach ($facultySet[$subjectMode][$group_id] as $facultyId => $facultySubjectInfo) {
                    foreach ($facultySubjectInfo as $key => $info) {
                        $faculty = new Acad_Model_Member_Faculty(array('facultyId' => $facultyId));
                        
                        $facultyInfo['name'] = $faculty->getName();
                        $date_from = date_create_from_format('Y-m-d', $info['date_from']);
                        $facultyInfo['date_from'] = date_format($date_from, 'd/M');
                        $date_upto = date_create_from_format('Y-m-d', $info['date_upto']);
                        $facultyInfo['date_upto'] = date_format($date_upto, 'd/M');
                        
                        $summary[$subjectMode][$group_id]['faculty'][$facultyId]= $facultyInfo;
                    }
                }
            }
        }
        
        $subjectModes = array_keys($attendanceSet);
        if (count($subjectModes) > 1) {
            $summary['combined'][self::PASS] = 0;
            $summary['combined'][self::AVERAGE] = 0;
            $summary['combined'][self::FAIL] = 0;
            $basicModes = array_flip($subjectModes);
            $maxPercentage = 100;
            /**
             * I am doing it this way due to following reasons:
             * -> WE have only absent students records
             * -> If a student attendance is 100% the raw data dont have its record right now
             * and attendance of a student may be 100% in LEC and less in TUT....
             * So, I set 100% attendance by default, if a student entry is missing then
             * There are two cases, either its attendance not marked or 100%attendance,
             * Here, it is assumed that attendance is 100%
             */
            foreach ($basicModes as $subjectMode => $value) {
                $basicModes[$subjectMode] = $maxPercentage;
            }
        
            foreach ($stuModeWiseAtt as $rollNo => $modesAttendance) {
                //setting missing modes attendance value to 100%
                $modesAttendance = array_merge($basicModes,$modesAttendance);
                $totalPercentage = 0;
                foreach ($modesAttendance as $subjectMode => $percentage) {
                    $totalPercentage += $percentage;
                }
                $stuModeWiseAtt[$rollNo]['average'] = $totalPercentage/(count($modesAttendance));
                
                $attendance = round($stuModeWiseAtt[$rollNo]['average']);
                
                $division = ceil($attendance);
                switch ($division) {
                    case 0:
                    case ($division < $lowerThreshold):
                        $summary['combined'][self::FAIL] +=1;
                    break;
                    case ($division < $upperThreshold):
                        $summary['combined'][self::AVERAGE] +=1;
                    break;
                    default:
                        $summary['combined'][self::PASS] +=1;
                    break;
                }
            }
        }
        
        $this->_stuModeWiseAtt = $stuModeWiseAtt;
        $this->_summary = $summary;
        return $this;
    }
    
    /**
     * Summary of Subject attendance.
     * @param int $lowerThreshold
     * @param int $upperThreshold
     * @return Array Attendance Summary
     */
    public function attendanceSummary($lowerThreshold = NULL, $upperThreshold = NULL) {
        if (null === $this->_summary) {
            self::_attendanceSummary($lowerThreshold, $upperThreshold);
        }
        return $this->_summary;
    }

    /**
     * A list of students roll number with attendance in each Mode
     * @param int $lowerThreshold
     * @param int $upperThreshold
     * @return Array Student list with mode wise attendance
     */
    public function attendanceStuModeWise($lowerThreshold = NULL, $upperThreshold = NULL) {
        if (null === $this->_stuModeWiseAtt) {
            self::_attendanceSummary($lowerThreshold, $upperThreshold);
        }
        return $this->_stuModeWiseAtt;
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