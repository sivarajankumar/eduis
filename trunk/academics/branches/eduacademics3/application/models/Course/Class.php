<?php
class Acad_Model_Course_Class extends Acad_Model_Generic
{
    protected $_subject_code;
    protected $_department_id;
    protected $_programme_id;
    protected $_semester_id;
    protected $_subjects;
    protected $_mapper;
    /**
     * @return the $_subject_code
     */
    public function getSubject_code ()
    {
        return $this->_subject_code;
    }
    /**
     * @param field_type $_subject_code
     */
    public function setSubject_code ($_subject_code)
    {
        $this->_subject_code = $_subject_code;
    }
    /**
     * @return the $_department_id
     */
    public function getDepartment_id ()
    {
        return $this->_department_id;
    }
    /**
     * @param field_type $_department_id
     */
    public function setDepartment_id ($_department_id)
    {
        $this->_department_id = $_department_id;
    }
    /**
     * @return the $_programme_id
     */
    public function getProgramme_id ()
    {
        return $this->_programme_id;
    }
    /**
     * @param field_type $_programme_id
     */
    public function setProgramme_id ($_programme_id)
    {
        $this->_programme_id = $_programme_id;
    }
    /**
     * @return the $_semester_id
     */
    public function getSemester_id ()
    {
        return $this->_semester_id;
    }
    /**
     * @param field_type $_semester_id
     */
    public function setSemester_id ($_semester_id)
    {
        $this->_semester_id = $_semester_id;
    }
    /**
     * Set subjects
     * 
     * @return Acad_Model_Class
     */
    protected function setSubjects ($type, $mode = null)
    {
        if (isset($mode)) {
            $this->_subjects[$type][$mode] = $this->getMapper()->getSubjects(
            $this, $type, $mode);
        } else {
            $this->_subjects[$type] = $this->getMapper()->getSubjects($this, 
            $type);
        }
        return $this;
    }
    /**
     * Get subjects of class
     * @param string $type
     * @param string $mode
     * @return array $subjects Subjects of class
     */
    public function getSubjects ($type = 'TH', $mode = null)
    {
        if (isset($mode)) {
            if (! isset($this->_subjects[$type][$mode])) {
                $this->setSubjects($type, $mode);
            }
            return $this->_subjects[$type][$mode];
        } else {
            if (! isset($this->_subjects[$type])) {
                $this->setSubjects($type);
            }
            return $this->_subjects[$type];
        }
    }
    /**
     * 
     * @param Acad_Model_Mapper_Course_Class $mapper
     * @return Acad_Model_Course_Dmc
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Course_Class
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Course_Class());
        }
        return $this->_mapper;
    }
    /*
    /**
     * Get Attendance status of class
     * 
     * @param string $subjectCode
     * @param date $dateFrom
     * @param date $dateUpto
     * @param string $subjectType
     * @param string $subjectMode
     */
/*
    public function getAttendanceDetail ($subjectType = null, $subjectMode = null, 
    $dateFrom = null, $dateUpto = null)
    {
        $attendance = $this->getMapper()->getAttendanceDetail($this, 
        $subjectMode, $dateFrom, $dateUpto, $subjectType);
        return $attendance;
    }
    /**
     * Get Subject Attendance status of class
     * 
     * @param string $subjectCode
     * @param date $dateFrom
     * @param date $dateUpto
     * @param string $subjectType
     * @param string $subjectMode
     */
/*public function getSubjectAttendanceDetail ($subjectCode, 
    $subjectMode = null, $dateFrom = null, $dateUpto = null)
    {
        $attendance = $this->getMapper()->getSubjectAttendanceDetail($this, 
        $subjectCode, $subjectMode, $dateFrom, $dateUpto);
        return $attendance;
    }
    /**
     * Get un-marked attendance counts.
     * Get un-marked attendance in grouped by faculty,subject,mode
     */
/*public function getUnmarkedAttendance ()
    {
        return $this->getMapper()->getUnmarkedAttendance($this);
   }*/
}
?>