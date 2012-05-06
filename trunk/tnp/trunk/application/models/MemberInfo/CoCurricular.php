<?php
class Tnp_Model_MemberInfo_CoCurricular extends Tnp_Model_Generic
{
    protected $_hmember_id;
    protected $_achievements;
    protected $_activities;
    protected $_hobbies;
    protected $_mapper;
    /**
     * @return the $_hmember_id
     */
    public function getHmember_id ()
    {
        return $this->_hmember_id;
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
     * @param field_type $_hmember_id
     */
    public function setHmember_id ($_hmember_id)
    {
        $this->_hmember_id = $_hmember_id;
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
     * @param Tnp_Model_Mapper_MemberInfo_CoCurricular $mapper
     * @return Tnp_Model_Core_Training
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_MemberInfo_CoCurricular
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_MemberInfo_CoCurricular());
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
}