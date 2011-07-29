<?php
class Acad_Model_Asessment_Assignment extends Acad_Model_Asessment_Abstract
{
    /**
     * Static Variable defining the type of Asessment
     * 
     */
    protected $test_type_id='ASNMT';
    /**
     * Assignment Mapper
     * @var Acad_Model_Asessment_AssignmentMapper
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
     * @param Acad_Model_Asessment_AssignmentMapper $mapper - Assignment Mapper
     * @return Acad_Model_Asessment_Assignment
     */
    public function setMapper($mapper){
        $this->_mapper=$mapper;
        return $this;
    }
    
    /**
     * Get Assignment Mapper
     * @return Acad_Model_Asessment_AssignmentMapper $mapper - Assignment Mapper
     */
    public function getMapper(){
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Asessment_AssignmentMapper());
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
        self::_setTest_type_id('SESS');
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
     * Function fectSchedule
     * Fecthes scedule of particular Assignment if exists
     * Otherwise, it will create partial schedule for further completion
     * @return  
     */
    public function fetchSchedule(){
        return $this->getMapper()->fetchSchedule($this);
    }
    
 	/**
     * Fetch all entries
     * 
     * @return array of Acad_Model_Asessment_Assignment
     */
    public function fetchAll()
    {
       return $this->getMapper()->fetchAll($this);
    }
     public function fetchMarks($deg,$dep,$sem,$stuRoll)
     {
         return $this->getMapper()->fetchMarks($deg,$dep,$sem,$stuRoll,$this->test_type_id);
     }
}
?>