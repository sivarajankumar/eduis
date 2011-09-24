<?php
/** 
 * @author Administrator, udit sharma
 * @version 3.0
 * 
 */
class Acad_Model_Test_Sessional extends Acad_Model_Test_Generic
{
    
    /**
     * Sessional Mapper
     * @var Acad_Model_Test_SessionalMapper
     */
    protected $_mapper;
     
     
    /**
     * Set Sessional Mapper
     * @param Acad_Model_Test_SessionalMapper $mapper - Sessional Mapper
     * @return Acad_Model_Test_Sessional
     */
    public function setMapper($mapper){
        $this->_mapper=$mapper;
        return $this;
    }
    
    /**
     * Get Sessional Mapper
     * @return Acad_Model_Test_SessionalMapper $mapper - Sessional Mapper
     */
    public function getMapper(){
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Test_SessionalMapper());
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
            throw new Exception('Invalid property specified');
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
             throw new Exception('Invalid property specified');
        }
        return $this->$method();
    }
    
    /**
     * Set object state
     * 
     * @param  array $options 
     * @return Acad_Model_Sessional
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
     * Function fectSchedule
     * Fecthes scedule of particular sessional if exists
     * Otherwise, it will create partial schedule for further completion
     * @return  
     */
    public function fetchSchedule(){
        return $this->getMapper()->fetchSchedule($this);
    }
    
 	/**
     * Fetch all entries
     * 
     * @return array of Acad_Model_Test_Sessional
     */
    public function fetchAll()
    {
       return $this->getMapper()->fetchAll($this);
    }
        
}
?>