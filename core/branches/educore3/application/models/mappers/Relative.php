<?php
class Core_Model_Mapper_Relative
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Core_Model_Mapper_Relative
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
            $this->setDbTable('Core_Model_DbTable_Relative');
        }
        return $this->_dbTable;
    }
    public function save ()
    {}
    /**
     *fetches information about a relative
     *@param Core_Model_Relative $relative
     */
    public function fetchRelativeInfo (Core_Model_Relative $relative)
    {
        $member_id = $relative->getMember_id();
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $relatives_fields = array('member_id', 'relation_id', 'name', 
        'occupation', 'designation', 'office_add', 'contact', 'annual_income', 
        'landline_no');
        $relations_fields = array('relation_name');
        $select = $adapter->select()
            ->from($this->getDbTable()
            ->info('name'), $relatives_fields)
            ->joinInner('relations', 
        'relatives.relation_id = relations.relation_id', $relations_fields)
            ->where('member_id = ?', $member_id);
        $relative_info = array();
        $relative_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $relative_info[$member_id];
    }
    /**
     * Enter description here ...
     * @param Core_Model_Relative $relative
     * @param array $property_range Example :array('name'=>array('from'=>n ,'to'=>m));
     * here 'from' stands for >= AND 'to' stands for <=
     * 
     */
    public function fetchStudents (Core_Model_Relative $relative, 
    array $setter_options = null, array $property_range = null)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()->from(
        ($this->getDbTable()
            ->info('name')), 'member_id');
        foreach ($property_range as $key => $range) {
            if (! empty($range['from'])) {
                $select->where("$key >= ?", $range['from']);
            }
            if (! empty($range['to'])) {
                $select->where("$key <= ?", $range['to']);
            }
        }
        foreach ($setter_options as $property_name => $value) {
            $getter_string = 'get' . ucfirst($property_name);
            $relative->$getter_string();
            $condition = $property_name . ' = ?';
            $select->where($condition, $value);
        }
        return $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
    }
}