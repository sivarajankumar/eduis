<?php
class Acad_Model_Department
{
    /**
     * Department
     * @var string
     */
    protected $_department;
    /**
     * Programs/Courses/Degrees provided by department
     * @var array
     */
    protected $_programs;
    
    /**
     * Faculty members of department
     * 
     * All faculty members which belong to the department.
     *  
     * @var array
     */
    protected $_faculties;
    /**
     * Set department
     * @param string $department - department
     * @return Acad_Model_Department
     */
    
    /**
     * Faculty members teaching in department
     * 
     * It has those faculty members which are teaching in department even if 
     * they do not belong to the department. 
     * 
     * @var array
     */
    protected $_teachingFaculty;

    /**
     * @var Acad_Model_DepartmentMapper
     */
    protected $_mapper;
    /**
     * Set data mapper
     * 
     * @param  mixed $mapper 
     * @return Acad_Model_Department
     */
    public function setMapper (Acad_Model_DepartmentMapper $mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * Get data mapper
     *
     * Lazy loads Acad_Model_DepartmentMapper instance if no mapper registered.
     * 
     * @return Acad_Model_DepartmentMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_DepartmentMapper());
        }
        return $this->_mapper;
    }
    
    public function setDepartment ($department)
    {
        $this->_department = $department;
        return $this;
    }
    /**
     * Get department
     * @return string $department - department
     */
    public function getDepartment ()
    {
        return $this->_department;
    }
    /**
     * Set programs/courses/degrees provided by department
     * @param array $programs - programs/courses/degrees provided by department
     * @return Acad_Model_Department
     */
    public function setProgram ($programs)
    {
        return $this;
    }
    /**
     * Get programs/courses/degrees provided by department
     * @return array $programs - programs/courses/degrees provided by department
     */
    public function getProgram ()
    {
        return $this->_programs;
    }
    
    /**
     * Set faculty members
     * @param array $faculties - faculty members
     * @return Acad_Model_Department
     */
    public function setFacultyMembers ()
    {
        if (isset($this->_department)) {
            $department = $this->_department;
        } else {
            throw new Zend_Exception(
            'Unable to determine "department" to get faculty list.', 
            Zend_Log::ERR);
        }
        $sql = Zend_Db_Table::getDefaultAdapter()->select()
            ->distinct()
            ->from('subject_faculty', 'staff_id')
            ->join('semester_degree', 
        'semester_degree.department_id = subject_faculty.department_id', array())
            ->where('semester_degree.handled_by_dept =? ', $department);
        $this->_faculties = $sql->query()->fetchAll();
        return $this;
    }
    /**
     * Get faculty members
     * 
     * All faculty members which belong to the department.
     *  
     * @return array $faculties - faculty members
     */
    public function getFacultyMembers ()
    {
        if (!isset($this->_faculties)) {
            $this->setFacultyMembers();
        }
        return $this->_faculties;
    }
    
     
    /**
     * Set faculty members teaching in department
     * @param array $teachingFaculty - faculty members teaching in department
     * @return Acad_Model_Department
     */
    public function setTeachingFaculty($teachingFaculty){
        
        return $this;
    }
    
    /**
     * Get faculty members teaching in department
     * 
     * Get all faculty members which are teaching in department even if 
     * they do not belong to the department. 
     * 
     * @return array $teachingFaculty - faculty members teaching in department
     */
    public function getTeachingFaculty(){
        return $this->_teachingFaculty;
    }
    
    public function getAttendanceOverview($dateFrom = null) {
        return $this->getMapper()->fetchAttendanceStat($dateFrom);
    }
    
    public function getAttendanceDetail($dateFrom = null, $degree = null, $semester = null) {
        return $this->getMapper()->fetchAttendanceDetail($this,$dateFrom);
    }
}
?>