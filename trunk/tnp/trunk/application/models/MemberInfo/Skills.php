<?php
class Tnp_Model_MemberInfo_Skills extends Tnp_Model_Generic
{
    protected $_member_id;
    protected $_skill_id;
    protected $_proficiency;
    protected $_mapper;
    /**
     * @param bool $throw_exception optional
     * @return the $_member_id
     */
    public function getMember_id ($throw_exception = null)
    {
        $member_id = $this->_member_id;
        if (empty($member_id) and $throw_exception == true) {
            $message = 'Member_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $member_id;
        }
    }
    /**
     * @return the $_skill_id
     */
    public function getSkill_id ($throw_exception = null)
    {
        $skill_id = $this->_skill_id;
        if (empty($skill_id) and $throw_exception == true) {
            $message = '_skill_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $skill_id;
        }
    }
    /**
     * @return the $_proficiency
     */
    public function getProficiency ()
    {
        return $this->_proficiency;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_skill_id
     */
    public function setSkill_id ($_skill_id)
    {
        $this->_skill_id = $_skill_id;
    }
    /**
     * @param field_type $_proficiency
     */
    public function setProficiency ($_proficiency)
    {
        $this->_proficiency = $_proficiency;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_MemberSkills $mapper
     * @return Tnp_Model_MemberInfo_Skills
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_MemberSkills
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_MemberSkills());
        }
        return $this->_mapper;
    }
    /**
     * Provides correct db column names corresponding to model properties
     * @todo add correct names where required
     * @param string $key
     */
    protected function correctDbKeys ($key)
    {
        switch ($key) {
            /*case 'nationalit':
                return 'nationality';
                break;*/
            default:
                return $key;
                break;
        }
    }
    /**
     * Provides correct model property names corresponding to db column names
     * @todo add correct names where required
     * @param string $key
     */
    protected function correctModelKeys ($key)
    {
        switch ($key) {
            /*case 'nationality':
                return 'nationalit';
                break;*/
            default:
                return $key;
                break;
        }
    }
    public function fetchSkillsIds ()
    {
        $member_id = $this->getMember_id(true);
        $info = array();
        $info = $this->getMapper()->fetchSkillsIds($member_id);
        if (empty($info)) {
            return false;
        } else {
            return $info;
        }
    }
    public function fetchAllMembersAllSkills ()
    {
        $info = array();
        $info = $this->getMapper()->fetchSkills();
        if (empty($info)) {
            return false;
        } else {
            return $info;
        }
    }
    public function fetchInfo ()
    {
        $member_id = $this->getMember_id(true);
        $skill_id = $this->getSkill_id(true);
        $proficiency = array();
        $proficiency = $this->getMapper()->fetchInfo($member_id, $skill_id);
        if (empty($proficiency)) {
            return false;
        } else {
            return $this->setOptions($proficiency);
        }
    }
    /**
     * 
     * Enter description here ...
     * @param bool $skill_specific
     * @param bool $proficiency_specific
     */
    public function fetchMemberIds ($skill_specific = null, 
    $proficiency_specific = null)
    {
        $skill_id = null;
        $proficiency = null;
        if ($skill_specific == true) {
            $skill_id = $this->getSkill_id(true);
        }
        if ($proficiency_specific == true) {
            $proficiency = $this->getProficiency(true);
        }
        $member_ids = $this->getMapper()->fetchMemberIds($skill_id, 
        $proficiency);
        return $member_ids;
    }
}