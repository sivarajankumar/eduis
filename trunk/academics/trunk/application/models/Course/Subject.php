<?php
class Acad_Model_Course_Subject {
    /**
     * Subject code
     * @var string
     */
    protected $_code;
     
     
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
     * Set subject code
     * @param string $code subject code
     * @return Acad_Model_Course_Subject
     */
    public function setCode($code){
        
        return $this;
    }
    
    /**
     * Get subject code
     * @return string $code subject code
     */
    public function getCode(){
        return $this->_code;
    }
     
    /**
     * Set subject modes
     * @param array $modes subject modes
     * @return Acad_Model_Course_Subject
     */
    public function setModes($modes){
        
        return $this;
    }
    
    /**
     * Get subject modes
     * @return array $modes subject modes
     */
    public function getModes(){
        return $this->_modes;
    }
    
     
     
    /**
     * Set Class/Semester in which subject is taught
     * @param array $semester Class/Semester in which subject is taught
     * @return Acad_Model_Course_Subject
     */
    public function setSemester($semester){
        
        return $this;
    }
    
    /**
     * Get class/semester in which subject is taught
     * @return array $semester class/semester in which subject is taught
     */
    public function getSemester(){
        return $this->_semester;
    }
    
     
    /**
     * Set class/semester wise subject faculty and corresponding mode
     * @param array $faculty class/semester wise subject faculty and corresponding mode
     * @return Acad_Model_Course_Subject
     */
    public function setFaculty($faculty){
        
        return $this;
    }
    
    /**
     * Get class/semester wise subject faculty and corresponding mode
     * @return array $faculty class/semester wise subject faculty and corresponding mode
     */
    public function getFaculty(){
        return $this->_faculty;
    }
    
}
?>