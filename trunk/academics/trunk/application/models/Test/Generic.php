<?php
/** 
 * @author Administrator
 * 
 * 
 */
abstract class Acad_Model_Test_Generic
{
    
    /**
     * Test info id
     * @var int
     */
    protected $_testInfoId;
    
    /**
     * Department
     * @var string
     */
    protected $_department;
     
    /**
     * Degree
     * @var string
     */
    protected $_degree;
     
     
    /**
     * Semester
     * @var int
     */
    protected $_semester;
    
    
    /**
     * subject
     * @var string
     */
    protected $_subject;
    
    
    /**
     * Test number
     * @var int
     */
    protected $_testNumber;
    
    
    /**
     * Test type
     * @var string
     */
    protected $_testType;
     
    
    /**
     * Date of conduct
     * @var date
     */
    protected $_conductDate;
    
    
    /**
     * Max Marks
     * @var int
     */
    protected $_maxMarks;
     
     
    /**
     * Min marks
     * @var int
     */
    protected $_minMarks;
    
    /**
     * Set test info id
     * @param int $testInfoId - test info id
     * @return Acad_Model_Test_Generic
     */
    public function setTestInfoId($testInfoId){
        $this->_testInfoId=$testInfoId;        
        return $this;
    }
    
    
    /**
     * Get test info id
     * @return int $testInfoId - test info id
     */
    public function getTestInfoId(){
        return $this->_testInfoId;
    }
    
    
    /**
     * Set department
     * @param string $department - department
     * @return Acad_Model_Test_Generic
     */
    public function setDepartment($department){
        $this->_department=$department;
        return $this;
    }
    
    /**
     * Get department
     * @return string $department - department
     */
    public function getDepartment(){
        return $this->_department;
    }
    
    
    /**
     * Set degree
     * @param string $degree - degree
     * @return Acad_Model_Test_Generic
     */
    public function setDegree($degree){
        $this->_degree=$degree;
        return $this;
    }
    
    /**
     * Get degree
     * @return string $degree - degree
     */
    public function getDegree(){
        return $this->_degree;
    }
    
     
     
    /**
     * Set semester
     * @param int $semester - semester
     * @return Acad_Model_Test_Generic
     */
    public function setSemester($semester){
        $this->_semester=$semester;
        return $this;
    }
    
    /**
     * Get semester
     * @return int $semester - semester
     */
    public function getSemester(){
        return $this->_semester;
    }
    
     
     
    /**
     * Set subject
     * @param string $subject - subject
     * @return Acad_Model_Test_Generic
     */
    public function setSubject($subject){
        $this->_subject=$subject;
        return $this;
    }
    
    /**
     * Get subject
     * @return string $subject - subject
     */
    public function getSubject(){
        return $this->_subject;
    }
    
     
     
    /**
     * Set number
     * @param int $testNumber - number
     * @return Acad_Model_Test_Generic
     */
    public function setTestNumber($testNumber){
        $this->_testNumber=$testNumber;
        return $this;
    }
    
    /**
     * Get number
     * @return int $testNumber - number
     */
    public function getTestNumber(){
        return $this->_testNumber;
    }
    
     
    /**
     * Set test type
     * @param string $testType - test type
     * @return Acad_Model_Test_Generic
     */
    public function setTestType($testType){
        $this->_testType=$testType;
        return $this;
    }
    
    /**
     * Get test type
     * @return string $testType - test type
     */
    public function getTestType(){
        return $this->_testType;
    }
    
     
     
    /**
     * Set date of conduct
     * @param date $conductDate - date of conduct
     * @return Acad_Model_Test_Generic
     */
    public function setConductDate($conductDate){
        $this->_conductDate=$conductDate;
        return $this;
    }
    
    /**
     * Get date of conduct
     * @return date $conductDate - date of conduct
     */
    public function getConductDate(){
        return $this->_conductDate;
    }
    
    
/**
     * Set Max Marks
     * @param int $maxMarks - Max Marks
     * @return Acad_Model_generic
     */
    public function setMaxMarks($maxMarks){
        $this->getMapper()->getMaxMarks(params);
        return $this;
    }
    
    /**
     * Get Max Marks
     * @return int $maxMarks - Max Marks
     */
    public function getMaxMarks(){
        return $this->_maxMarks;
    }
    
     
     
    /**
     * Set min marks
     * @param int $minMarks - min marks
     * @return Acad_Model_generic
     */
    public function setMinMarks($minMarks){
        $this->getMapper()->getMinMarks(params);
        return $this;
    }
    
    /**
     * Get min marks
     * @return int $minMarks - min marks
     */
    public function getMinMarks(){
        return $this->_minMarks;
    }

}
?>