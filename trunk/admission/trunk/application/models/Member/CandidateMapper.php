<?php

/**
 * Candidates data mapper
 * 
 * @uses       Admsn_Model_DbTable_Applicant
 * @package    Admission
 * @subpackage Model
 */
class Admsn_Model_Member_CandidateMapper
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;

    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Admsn_Model_Member_CandidateMapper
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
     * Lazy loads Admsn_Model_DbTable_Applicant if no instance registered
     * 
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Admsn_Model_DbTable_Applicant');
        }
        return $this->_dbTable;
    }
    
    
    /**
     * Check if roll number of applicant already exists
     * @return bool $applied - if roll no of candidate exists
     * @param Admsn_Model_Member_Candidate
     */
    public function exists(Admsn_Model_Member_Candidate $candidate){
        $select = $this->getDbTable()
                    ->getAdapter()
                    ->select()
                    ->from($this->getDbTable()->info('name'),array('roll_no','application_basis','is_locked'))
                    ->where('roll_no = ?',$candidate->getRoll_no());
        $result = $select->query()->fetch();
        if (count($result)) {
            return $result;
        }
        return false;
    }
    
}
