<?php
class Tnp_Model_Mapper_Certification
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Certification
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
            $this->setDbTable('Tnp_Model_DbTable_Certification');
        }
        return $this->_dbTable;
    }
    public function fetchInfo ($certification_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $certification_table = $db_table->info('name');
        $required_cols = array('training_id', 'training_technology', 
        'technical_field_id');
        $select = $adapter->select()
            ->from($certification_table, $required_cols)
            ->where('certification_id = ?', $certification_id);
        $certification_info = array();
        $certification_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $certification_info[$certification_id];
    }
    public function fetchCertificationIds ($certification_name = null, 
    $technical_field_id = null)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $certification_table = $db_table->info('name');
        $required_cols = array('certification_id');
        $select = $adapter->select()->from($certification_table, $required_cols);
        if (isset($certification_name)) {
            $select->where('certification_name = ?', $certification_name);
        }
        if (isset($technical_field_id)) {
            $select->where('technical_field_id = ?', $technical_field_id);
        }
        $certification_ids = array();
        $certification_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $certification_ids;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $certification_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'certification_id = ' . $certification_id;
        return $dbtable->update($prepared_data, $where);
    }
}