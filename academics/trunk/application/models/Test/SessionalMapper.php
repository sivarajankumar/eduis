<?php
class Acad_Model_Test_SessionalMapper
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
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    /**
     * Get registered Zend_Db_Table instance
     *
     * Lazy loads Acad_Model_Test_Sessional if no instance registered
     * 
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Acad_Model_DbTable_Sessional');
        }
        return $this->_dbTable;
    }
    
    /**
     * Save a sessional datesheet
     * 
     * @param  Acad_Model_Test_SessionalMapper
     * @return void
     */
    public function save ($sessional)
    {
        if ($sessional instanceof Acad_Model_Test_Sessional) {
            $data = array('subject' => $sessional->getSubject(), 
            'testNumber' => $sessional->getTestNumber(), 
            'maxMarks' => $sessional->getMaxMarks(), 
            'minMarks' => $sessional->getMinMarks(), 
            'conductDate' => $sessional->getConductDate(), 
            'testInfoId' => $sessional->getTestInfoId());
            if (null === ($testInfoId = $sessional->getTestInfoId())) {
                unset($data['testInfoId']);
  
                 $sql='INSERT INTO '
             . $this->quoteIdentifier($sessional, true)
             . ' (' . implode(', ', $data) . ')';
             return $this->getDbTable()->getAdapter()->query($sql);
            } else {
                //$this->getDbTable()->update($data, array('testInfoId = ?' => $testInfoId));
                $set[] = $this->quoteIdentifier($data, true) . ' = ';
                $where = $this->_whereExpr($where);
                /**
         * Build the UPDATE statement
         */
        $sql = "UPDATE "
             . $this->quoteIdentifier($sessional, true)
             . ' SET ' . implode(', ', $set)
             . (($where) ? " WHERE $where" : '');

             return $this->getDbTable()->getAdapter()->query($sql);
            }
        } elseif (is_array($sessional)){
            
        } else {
            throw new Zend_Exception('oye, ye kya bheja hai??', Zend_Log::ERR);
        }
    }
    
    /**
     * 
     * Enter description here ...
     * return array Acad_Model_Test_Sessional
     */
    public function fetchAll ()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Acad_Model_Test_Sessional();
            $entry->setTestInfoId($row->test_info_id)
                ->setDepartment($row->department_id)
                ->setDegree($row->degree_id)
                ->setSemester($row->semester_id)
                ->setSubject($row->subject_code)
                ->setTestType($row->test_type_id)
                ->setTestNumber($row->test_id)
                ->setTime($row->time)
                ->setConductDate($row->date_of_conduct)
                ->setMaxMarks($row->max_marks)
                ->setMinMarks($row->pass_marks)
                ->setMapper($this);
            $entries[] = $entry;
        }
        return $entries;
    }
}