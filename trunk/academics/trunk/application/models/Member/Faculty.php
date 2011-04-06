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
     * Set Faculty Subjects
     * @param string $_subject_faculty
     * @return Acad_Model_Member_Faculty()
     */
    public function getFacultySubjects ($_subject_faculty)
    {
        
        $sql = 'SELECT
		subject_faculty.subject_code
            , subject.subject_name
        FROM
            subject_faculty
            INNER JOIN subject 
                ON (subject_faculty.subject_code = subject.subject_code)
            INNER JOIN subject_department 
                ON (subject_department.subject_code = subject.subject_code)
        WHERE (subject_faculty.staff_id = ?)';
        /*$this->logger->log ( 'getFacultySubject($_subject_faculty)', Zend_Log::INFO );
		$this->logger->log ( $result, Zend_Log::DEBUG );*/
        return $this->getAdapter()->fetchAll($sql, $_subject_faculty);
    }
    
    public function listMarkedAttendance() {
        return $this->getMapper()->listMarkedAttendance($this);
    }
    

    public function listUnMarkedAttendance() {
        return $this->getMapper()->listUnMarkedAttendance($this);
    }
}
?>