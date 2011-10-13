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
    public function fetchSkillsPossessedInfo (
    Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (! isset($member_id)) {
            throw new Exception('Insufficient Params.. Member\'s Id is required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('skill_id', 'proficiency as skill_proficiency');
            $select = $adapter->select()
                ->from('student_skills', $required_fields)
                ->where('member_id = ?', $member_id);
            $skills_possessed = array();
            $skills_possessed = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            //Zend_Registry::get('logger')->debug($skills_possessed);
            return $skills_possessed;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchSkillInfo (Tnp_Model_Profile_Member_Student $student)
    {
        $skill_id = $student->getSkill_id();
        if (! isset($skill_id)) {
            $error = 'Insufficient Params.. Skill\'s id is required to get Skill Description';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('skill_id', 'skill_name', 'skill_field');
            $select = $adapter->select()
                ->from('skills', $required_fields)
                ->where('skill_id = ?', $skill_id);
            $skill_details = array();
            $skill_details = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $skill_details[$skill_id];
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchLanguagesKnownInfo (
    Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (! isset($member_id)) {
            throw new Exception('Insufficient Params.. Member\'s Id is required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('language_id', 'proficiency as language_proficiency');
            $select = $adapter->select()
                ->from('student_language', $required_fields)
                ->where('member_id = ?', $member_id);
            $languages_known = array();
            $languages_known = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            //Zend_Registry::get('logger')->debug($languages_known);
            return $languages_known;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchLanguageInfo (Tnp_Model_Profile_Member_Student $student)
    {
        $languages_id = $student->getLanguage_id();
        if (! isset($languages_id)) {
            $error = 'Insufficient Params.. Language\'s id is required to get Language Description';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('language_id', 'language_name');
            $select = $adapter->select()
                ->from('languages', $required_fields)
                ->where('language_id = ?', $languages_id);
            $language_details = array();
            $language_details = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $language_details[$languages_id];
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchCoCuricularInfo (
    Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (! isset($member_id)) {
            $error = 'Insufficient Params.. Member\'s id is required to get his co_curicular details';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('member_id', 'achievements' . 'activities', 
            'hobbies');
            $select = $adapter->select()
                ->from('co_curicullar', $required_fields)
                ->where('member_id = ?', $member_id);
            $co_curicular_details = array();
            $co_curicular_details = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $co_curicular_details[$member_id];
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchJobPreferredInfo (
    Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (! isset($member_id)) {
            $error = 'Insufficient Params.. Member\'s id is required to get his profile status';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('member_id', 'type');
            $select = $adapter->select()
                ->from('job_preferred', $required_fields)
                ->where('member_id = ?', $member_id);
            $job_preferred_info = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $job_preferred_info[member_id];
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchProfileStatusInfo (
    Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (! isset($member_id)) {
            $error = 'Insufficient Params.. Member\'s id is required to get his profile status';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('member_id', 'exists' . 'is_locked', 
            'last_updated_on');
            $select = $adapter->select()
                ->from('profile_status', $required_fields)
                ->where('member_id = ?', $member_id);
            $profile_status_info = array();
            $profile_status_info = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $profile_status_info[$member_id];
        }
    }
}