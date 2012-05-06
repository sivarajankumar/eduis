<?php
class Tnp_Model_Mapper_Core_Training
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Core_Training
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
            $this->setDbTable('Tnp_Model_DbTable_Training');
        }
        return $this->_dbTable;
    }
    public function fetchInfo ($training_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $training_table = $db_table->info('name');
        $required_cols = array('training_id', 'training_technology', 
        'technical_field_id');
        $select = $adapter->select()
            ->from($training_table, $required_cols)
            ->where('training_id = ?', $training_id);
        $training_info = array();
        $training_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $training_info[$training_id];
    }
    public function fetchTrainingIds ($training_technology = null, 
    $technical_field_id = null)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $training_table = $db_table->info('name');
        $required_cols = array('training_id');
        $select = $adapter->select()->from($training_table, $required_cols);
        if (isset($training_technology)) {
            $select->where('training_technology = ?', $training_technology);
        }
        if (isset($technical_field_id)) {
            $select->where('technical_field_id = ?', $technical_field_id);
        }
        $training_ids = array();
        $training_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $training_ids;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $training_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'training_id = ' . $training_id;
        return $dbtable->update($prepared_data, $where);
    }
}
