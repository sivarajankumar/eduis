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
    protected $_code;
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
    public function setCode ($code)
    {
        $this->_code = $code;
        return $this;
    }
    /**
     * Get subject code
     * @return string $code subject code
     */
    public function getCode ()
    {
        return $this->_code;
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
            throw new Zend_Exception( 'Could not determine department',Zend_Log::ERR);
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
     * Set subject modes (which are used for subject_faculty)
     * @param array $modes subject modes
     * @return Acad_Model_Course_Subject
     */
    public function setModes ()
    {
        $this->_modes = $this->getMapper()->getSubjectModes($this);
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
     * Set class/semester wise subject faculty and corresponding mode
     * @param array $faculty class/semester wise subject faculty and corresponding mode
     * @return Acad_Model_Course_Subject
     */
    public function setFaculty ()
    {
        $this->_faculty = $this->getMapper()->getFaculties($this);
        return $this;
    }
    /**
     * Get class/semester wise subject faculty and corresponding mode of subject.
     * @return array $faculty class/semester wise subject faculty and corresponding mode of subject.
     */
    public function getFaculty ()
    {
        if (null === $this->_faculty) {
            $this->setFaculty();
        }
        return $this->_faculty;
    }
}
?>