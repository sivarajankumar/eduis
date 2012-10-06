<?php
class Tnp_Model_Mapper_JobRecord
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_JobRecord
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
            $this->setDbTable('Tnp_Model_DbTable_JobRecord');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches company_job details
     * 
     * @param integer $company_job_id
     * @param integer $member_id
     * @return false|arry of complete information
     */
    public function fetchInfo ($company_job_id, $member_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $table = $db_table->info('name');
        $required_cols = array('appeared', 'selected', 'package', 
        'date_of_selection', 'drive_location', 'registered');
        $select = $adapter->select()
            ->from($table, $required_cols)
            ->where('member_id = ?', $member_id)
            ->where('company_job_id = ?', $company_job_id);
        $info = array();
        $info = $select->query()->fetchAll();
        if (empty($info)) {
            return false;
        } else {
            return $info[0];
        }
    }
    public function checkMemberJob ($company_job_id, $member_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $table = $db_table->info('name');
        $required_cols = array('company_id');
        $select = $adapter->select()
            ->from($table, $required_cols)
            ->where('member_id = ?', $member_id)
            ->where('company_job_id = ?', $company_job_id);
        $info = array();
        $matches = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        if (empty($matches)) {
            return false;
        } else {
            return true;
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
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $member_id, $company_job_id)
    {
        $dbtable = $this->getDbTable();
        $where1 = 'company_job_id = ' . $company_job_id;
        $where2 = 'member_id = ' . $member_id;
        return $dbtable->update($prepared_data, array($where1, $where2));
    }
}
?>