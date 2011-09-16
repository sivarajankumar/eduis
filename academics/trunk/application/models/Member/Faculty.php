<?php
/** 
 * @version 3.0
 * 
 */
class Acad_Model_Member_Faculty extends Acad_Model_Member_Generic
{
    /**
     * Faculty Subjects
     * @var string|int
     */
    protected $_subject_faculty;
    
/**
     * Subject Mapper
     * @var Acad_Model_Member_FacultyMapper
     */
    protected $_mapper;
    /**
     * Set Subject Mapper
     * @param Acad_Model_Member_FacultyMapper $mapper - Subject Mapper
     * @return Acad_Model_Test_Sessional
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * Get Subject Mapper
     * @return Acad_Model_Member_FacultyMapper $mapper - Subject Mapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Member_FacultyMapper());
        }
        return $this->_mapper;
    }
    
    
	/**
	 * Set Faculty ID
	 * 
	 * @param  string|int $faculty_id 
	 * @return Acad_Model_Member_Faculty
	 */
    public function setFacultyId($faculty_id) {
        return self::setMemberId($faculty_id);
    }
    

    
	/**
	 * Get Faculty ID
	 * 
	 * @return string|int
	 */
    public function getFacultyId() {
        return self::getMemberId();
    }
    
    /**
     * Get Faculty Subjects
     * @param Acad_Model_Class $class = null
     * @return array
     */
    public function getSubjects (Acad_Model_Class $class = NULL, $showModes = NULL){
        return $this->getMapper()->fetchSubjects($this,$class, $showModes);
    }
    
    /**
     * List of all periods marked.
     */
    public function listMarkedAttendance() {
        return $this->getMapper()->listMarkedAttendance($this);
    }
    

    public function listUnMarkedAttendance() {
        return $this->getMapper()->listUnMarkedAttendance($this);
    }
}
?>