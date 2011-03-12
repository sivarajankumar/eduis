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
     * Students of class
     * @var array
     */
    protected $_students;
    
    /**
     * Faculty members teaching in class
     * @var array
     */
    protected $_faculties;
    
    /**
     * Subjects in class
     * @var array
     */
    protected $_subjects;
    /**
     * @var Acad_Model_ClassMapper
     */
    protected $_mapper;
        
    /**
     * Set class department
     * @param string $department class department
     * @return Acad_Model_Class
     */
    public function setDepartment ($department)
    {
        $this->_department=$department;
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
        $this->_degree=$degree;
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
        $this->_semester=$semester;
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
        $this->_batchStart=$batchStart;
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
            $this->_students = $this->getMapper()->fetchSemesterStudents(
            $this->getDepartment(), $this->getDegree(), $this->getSemester(), 
            $group);
        }
        return $this->_students;
    }

    /**
     * Set faculty members
     * @param array $faculties - faculty members
     * @return Acad_Model_Department
     */
    protected function setFacultyMembers($faculties){
        
        $this->_faculties=$faculties;
        return $this;
    }
    
    /**
     * Get faculty members teaching in class
     * @return array $faculties - faculty members
     */
    public function getFacultyMembers(){
        return $this->_faculties;
    }
    

    /**
     * Set subjects
     * 
     * @return Acad_Model_Class
     */
    protected function setSubjects(){
        $this->_subjects=$this->getMapper()->getSubjects(
        $this->getDepartment(), $this->getDegree(), $this->getSemester(), 'TH');
        return $this;
    }
    
    /**
     * Get subjects of class
     * @return array $subjects Subjects of class
     */
    public function getSubjects ()
    {
        if (null === $this->_subjects) {
            //do smting
        }
        return $this->_subjects;
    }
    

    /**
     * Set data mapper
     * 
     * @param  mixed $mapper 
     * @return Acad_Model_Class
     */
    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    /**
     * Get data mapper
     *
     * Lazy loads Acad_Model_Class instance if no mapper registered.
     * 
     * @return Acad_Model_ClassMapper
     */
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_ClassMapper());
        }
        return $this->_mapper;
    }
   
    /**
     * Save the current entry
     * 
     * @return void
     */
    public function save(){
        $this->getMapper()->save($this);
    }
}
?>