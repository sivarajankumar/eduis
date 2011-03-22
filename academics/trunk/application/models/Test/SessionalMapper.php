<?php
/**
 * 
 * Sessional Mapper
 * @author udit sharma
 * @version 3.0
 *
 */
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
     * Lazy loads Acad_Model_Test_Sessional if no instance registered
     * 
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Acad_Model_DbTable_TestInfo');
        }
        return $this->_dbTable;
    }
    
    /**
     * Save a sessional datesheet
     * 
     * @param  array|Acad_Model_Test_Sessional
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
                $sql = 'INSERT INTO ' . $this->quoteIdentifier($sessional, true) .
                 ' (' . implode(', ', $data) . ')';
                return $this->getDbTable()
                    ->getAdapter()
                    ->query($sql);
            } else {
                $set[] = $this->quoteIdentifier($data, true) . ' = ';
                $where = $this->_whereExpr($where);
                /**
                 * Build the UPDATE statement
                 */
                $sql = "UPDATE " . $this->quoteIdentifier($sessional, true) .
                 ' SET ' . implode(', ', $set) .
                 (($where) ? " WHERE $where" : '');
                return $this->getDbTable()
                    ->getAdapter()
                    ->query($sql);
            }
        } elseif (is_array($sessional)) {
            if (null === ($testInfoId = $sessional->getTestInfoId())) {
                unset($data['testInfoId']);
                $sql = 'INSERT INTO ' . $this->quoteIdentifier($sessional, true) .
                 ' (' . implode(', ', $data) . ')';
                return $this->getDbTable()
                    ->getAdapter()
                    ->query($sql);
            } else {
                $set[] = $this->quoteIdentifier($data, true) . ' = ';
                $where = $this->_whereExpr($where);
                /**
                 * Build the UPDATE statement
                 */
                $sql = "UPDATE " . $this->quoteIdentifier($sessional, true) .
                 ' SET ' . implode(', ', $set) .
                 (($where) ? " WHERE $where" : '');
                return $this->getDbTable()
                    ->getAdapter()
                    ->query($sql);
            }
        } else {
            throw new Zend_Exception('oye, ye kya bheja hai??', Zend_Log::ERR);
        }
    }
    /**
     * Fecthes schedule of particular sessional if exists
     * 
     * Otherwise, it will create partial schedule for further completion
     * @param Acad_Model_Test_Sessional
     * @return array Acad_Model_Test_Sessional
     *  
     */
    public function fetchSchedule (Acad_Model_Test_Sessional $sessional)
    {
        //$logger = Zend_Registry::get('logger');
        $check = $this->fetchAll($sessional);
        //$logger->debug($check);
        if (0 != count($check)) {
            return $check;
        } else {
            
            
            
//            $sql = 'SELECT `subject_department`.`department_id`
//    						, `subject_department`.`degree_id`
//    						, `subject_department`.`semester_id`
//  							, `subject_department`.`subject_code`
//    						, `subject`.`subject_name`
//    						, `test`.`test_type_id`
//    						, `test`.`test_id`
//    						, `test`.`is_optional`
//    						, `test_type`.`default_pass_marks`
//    						, `test_type`.`default_max_marks`
//				   FROM `academics`.`subject_department`
//    					    , `academics`.`subject`
//    					    , `academics`.`test`
//                   INNER JOIN `academics`.`test_type` 
//                         ON (`test`.`test_type_id` = `test_type`.`test_type_id`)
//                   WHERE (`subject_department`.`department_id` = "CSE"
//                          AND `subject_department`.`degree_id` ="BTECH"
//                          AND `subject_department`.`semester_id` =8
//                          AND `test`.`test_type_id` ="SESS"
//                          AND `test`.`test_id` =2
//                          AND `subject_department`.`subject_code` =`subject`.`subject_code`);';
            
            $result = $this->getDbTable()->getDefaultAdapter()
                                         ->select()
                                         ->from
                           ->query($sql)
                           ->fetchAll();
                           
            if ($result != null) {
                $entries = array();
                foreach ($result as $row) {
                    $entry = new Acad_Model_Test_Sessional();
                    $entry->setOptions($row)
                          ->setMapper($this);
                    $entries[] = $entry;
                }
                return $entries;
            } else {
                return "Didn't worked out.";
            }
        }
    }
    
    /**
     * Fetches all the entries for perticular sessional
     * 
     * @param Acad_Model_Test_Sessional
     * @return array Acad_Model_Test_Sessional
     */
    public function fetchAll (Acad_Model_Test_Sessional $sessional)
    {
        //$logger = Zend_Registry::get('logger');
        $resultSet = $this->getDbTable()->getDefaultAdapter()
            ->select()
            ->from($this->getDbTable()->info('name'))
            ->joinInner('subject', 
        			    '`test_info`.`subject_code` = `subject`.`subject_code`', 
        			    'subject_name')
            ->where('department_id = ?', $sessional->getDepartment_id())
            ->where('degree_id = ?', $sessional->getDegree_id())
            ->where('semester_id = ?', $sessional->getSemester_id())
            ->where('test_type_id = ?', $sessional->getTest_type_id())
            ->where('test_id =?', $sessional->getTest_id())
            ->query()
            ->fetchAll();
        //$logger->debug($resultSet);
        if ($resultSet != NULL) {
            $entries = array();
            foreach ($resultSet as $row) {
                $entry = new Acad_Model_Test_Sessional();
                $entry->setOptions($row)
                      ->setMapper($this);
                $entries[] = $entry;
            }
            return $entries;
        } else {
            return null;
        }
    }
}