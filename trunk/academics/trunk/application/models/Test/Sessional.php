<?php
/** 
 * @author Administrator
 * 
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
     * Save the current entry
     * 
     * @return void
     */
    public function save()
    {
        $this->getMapper()->save($this);
    }
 /**
     * Fetch all entries
     * 
     * @return array
     */
    public function fetchAll()
    {
        return $this->getMapper()->fetchAll();
    }   
        
}
?>