<?php
class Tnp_Model_Mapper_Company
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Company
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
            $this->setDbTable('Tnp_Model_DbTable_Company');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches Company details
     * 
     * @param integer $company_id
     */
    public function fetchInfo ($company_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $company_table = $db_table->info('name');
        $required_cols = array('company_id', 'company_name', 'field', 
        'description', 'verified');
        $select = $adapter->select()
            ->from($company_table, $required_cols)
            ->where('company_id = ?', $company_id);
        $company_info = array();
        $company_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        if (empty($company_info)) {
            return false;
        } else {
            return $company_info[$company_id];
        }
    }
    /**
     * @desc Fetches All Companies Id
     *
     */
    public function fetchCompanies ()
    {
        $adapter = $this->getDbTable()->getAdapter();
        $company_dbtable = $this->getDbTable();
        $company_table = $company_dbtable->info('name');
        $company_cols = array('company_id', 'company_name');
        $select = $adapter->select()->from($company_table, $company_cols);
        $result = array();
        $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        if (empty($result)) {
            return false;
        } else {
            $companies = array();
            foreach ($result as $company_id => $company_name_array) {
                $companies[$company_id] = $company_name_array['role_name'];
            }
            return $companies;
        }
    }
    public function companyExistCheck ($company_id)
    {
        $companies = $this->getDbTable()->find($company_id);
        if (0 == count($companies)) {
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
    public function update ($prepared_data, $company_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'company_id = ' . $company_id;
        return $dbtable->update($prepared_data, $where);
    }
}
?>