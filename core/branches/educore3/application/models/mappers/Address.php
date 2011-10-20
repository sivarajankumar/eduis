<?php
class Core_Model_Mapper_Address
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Core_Model_Mapper_Address
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
            $this->setDbTable('Core_Model_DbTable_Address');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @todo
     */
    public function save ()
    {}
    /**
     * fetches Address Information of a Member
     * @param Core_Model_Address $address
     */
    public function fetchAddressInfo (Core_Model_Address $address)
    {
        $member_id = $address->getMember_id();
        $adress_type = $address->getAdress_type();
        if (empty($member_id) or empty($adress_type)) {
            $error = 'Both ,Member Id and Address must be set';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('member_id', 'postal_code', 'city', 
            'district', 'state', 'area', 'address');
            $select = $adapter->select()
                ->from($this->getDbTable()
                ->info('name'), $required_fields)
                ->where('member_id = ?', $member_id)
                ->where('adress_type = ?', $adress_type);
            $address_info = array();
            $address_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $address_info[$member_id];
        }
    }
    /**
     * Enter description here ...
     * @param Core_Model_Address $address
     * @param array $property_range Example :array('name'=>array('from'=>n ,'to'=>m));
     * here 'from' stands for >= AND 'to' stands for <=
     * 
     */
    public function fetchStudents (Core_Model_Address $address, 
    array $setter_options = null, array $property_range = null)
    {
        $table = array('s_persnl' => $this->getDbTable()->info('name'));
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()->from($table, 'member_id');
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
            $address->$getter_string();
            $condition = $property_name . ' = ?';
            $select->where($condition, $value);
        }
        return $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
    }
}