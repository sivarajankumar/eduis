<?php
class Tnp_Model_Mapper_MemberInfo_JobPreferred
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_MemberInfo_JobPreferred
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
            $this->setDbTable('Tnp_Model_DbTable_JobPreferred');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @param integer $member_id
     */
    public function fetchInfo ($member_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $stu_class_table = $db_table->info('name');
        $required_cols = array('job_area');
        $select = $adapter->select()
            ->from($stu_class_table, $required_cols)
            ->where('member_id = ?', $member_id);
        $job_area_preferred = array();
        $job_area_preferred = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $job_area_preferred;
    }
    /**
     * 
     * @param integer $member_id
     */
    public function fetchMemberIds ($job_area_preferred)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $stu_class_table = $db_table->info('name');
        $required_cols = array('member_id');
        $select = $adapter->select()
            ->from($stu_class_table, $required_cols)
            ->where('job_area = ?', $job_area_preferred);
        $class_ids = array();
        return $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
    }
    public function fetchAll ()
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $language_table = $db_table->info('name');
        $required_cols = array('member_id', 'job_area');
        $select = $adapter->select()->from($language_table, $required_cols);
        $member_job_preferred = array();
        $result = array();
        $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        foreach ($result as $member_id => $job_preferred_array) {
            $member_job_preferred[$member_id] = $job_preferred_array['job_area'];
        }
        return $member_job_preferred;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $member_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'member_id = ' . $member_id;
        return $dbtable->update($prepared_data, $where);
    }
}
?>