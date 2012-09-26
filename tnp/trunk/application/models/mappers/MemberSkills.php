<?php
class Tnp_Model_Mapper_MemberSkills
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_MemberSkills
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
    public function fetchInfo ($member_id, $skill_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $student_skills_table = $db_table->info('name');
        $required_cols = array('member_id', 'proficiency');
        $select = $adapter->select()
            ->from($student_skills_table, $required_cols)
            ->where('member_id = ?', $member_id)
            ->where('skill_id = ?', $skill_id);
        $skill_info = array();
        $skill_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        if (empty($skill_info)) {
            return false;
        } else {
            return $skill_info[$member_id];
        }
    }
    /**
     * 
     * Enter description here ...
     * @param bool $member_id
     * @param bool $all_member
     */
    public function fetchSkillsIds ($member_id = null)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $skills_table = $db_table->info('name');
        $required_cols = array('skill_id');
        $select = $adapter->select()->from($skills_table, $required_cols);
        if (! empty($member_id)) {
            $select->where('member_id = ?', $member_id);
        }
        $member_skills = array();
        $result = array();
        $result = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        /*foreach ($result as $member_id => $skills_id_array) {
            $member_skills[$member_id] = $skills_id_array['skill_id'];
        }*/
        return $result;
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
    public function delete ($member_id, $skill_id)
    {
        $where1 = 'member_id = ' . $member_id;
        $where2 = 'skill_id = ' . $skill_id;
        $dbtable = $this->getDbTable();
        return $dbtable->delete(array($where1, $where2));
    }
    public function update ($prepared_data, $member_id)
    {
        $dbtable = $this->getDbTable();
        $where1 = 'member_id = ' . $member_id;
        $where2 = 'skill_id = ' . $prepared_data['skill_id'];
        $data = array('proficiency' => $prepared_data['proficiency']);
        return $dbtable->update($data, array($where1, $where2));
    }
}
?>