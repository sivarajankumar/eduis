<?php
/**
 * @todo incomplete
 * Enter description here ...
 * 
 */
class Tnp_Model_Mapper_Profile_Member_Student
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Profile_Components_Experience
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
            $this->setDbTable('Tnp_Model_DbTable_Student');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchSkillsPossessed (
    Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (! isset($member_id)) {
            throw new Exception('Insufficient Params.. Member\'s Id is required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('skill_id', 'proficiency');
            $select = $adapter->select()
                ->from('student_skills', $required_fields)
                ->where('member_id = ?', $member_id);
            $skills_possessed = array();
            $skills_possessed = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $skills_possessed;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchSkillDescription (
    Tnp_Model_Profile_Member_Student $student)
    {
        $skill_id = $student->getSkill_id();
        if (! isset($skill_id)) {
            $error = 'Insufficient Params.. Skill\'s id is required to get Skill Description';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('skill_name', 'skill_field');
            $select = $adapter->select()
                ->from('student_skills', $required_fields)
                ->where('skill_id = ?', $skill_id);
            $skill_details = array();
            $skill_details = $select->query()->fetchAll();
            foreach ($skill_details as $row) {
                foreach ($row as $columnName => $columnValue) {
                    $result[$columnName] = $columnValue;
                }
            }
            return $result;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchLanguagesKnown (
    Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (! isset($member_id)) {
            throw new Exception('Insufficient Params.. Member\'s Id is required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('language_id', 'proficeincy');
            $select = $adapter->select()
                ->from('student_language', $required_fields)
                ->where('member_id = ?', $member_id);
            $languages_known = array();
            $languages_known = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $languages_known;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchLanguageDescription (
    Tnp_Model_Profile_Member_Student $student)
    {
        $languages_id = $student->getLanguage_id();
        if (! isset($languages_id)) {
            $error = 'Insufficient Params.. Language\'s id is required to get Language Description';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('language_name');
            $select = $adapter->select()
                ->from('languages', $required_fields)
                ->where('language_id = ?', $languages_id);
            $language_details = array();
            $language_details = $select->query()->fetchAll();
            foreach ($language_details as $row) {
                foreach ($row as $columnName => $columnValue) {
                    $result[$columnName] = $columnValue;
                }
            }
            return $result;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchCoCuricular (Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (! isset($member_id)) {
            $error = 'Insufficient Params.. Member\'s id is required to get his co_curicular details';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('achievements' . 'activities', 'hobbies');
            $select = $adapter->select()
                ->from('co_curicullar', $required_fields)
                ->where('member_id = ?', $member_id);
            $co_curicular_details = array();
            $co_curicular_details = $select->query()->fetchAll();
            foreach ($co_curicular_details as $row) {
                foreach ($row as $columnName => $columnValue) {
                    $result[$columnName] = $columnValue;
                }
            }
            return $result;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchProfileStatus (
    Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (! isset($member_id)) {
            $error = 'Insufficient Params.. Member\'s id is required to get his profile status';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('exists' . 'is_locked', 'last_updated_on');
            $select = $adapter->select()
                ->from('profile_status', $required_fields)
                ->where('member_id = ?', $member_id);
            $co_curicular_details = array();
            $co_curicular_details = $select->query()->fetchAll();
            foreach ($co_curicular_details as $row) {
                foreach ($row as $columnName => $columnValue) {
                    $result[$columnName] = $columnValue;
                }
            }
            return $result;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchJobPreferred (Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (! isset($member_id)) {
            $error = 'Insufficient Params.. Member\'s id is required to get his profile status';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('type');
            $select = $adapter->select()
                ->from('job_preferred', $required_fields)
                ->where('member_id = ?', $member_id);
            return $select->query()->fetchColumn();
        }
    }
}