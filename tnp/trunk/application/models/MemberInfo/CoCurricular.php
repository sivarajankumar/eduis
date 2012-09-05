<?php
class Tnp_Model_MemberInfo_CoCurricular extends Tnp_Model_Generic
{
    protected $_member_id;
    protected $_achievements;
    protected $_activities;
    protected $_hobbies;
    protected $_mapper;
    /**
     * @return the $_member_id
     */
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    /**
     * @return the $_achievements
     */
    public function getAchievements ()
    {
        return $this->_achievements;
    }
    /**
     * @return the $_activities
     */
    public function getActivities ()
    {
        return $this->_activities;
    }
    /**
     * @return the $_hobbies
     */
    public function getHobbies ()
    {
        return $this->_hobbies;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_achievements
     */
    public function setAchievements ($_achievements)
    {
        $this->_achievements = $_achievements;
    }
    /**
     * @param field_type $_activities
     */
    public function setActivities ($_activities)
    {
        $this->_activities = $_activities;
    }
    /**
     * @param field_type $_hobbies
     */
    public function setHobbies ($_hobbies)
    {
        $this->_hobbies = $_hobbies;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_MemberCoCurricular $mapper
     * @return Tnp_Model_MemberInfo_CoCurricular
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_MemberCoCurricular
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_MemberCoCurricular());
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
    /**
     * 
     * Enter description here ...
     * @param bool $achievement_specific
     * @param bool $activitie_specific
     * @param bool $hobby_specific
     */
    public function fetchMemberIds ($achievement_specific = null, 
    $activitie_specific = null, $hobby_specific = null)
    {
        $achievements = null;
        $activities = null;
        $hobbies = null;
        if ($achievement_specific == true) {
            $achievement = $this->getAchievements();
        }
        if ($activitie_specific == true) {
            $activities = $this->getActivities();
        }
        if ($hobby_specific == true) {
            $hobbies = $this->getHobbies();
        }
        $member_ids = $this->getMapper()->fetchMemberIds();
        return $member_ids;
    }
    public function fetchInfo ()
    {
        $member_id = $this->getMember_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($member_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
    public function deleteCoCurricular ()
    {
        $member_id = $this->getMember_id(true);
        return $this->getMapper()->delete($member_id);
    }
}