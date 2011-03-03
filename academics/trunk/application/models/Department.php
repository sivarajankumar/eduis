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
    
}
?>