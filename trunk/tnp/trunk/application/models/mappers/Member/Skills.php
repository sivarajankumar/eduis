<?php
class Tnp_Model_Mapper_Member_Skills
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Member_Skills
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
            $this->setDbTable('Tnp_Model_DbTable_StudentSkills');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @param integer $skill_id
     */
    public function fetchInfo ($member_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $student_skills_table = $db_table->info('name');
        $required_cols = array('member_id', 'skill_id', 'proficiency');
        $select = $adapter->select()
            ->from($student_skills_table, $required_cols)
            ->where('member_id = ?', $member_id);
        $skill_info = array();
        $skill_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $skill_info[$member_id];
    }
    public function fetchMemberIds ($skill_id = null, $proficiency = null)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $student_skills_table = $db_table->info('name');
        $required_cols = array('member_id');
        $select = $adapter->select()->from($student_skills_table, 
        $required_cols);
        if (! empty($skill_id)) {
            $select->where('skill_id = ?', $skill_id);
        }
        if (! empty($proficiency)) {
            $select->where('proficiency = ?', $proficiency);
        }
        $member_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $member_ids;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $member_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'member_id = ' . $member_id;
        return $dbtable->update($prepared_data, $where);
    }
}
?>