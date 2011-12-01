<?php
class Lib_Model_Mapper_IsbnMapper
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    
    protected $_dbTable;
    
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Test_SessionalMapper
     */
    public function setDbTable ($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (! $dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    
    /**
     * Get registered Zend_Db_Table instance
     *
     * Lazy loads Lib_Model_DbTable_Isbn if no instance registered
     * 
     * @return Lib_Model_DbTable_Isbn
     */
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Lib_Model_DbTable_Isbn');
        }
        return $this->_dbTable;
    }
}