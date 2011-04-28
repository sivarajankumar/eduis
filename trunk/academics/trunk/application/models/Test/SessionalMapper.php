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
            $id = $sessional->getTest_info_id();
            if ((string)$id === (string)(int)$id) {
                $data['date_of_conduct'] = $sessional->getDate_of_conduct();
                $data['time'] = $sessional->getTime();
                $data['max_marks'] = $sessional->getMax_marks();
                $data['pass_marks'] = $sessional->getPass_marks();
                return $this->getDbTable()->update($data, "test_info_id = $id");
            } else {
                $data['date_of_conduct'] = $sessional->getDate_of_conduct();
                $data['time'] = $sessional->getTime();
                $data['max_marks'] = $sessional->getMax_marks();
                $data['pass_marks'] = $sessional->getPass_marks();
                
                $data['department_id'] = $sessional->getDepartment_id();
                $data['degree_id'] = $sessional->getDegree_id();
                $data['semester_id'] = $sessional->getSemester_id();
                $data['subject_code'] = $sessional->getSubject_code();
                $data['test_id'] = $sessional->getTest_id();
                
                
                $data['test_type_id'] = $sessional->getTest_type_id();
                
                $today = new Zend_Date();
                $data['date_of_announcemnet'] = $today->toString('YYYY-MM-dd') ;
                return $this->getDbTable()->insert($data);
            }
        }
        
    }
    
    /**
     * Fecthes schedule of particular sessional if exists
     * 
     * Otherwise, it will create partial schedule for further completion
     * @param Acad_Model_Test_Sessional
     * @return array Acad_Model_Test_Sessional with status
     *  Status => true defines requested sessional for particular class already exists.
     *  Status => false defines requested sessional for particular class donot exists and is newly prepared.
     */
    public function fetchSchedule (Acad_Model_Test_Sessional $sessional)
    {
        //$logger = Zend_Registry::get('logger');
        $check = $this->fetchAll($sessional);
        //$logger->debug($check);
        if (0 != count($check)) {
            return array('data' => $check, 'exists' => true);
        } 
        else {           
            
                $sql = 'SELECT `subject_department`.`department_id`
    						, `subject_department`.`degree_id`
    						, `subject_department`.`semester_id`
  							, `subject_department`.`subject_code`
    						, `subject`.`subject_name`
    						, `test`.`test_type_id`
    						, `test`.`test_id`
    						, `test`.`is_optional`
    						, `test_type`.`default_pass_marks`
    						, `test_type`.`default_max_marks`
				   FROM `academics`.`subject_department`
    					    , `academics`.`subject`
    					    , `academics`.`test`
                   INNER JOIN `academics`.`test_type` 
                         ON (`test`.`test_type_id` = `test_type`.`test_type_id`)
                   WHERE (`subject_department`.`department_id` = ?
                          AND `subject_department`.`degree_id` =?
                          AND `subject_department`.`semester_id` =?
                          AND `test`.`test_type_id` =?
                          AND `test`.`test_id` =?
                          AND `subject_department`.`subject_code` =`subject`.`subject_code`);';
            
                $data[] = $sessional->getDepartment_id();
                $data[] = $sessional->getDegree_id();
                $data[] = $sessional->getSemester_id();
                $data[] = $sessional->getTest_type_id();
                $data[] = $sessional->getTest_id();
                $result = Zend_Db_Table::getDefaultAdapter()
                                       ->query($sql,$data)
                                       ->fetchAll();
                           
            if ($result != null) {
                $entries = array();
                foreach ($result as $row) {
                    $entry = new Acad_Model_Test_Sessional();
                    $entry->setOptions($row)
                          ->setMapper($this);
                    $entries[] = $entry;
                }
                
                return array('data' => $entries, 'exists' => false);
                
            }
            else {
                return new Zend_Exception('Invalid sessional paramter',Zend_Log::ERR);
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
        $sql = $this->getDbTable()->getDefaultAdapter()
            ->select()
            ->from($this->getDbTable()->info('name'))
            ->joinInner('subject', 
        			    '`test_info`.`subject_code` = `subject`.`subject_code`', 
        			    'subject_name')
            ->where('department_id = ?', $sessional->getDepartment_id())
//            ->where('degree_id = ?', $sessional->getDegree_id())
            ->where('test_type_id = ?', $sessional->getTest_type_id())
            ->where('test_id =?', $sessional->getTest_id());
            
            if($sessional->getSemester_id()){
                $sql->where('semester_id = ?', $sessional->getSemester_id());
            }
            
            $resultSet = $sql->query()->fetchAll();
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