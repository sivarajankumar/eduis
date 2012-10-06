<?php
class Tnp_Model_Mapper_CompanyJob
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_CompanyJob
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
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Tnp_Model_DbTable_CompanyJob');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches company_job details
     * 
     * @param integer $company_job_id
     */
    public function fetchInfo ($company_job_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $table = $db_table->info('name');
        $required_cols = array('company_job_id', 'company_id', 'job', 
        'eligibility_criteria', 'description', 'date_of_announcement', 
        'external');
        $select = $adapter->select()
            ->from($table, $required_cols)
            ->where('company_job_id = ?', $company_job_id);
        $info = array();
        $company_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        if (empty($company_info)) {
            return false;
        } else {
            return $company_info[$company_job_id];
        }
    }
    /**
     * @desc Fetches All Jobs in a company
     *
     */
    public function fetchCompanyJobIds ($company_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $table = $db_table->info('name');
        $required_cols = array('company_job_id');
        $select = $adapter->select()
            ->from($table, $required_cols)
            ->where('company_id = ?', $company_id);
        $company_jobs = array();
        $company_jobs = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        if (empty($company_jobs)) {
            return false;
        } else {
            return $company_jobs;
        }
    }
    public function findJobIds ($company_id = null, $job = null, 
    $date_of_announcement = null)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $dbtable = $this->getDbTable();
        $table = $dbtable->info('name');
        $req_cols = array('company_job_id');
        $select = $adapter->select()->from($table, $req_cols);
        if (isset($company_id)) {
            $select->where('company_id = ?', $company_id);
        }
        if (isset($job)) {
            $select->where('job = ?', $job);
        }
        if (isset($date_of_announcement)) {
            $select->where('date_of_announcement = ?', $date_of_announcement);
        }
        $job_ids = array();
        $job_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        if (empty($job_ids)) {
            return false;
        } else {
            return $job_ids;
        }
    }
    public function fetchStudents ($company_job_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $table = $db_table->info('name');
        $required_cols = array('member_id');
        $select = $adapter->select()
            ->from($table, $required_cols)
            ->where('company_job_id = ?', $company_job_id);
        $members = array();
        $members = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        if (empty($members)) {
            return false;
        } else {
            return $members;
        }
    }
    public function companyJobExistCheck ($company_job_id)
    {
        $company_jobs = $this->getDbTable()->find($company_job_id);
        if (0 == count($company_jobs)) {
            return false;
        } else {
            return true;
        }
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $company_job_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'company_job_id = ' . $company_job_id;
        return $dbtable->update($prepared_data, $where);
    }
}
?>