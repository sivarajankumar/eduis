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
    public function setDbTable (Zend_Db_Table_Abstract $dbTable)
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
     * fetches Address details
     *@param Core_Model_Address $address
     */
    public function fetchAddressDetails ( Core_Model_Address $address)
    {
        $member_id = $address->getMember_id();
    	$adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()
            ->from($this->getDbTable()
            ->info('name'))
            ->where('member_id = ?', $member_id);
        $fetchall = $adapter->fetchAll($select);
        $result = array();
        foreach ($fetchall as $row) {
            foreach ($row as $columnName => $columnValue) {
                $result[$columnName] = $columnValue;
            }
        }
        return $result;
    }
    /**
     * Enter description here ...
     * @param Core_Model_Address $searchParams
     */
    public function fetchMemberId (Core_Model_Address $searchParams)
    {
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from(
        ($this->getDbTable()
            ->info('name')), 'member_id');
        if (isset($searchParams->getAdress_type())) {
            $select->where('adress_type = ?', $searchParams->getAdress_type());
        }
        if (isset($searchParams->getPostal_code())) {
            $select->where('postal_code = ?', $searchParams->getPostal_code());
        }
        if (isset($searchParams->getCity())) {
            $select->where('city = ?', $searchParams->getCity());
        }
        if (isset($searchParams->getDistrict())) {
            $select->where('district = ?', $searchParams->getDistrict());
        }
        if (isset($searchParams->getState())) {
            $select->where('state= ?', $searchParams->getState());
        }
        if (isset($searchParams->getArea())) {
            $select->where('area = ?', $searchParams->getArea());
        }
        if (isset($searchParams->getAddress())) {
            $select->where('address = ?', $searchParams->getAddress());
        }
        return $select->query()->fetchColumn();
    }
}