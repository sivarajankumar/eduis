<?php
class Tnp_Model_Mapper_TechnicalField
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_TechnicalField
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
            $this->setDbTable('Tnp_Model_DbTable_TechnicalFields');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @param integer $skill_id
     */
    public function fetchInfo ($technical_field_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $technical_field_table = $db_table->info('name');
        $technical_field_cols = array('technical_field_id', 
        'technical_field_name', 'technical_sector');
        $select = $adapter->select()
            ->from($technical_field_table, $technical_field_cols)
            ->where('technical_field_id = ?', $technical_field_id);
        $technical_field_info = array();
        $technical_field_info = $select->query()->fetchAll(
        Zend_Db::FETCH_UNIQUE);
        if (empty($technical_field_info)) {
            return false;
        } else {
            return $technical_field_info[$technical_field_id];
        }
    }
    public function fetchTechnicalFields ()
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $technical_field_table = $db_table->info('name');
        $required_cols = array('technical_field_id', 'technical_field_name');
        $select = $adapter->select()->from($technical_field_table, 
        $required_cols);
        $technical_fields = array();
        $result = array();
        $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        if (empty($result)) {
            return false;
        } else {
            foreach ($result as $tech_field_id => $tech_field_name_array) {
                $technical_fields[$tech_field_id] = $tech_field_name_array['technical_field_name'];
            }
            return $technical_fields;
        }
    }
    public function fetchTechnicalFieldIds ($technical_field_name = null, 
    $technical_sector = null)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $technical_field_table = $db_table->info('name');
        $required_cols = array('member_id');
        $select = $adapter->select()->from($technical_field_table, 
        $required_cols);
        if (! empty($technical_field_name)) {
            $select->where('technical_field_name = ?', $technical_field_name);
        }
        if (! empty($technical_sector)) {
            $select->where('technical_sector = ?', $technical_sector);
        }
        $technical_field_ids = array();
        $technical_field_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $technical_field_ids;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $technical_field_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'technical_field_id = ' . $technical_field_id;
        return $dbtable->update($prepared_data, $where);
    }
    public function delete ($technical_field_id)
    {
        $where = 'technical_field_id = ' . $technical_field_id;
        return $this->getDbTable()->delete($where);
    }
}
?>