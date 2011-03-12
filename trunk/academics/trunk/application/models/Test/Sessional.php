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