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
        
        return $this;
    }
    
    /**
     * Get Sessional Mapper
     * @return Acad_Model_Test_SessionalMapper $mapper - Sessional Mapper
     */
    public function getMapper(){
        return $this->_mapper;
    }
}
?>