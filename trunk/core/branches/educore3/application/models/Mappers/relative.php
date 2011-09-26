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
        $required_fields = array('member_id', 'relation_id', 'relation_name', 
        'name', 'occupation', 'designation', 'office_add', 'contact', 
        'annual_income', 'landline_no');
        $select = $adapter->select()
            ->from($this->getDbTable()
            ->info('name'))
            ->joinInner('relations', 
        'relatives.relation_id = relations.relation_id', $required_fields)
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
     * @param Core_Model_Relative $searchParams
     */
    public function fetchMember (Core_Model_Relative $searchParams)
    {
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from(
        ($this->getDbTable()
            ->info('name')), 'member_id');
        if (isset($searchParams->getRelation_id())) {
            $select->where('relation_id = ?', $searchParams->getRelation_id());
        }
        if (isset($searchParams->getName())) {
            $select->where('name= ?', $searchParams->getName());
        }
        if (isset($searchParams->getOccupation())) {
            $select->where('occupation = ?', $searchParams->getOccupation());
        }
        if (isset($searchParams->getDesignation())) {
            $select->where('designation = ?', $searchParams->getDesignation());
        }
        if (isset($searchParams->getOffice_add())) {
            $select->where('office_add= ?', $searchParams->getOffice_add());
        }
        if (isset($searchParams->getContact())) {
            $select->where('contact = ?', $searchParams->getContact());
        }
        if (isset($searchParams->getAnnual_income())) {
            $select->where('annual_income = ?', 
            $searchParams->getAnnual_income());
        }
        if (isset($searchParams->getLandline_no())) {
            $select->where('landline_no = ?', $searchParams->getLandline_no());
        }
        return $select->query()->fetchColumn();
    }
}