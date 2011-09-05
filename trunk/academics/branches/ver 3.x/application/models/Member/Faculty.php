<?php
/** 
 * @author Babita
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
     * Get Faculty Subjects
     * @param Acad_Model_Class $class = null
     * @return array
     */
    public function getSubjects (Acad_Model_Class $class = NULL, $showModes = NULL){
        return $this->getMapper()->fetchSubjects($this,$class, $showModes);
    }
    
    public function listMarkedAttendance() {
        return $this->getMapper()->listMarkedAttendance($this);
    }
    

    public function listUnMarkedAttendance() {
        return $this->getMapper()->listUnMarkedAttendance($this);
    }
}
?>