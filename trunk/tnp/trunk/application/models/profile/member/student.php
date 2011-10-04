<?php
class Tnp_Model_Profile_Member_Student
{
    protected $_member_id;
    protected $_skills_possessed = array();
    protected $_languages_known = array();
    protected $_skill_id;
    protected $_skill_name;
    protected $_skill_field;
    protected $_skill_proficiency;
    protected $_language_id;
    protected $_language_name;
    protected $_language_proficiency;
    protected $_exists;
    protected $_is_locked;
    protected $_last_updated_on;
    protected $_job_preferred;
    protected $_achievements;
    protected $_activities;
    protected $_hobbies;
    protected $_mapper;
    protected function getLanguages_known ()
    {
        return $this->_languages_known;
    }
    protected function getSkills_possessed ()
    {
        return $this->_skills_possessed;
    }
    /**
     * @return the $_member_id
     */
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @return the $_skill_id
     */
    public function getSkill_id ()
    {
        return $this->_skill_id;
    }
    /**
     * @param field_type $_skill_id
     */
    public function setSkill_id ($_skill_id)
    {
        $this->_skill_id = $_skill_id;
    }
    /**
     * @return the $_skill_name
     */
    public function getSkill_name ()
    {
        return $this->_skill_name;
    }
    /**
     * @param field_type $_skill_name
     */
    public function setSkill_name ($_skill_name)
    {
        $this->_skill_name = $_skill_name;
    }
    /**
     * @return the $_skill_field
     */
    public function getSkill_field ()
    {
        return $this->_skill_field;
    }
    /**
     * @param field_type $_skill_field
     */
    public function setSkill_field ($_skill_field)
    {
        $this->_skill_field = $_skill_field;
    }
    /**
     * @return the $_skill_proficiency
     */
    public function getSkill_proficiency ()
    {
        $this->initSkillProficiency();
        return $this->_skill_proficiency;
    }
    /**
     * @param field_type $_skill_proficiency
     */
    public function setSkill_proficiency ($_skill_proficiency)
    {
        $this->_skill_proficiency = $_skill_proficiency;
    }
    /**
     * @return the $_language_id
     */
    public function getLanguage_id ()
    {
        return $this->_language_id;
    }
    /**
     * @param field_type $_language_id
     */
    public function setLanguage_id ($_language_id)
    {
        $this->_language_id = $_language_id;
    }
    /**
     * @return the $_language_name
     */
    public function getLanguage_name ()
    {
        return $this->_language_name;
    }
    /**
     * @param field_type $_language_name
     */
    public function setLanguage_name ($_language_name)
    {
        $this->_language_name = $_language_name;
    }
    /**
     * @return the $_language_proficiency
     */
    public function getLanguage_proficiency ()
    {
        $this->initLanguageProficiency();
        return $this->_language_proficiency;
    }
    /**
     * @param field_type $_language_proficiency
     */
    public function setLanguage_proficiency ($_language_proficiency)
    {
        $this->_language_proficiency = $_language_proficiency;
    }
    /**
     * @return the $_exists
     */
    public function getExists ()
    {
        return $this->_exists;
    }
    /**
     * @param field_type $_exists
     */
    public function setExists ($_exists)
    {
        $this->_exists = $_exists;
    }
    /**
     * @return the $_is_locked
     */
    public function getIs_locked ()
    {
        return $this->_is_locked;
    }
    /**
     * @param field_type $_is_locked
     */
    public function setIs_locked ($_is_locked)
    {
        $this->_is_locked = $_is_locked;
    }
    /**
     * @return the $_last_updated_on
     */
    public function getLast_updated_on ()
    {
        return $this->_last_updated_on;
    }
    /**
     * @param field_type $_last_updated_on
     */
    public function setLast_updated_on ($_last_updated_on)
    {
        $this->_last_updated_on = $_last_updated_on;
    }
    /**
     * @return the $_job_preferred
     */
    public function getJob_preferred ()
    {
        return $this->_job_preferred;
    }
    /**
     * @param field_type $_job_preferred
     */
    public function setJob_preferred ($_job_preferred)
    {
        $this->_job_preferred = $_job_preferred;
    }
    /**
     * @return the $_achievements
     */
    public function getAchievements ()
    {
        return $this->_achievements;
    }
    /**
     * @param field_type $_achievements
     */
    public function setAchievements ($_achievements)
    {
        $this->_achievements = $_achievements;
    }
    /**
     * @return the $_activities
     */
    public function getActivities ()
    {
        return $this->_activities;
    }
    /**
     * @param field_type $_activities
     */
    public function setActivities ($_activities)
    {
        $this->_activities = $_activities;
    }
    /**
     * @return the $_hobbies
     */
    public function getHobbies ()
    {
        return $this->_hobbies;
    }
    /**
     * @param field_type $_hobbies
     */
    public function setHobbies ($_hobbies)
    {
        $this->_hobbies = $_hobbies;
    }
    /**
     * Set Mapper
     * @param Tnp_Model_Mapper_Member_Student $mapper
     * @return Tnp_Model_Profile_Member_Student
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Member_Student
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_Profile_Member_Student());
        }
        return $this->_mapper;
    }
    public function __construct (array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    public function __set ($name, $value)
    {
        $method = 'set' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
        }
        $this->$method($value);
    }
    public function __get ($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
        }
    }
    /**
     * used to init an object
     * @param array $options
     */
    public function setOptions ($options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    public function initCoCuricular ()
    {
        $options = $this->getMapper()->fetchCoCuricular($this);
        $this->setOptions($options);
    }
    public function initJobPreferred ()
    {
        $options = $this->getMapper()->fetchJobPreferred($this);
        $this->setOptions($options);
    }
    public function initProfileStatus ()
    {
        $options = $this->getMapper()->fetchProfileStatus($this);
        $this->setOptions($options);
    }
    public function getMemberSkillIds ()
    {
        $this->initSkills_possessed();
        $possessed_skills_ids = array_keys($this->getSkills_possessed());
        if (sizeof($possessed_skills_ids) == 0) {
            $error = 'No skills registered for ' . $this->getMember_id();
            throw new Exception($error);
        } else {
            return $possessed_skills_ids;
        }
    }
    public function initSkillDescription ()
    {
        $options = $this->getMapper()->fetchSkillDescription($this);
        $this->setOptions($options);
    }
    public function getMemberLanguageKnownIds ()
    {
        $this->initLanguages_known();
        $language_ids = array_keys($this->getLanguages_known());
        if (sizeof($language_ids) == 0) {
            $error = 'languages known are not registered for ' .
             $this->getMember_id();
            throw new Exception($error);
        } else {
            return $language_ids;
        }
    }
    public function initLanguageDescription ()
    {
        $options = $this->getMapper()->fetchLanguageDescription($this);
        $this->setOptions($options);
    }
    protected function initLanguages_known ()
    {
        if (sizeof($this->_languages_known) == 0) {
            $languages_known = $this->getMapper()->fetchLanguagesKnown($this);
            $this->_languages_known = $languages_known;
        }
    }
    protected function initSkills_possessed ()
    {
        if (sizeof($this->_skills_possessed) == 0) {
            $skills_possessed = $this->getMapper()->fetchSkillsPossessed($this);
            $this->_skills_possessed = $skills_possessed;
        }
    }
    protected function initSkillProficiency ()
    {
        $this->initSkills_possessed();
        $skill_id = $this->getSkill_id();
        $skills_possessed = $this->getSkills_possessed();
        if (array_key_exists($skill_id, $skills_possessed)) {
            $this->setSkill_proficiency(
            $skills_possessed[$skill_id]['proficiency']);
        } else {
            $error = 'No skill entries exist for Skill Id ' . $skill_id;
            throw new Exception($error);
        }
    }
    protected function initLanguageProficiency ()
    {
        $language_id = $this->getLanguage_id();
        $languages_known = $this->getLanguages_known();
        if (array_key_exists($language_id, $languages_known)) {
            $this->setLanguage_proficiency(
            $languages_known[$language_id]['proficiency']);
        } else {
            $error = 'No language entries exist for Language Id ' . $language_id;
            throw new Exception($error);
        }
    }
}
