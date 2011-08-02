<?php
/**
 * The Assignment Class
 * @author ACEIS TEAM
 *
 */
class Acad_Model_Assessment_Assignment extends Acad_Model_Assessment_Abstract
{
    /**
     * Static Variable defining the type of Assessment
     * 
     */
    protected $_test_type_id='ASNMT';
    /**
     * Assignment Mapper
     * @var Acad_Model_Assessment_AssignmentMapper
     */
    protected $_mapper;
     /**
     * Scored Marks
     * @var int
     */
    protected $_marks_scored;
    /**
     * Status
     * @var string
     */
    protected $_status;
    /**
     * Set Assignment Mapper
     * @param Acad_Model_Assessment_AssignmentMapper $mapper - Assignment Mapper
     * @return Acad_Model_Assessment_Assignment
     */
    public function setMapper($mapper){
        $this->_mapper=$mapper;
        return $this;
    }
    
    /**
     * Get Assignment Mapper
     * @return Acad_Model_Assessment_AssignmentMapper $mapper - Assignment Mapper
     */
    public function getMapper(){
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Assessment_AssignmentMapper());
        }
        return $this->_mapper;
    }
    
	/**
     * Constructor
     * 
     * @param  array|null $options 
     * @return void
     */
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
        self::_setTest_type_id('ASNMT');
    }
    
    
    /**
     * Overloading: allow property access
     * 
     * @param  string $name 
     * @param  mixed $value 
     * @return void
     */
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Zend_Exception('Invalid property specified');
        }
        $this->$method($value);
    }

    /**
     * Overloading: allow property access
     * 
     * @param  string $name 
     * @return mixed
     */
    public function __get($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
             throw new Zend_Exception('Invalid property specified');
        }
        return $this->$method();
    }
    
    /**
     * Set object state
     * 
     * @param  array $options 
     * @return Acad_Model_Assignment
     */
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
      
    /**
     * Save the current entry
     * 
     * @return void
     */
    public function save()
    {
       return $this->getMapper()->save($this);
    }
/**
     * Set scored Marks
     * @param int $_marks_scored
     * @return Acad_Model_Test_TestMarks
     */
    public function setMarks_scored ($_marks_scored)
    {
        $this->_marks_scored = $_marks_scored;
        return $this;
    }
    /**
     * Get marks scored
     * @return int $_marks_scored- marsks scored 
     */
    public function getMarks_scored ()
    {
        return $this->_marks_scored;
    }
    /**
     * Set status
     * @param int $_status
     * @return Acad_Model_Test_TestMarks
     */
    public function setStatus ($_status)
    {
        $this->_status = $_status;
        return $this;
    }
    /**
     * Get status
     * @return int $_status-status 
     */
    public function getStatus ()
    {
        return $this->_status;
    }
    /**
     * This function gets the test_ids corresponding to latest locked
     * or !locked Assignment as a/q to params
     */
    public function getHighestTestIds ($dep, $deg, $sem, $testType=NULL,$numIds =NULL,$lock = NULL)
    {
        $testType = self::getTest_type_id();
        return (parent::getHighestTestIds ($dep, $deg, $sem, $testType, $numIds,$lock));
    }
    /**
     * Fetch all entries
     * 
     * @return array of Acad_Model_Assessment_Assignment
     */
    public function fetchAll()
    {
       return $this->getMapper()->fetchAll($this);
    }
    /**
     * Function to get data to show as Schedule
     *   
     */
    public function fetchSchedule($dep,$deg,$sem,$numIds=NULL){
        $testType = self::getTest_type_id();
        $result =parent::fetchSchedule($deg,$dep,$sem,$testType,$numIds);
        return $result;
    }
    
    
     public function fetchMarks($dep,$deg,$sem,$stuRoll)
     {
         $testType = self::getTest_type_id();
         return $this->getMapper()->fetchMarks($dep,$deg,$sem,$stuRoll,$testType);
     }
}
?>