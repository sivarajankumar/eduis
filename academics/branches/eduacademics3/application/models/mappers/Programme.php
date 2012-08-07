<?php
class Acad_Model_Mapper_Programme
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Programme
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
            $this->setDbTable('Acad_Model_DbTable_Programme');
        }
        return $this->_dbTable;
    }
    public function fetchProgrammes ()
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $programme_table = $db_table->info('name');
        $required_cols = array('programme_id', 'programme_name');
        $select = $adapter->select()->from($programme_table, $required_cols);
        $programmes = array();
        $programmes = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        foreach ($programmes as $programme_id => $programme_name_array) {
            $all_programmes[$programme_id] = $programme_name_array['programme_name'];
        }
        return $all_programmes;
    }
    public function fetchInfo ($programme_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $programme_table = $db_table->info('name');
        $required_cols = array('programme_id', 'programme_name', 
        'total_semesters' . 'duration');
        $select = $adapter->select()->from($programme_table, $required_cols);
        $info = array();
        $info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $info[$programme_id];
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $programme_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'programme_id = ' . $programme_id;
        return $dbtable->update($prepared_data, $where);
    }
}