<?php
class Tnp_Model_Mapper_MemberInfo_Language
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_MemberInfo_Language
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
            $this->setDbTable('Tnp_Model_DbTable_StudentLanguage');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @param integer $member_id
     */
    public function fetchProficiency ($member_id, $language_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $stu_lan_table = $db_table->info('name');
        $required_cols = array('member_id', 'language_id', 'proficiency');
        $select = $adapter->select()
            ->from($stu_lan_table, $required_cols)
            ->where('member_id = ?', $member_id)
            ->where('language_id = ?', language_id);
        $stu_lan_info = array();
        $stu_lan_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $stu_lan_info[$member_id];
    }
    public function fetchLanguagesKnown ($member_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $stu_lan_table = $db_table->info('name');
        $required_cols = array('language_id');
        $select = $adapter->select()->from($stu_lan_table, $required_cols);
        $stu_lans = array();
        $select->where('member_id = ?', $member_id);
        return $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $member_id, $language_id)
    {
        $dbtable = $this->getDbTable();
        $where1 = 'member_id = ' . $member_id;
        $where2 = 'language_id = ' . $language_id;
        return $dbtable->update($prepared_data, array($where1, $where2));
    }
}
?>