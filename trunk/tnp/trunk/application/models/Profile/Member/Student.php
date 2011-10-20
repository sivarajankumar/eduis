<?php
/**
 * @package TNP
 *
 */
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
    protected $_class_properties = array('member_id', 'skill_id', 'skill_name', 
    'skill_field', 'skill_proficiency', 'language_id', 'language_name', 
    'language_proficiency', 'exists', 'is_locked', 'last_updated_on', 
    'job_preferred', 'achievements', 'activities', 'hobbies');
    public function getClass_properties ()
    {
        return $this->_class_properties;
    }
    public function setClass_properties ($_class_properties)
    {
        $this->_class_properties = $_class_properties;
    }
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    protected function getSkills_possessed ()
    {
        $skills_possessed = $this->_skills_possessed;
        if (sizeof($skills_possessed) == 0) {
            $skills_possessed = $this->getMapper()->fetchSkillsPossessedInfo(
            $this);
            $this->setSkills_possessed($skills_possessed);
        }
        return $this->_skills_possessed;
    }
    protected function setSkills_possessed ($_skills_possessed)
    {
        $this->_skills_possessed = $_skills_possessed;
    }
    protected function getLanguages_known ()
    {
        $languages_known = $this->_languages_known;
        if (sizeof($languages_known) == 0) {
            $languages_known = $this->getMapper()->fetchLanguagesKnownInfo(
            $this);
            $this->setLanguages_known($languages_known);
        }
        return $this->_languages_known;
    }
    protected function setLanguages_known ($_languages_known)
    {
        $this->_languages_known = $_languages_known;
    }
    public function getSkill_id ()
    {
        return $this->_skill_id;
    }
    public function setSkill_id ($_skill_id)
    {
        $this->_skill_id = $_skill_id;
    }
    public function getSkill_name ()
    {
        return $this->_skill_name;
    }
    public function setSkill_name ($_skill_name)
    {
        $this->_skill_name = $_skill_name;
    }
    public function getSkill_field ()
    {
        return $this->_skill_field;
    }
    public function setSkill_field ($_skill_field)
    {
        $this->_skill_field = $_skill_field;
    }
    public function getSkill_proficiency ()
    {
        return $this->_skill_proficiency;
    }
    public function setSkill_proficiency ($_skill_proficiency)
    {
        $this->_skill_proficiency = $_skill_proficiency;
    }
    public function getLanguage_id ()
    {
        return $this->_language_id;
    }
    public function setLanguage_id ($_language_id)
    {
        $this->_language_id = $_language_id;
    }
    public function getLanguage_name ()
    {
        return $this->_language_name;
    }
    public function setLanguage_name ($_language_name)
    {
        $this->_language_name = $_language_name;
    }
    public function getLanguage_proficiency ()
    {
        return $this->_language_proficiency;
    }
    public function setLanguage_proficiency ($_language_proficiency)
    {
        $this->_language_proficiency = $_language_proficiency;
    }
    public function getExists ()
    {
        return $this->_exists;
    }
    public function setExists ($_exists)
    {
        $this->_exists = $_exists;
    }
    public function getIs_locked ()
    {
        return $this->_is_locked;
    }
    public function setIs_locked ($_is_locked)
    {
        $this->_is_locked = $_is_locked;
    }
    public function getLast_updated_on ()
    {
        return $this->_last_updated_on;
    }
    public function setLast_updated_on ($_last_updated_on)
    {
        $this->_last_updated_on = $_last_updated_on;
    }
    public function getJob_preferred ()
    {
        return $this->_job_preferred;
    }
    public function setJob_preferred ($_job_preferred)
    {
        $this->_job_preferred = $_job_preferred;
    }
    public function getAchievements ()
    {
        return $this->_achievements;
    }
    public function setAchievements ($_achievements)
    {
        $this->_achievements = $_achievements;
    }
    public function getActivities ()
    {
        return $this->_activities;
    }
    public function setActivities ($_activities)
    {
        $this->_activities = $_activities;
    }
    public function getHobbies ()
    {
        return $this->_hobbies;
    }
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
     * @return Tnp_Model_Mapper_Profile_Member_Student
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
    public function initProfileStatusInfo ()
    {
        $options = $this->getMapper()->fetchProfileStatusInfo($this);
        $this->setOptions($options);
    }
    public function getMemberSkillIds ()
    {
        $possessed_skills = $this->getSkills_possessed();
        $possessed_skills_ids = array_keys($possessed_skills);
        if (sizeof($possessed_skills_ids) == 0) {
            $error = 'No skills registered for ' . $this->getMember_id();
            throw new Exception($error);
        } else {
            return $possessed_skills_ids;
        }
    }
    public function getMemberLanguageKnownIds ()
    {
        $languages_known = $this->getLanguages_known();
        $language_ids = array_keys($languages_known);
        if (sizeof($language_ids) == 0) {
            $error = 'languages known are not registered for ' .
             $this->getMember_id();
            throw new Exception($error);
        } else {
            return $language_ids;
        }
    }
    public function initSkillInfo ()
    {
        $options = $this->getMapper()->fetchSkillInfo($this);
        $this->setOptions($options);
    }
    public function initLanguageInfo ()
    {
        $options = $this->getMapper()->fetchLanguageInfo($this);
        $this->setOptions($options);
    }
    public function initMemberSkillInfo ()
    {
        $skills_possessed = $this->getSkills_possessed();
        $skill_id = $this->getSkill_id();
        if (array_key_exists($skill_id, $skills_possessed)) {
            $options = $skills_possessed[$skill_id];
            $this->setOptions($options);
        } else {
            $error = 'No skill entries exist for Skill Id ' . $skill_id;
            throw new Exception($error);
        }
    }
    public function initMemberLanguageInfo ()
    {
        $languages_known = $this->getLanguages_known();
        $language_id = $this->getLanguage_id();
        if (array_key_exists($language_id, $languages_known)) {
            $options = $languages_known[$language_id];
            $this->setOptions($options);
        } else {
            $error = 'No language entries exist for Language Id ' . $language_id;
            throw new Exception($error);
        }
    }
    public function initCoCuricularInfo ()
    {
        $options = $this->getMapper()->fetchCoCuricularInfo($this);
        $this->setOptions($options);
    }
    public function initJobPreferredInfo ()
    {
        $options = $this->getMapper()->fetchJobPreferredInfo($this);
        $this->setOptions($options);
    }
    /**
     * 
     * Enter description here ...
     * @param array $options containing properties mapped to values
     * @param array $property_range containing properties mapped to array containing upper and lower range
     * @throws Exception when trying to set equality and range both ,for property, at the same time
     * @throws Exception when invalid properties are specified 
     * @return array containing Member Ids
     */
    public function search (array $options = null, array $property_range = null)
    {
        $class_properties = array();
        $options_keys = array();
        $valid_options = array();
        $invalid_options = array();
        $setter_options = array();
        $property_range_keys = array();
        $valid_range_keys = array();
        $invalid_range_keys = array();
        $range = array();
        $error = '';
        $class_properties = $this->getClass_properties();
        if (! empty($options)) {
            $options_keys = array_keys($options);
            $valid_options = array_intersect($options_keys, $class_properties);
            foreach ($valid_options as $valid_option) {
                //$setter_options array is now ready for search
                //but will it participate,is not confirmed
                $setter_options[$valid_option] = $options[$valid_option];
            }
            $invalid_options = array_diff($options_keys, $class_properties);
            if (! empty($invalid_options)) {
                $error = implode(', ', $invalid_range_keys);
            }
        }
        if (! empty($property_range)) {
            $property_range_keys = array_keys($property_range);
            $valid_range_keys = array_intersect($property_range_keys, 
            $class_properties);
            foreach ($valid_range_keys as $valid_range_key) {
                //$range array is now ready for search
                //but will it participate,is not confirmed
                $range[$valid_range_key] = $property_range[$valid_range_key];
            }
            $invalid_range_keys = array_diff($property_range_keys, 
            $class_properties);
            if (! empty($invalid_range_keys)) {
                $error = implode(', ', $invalid_range_keys);
            }
        }
        $user_friendly_message = $error .
         ' are invalid parameters and therefore were not included in search.' .
         'Please try again with correct parameters to get more accurate results';
        if(!empty($error))
        {
        	Zend_Registry::get('logger')->debug($user_friendly_message);
        }
        $deciding_intersection = array_intersect($valid_options, 
        $valid_range_keys);
        if (empty($deciding_intersection)) {
            //now we can set off for search operation
            $this->setOptions($setter_options);
            $result = $this->getMapper()->fetchStudents($this, $setter_options, 
            $range);
            return $result;
        } else {
            foreach ($deciding_intersection as $duplicate_entry) {
                $error_1 = $error_1 . '  ' . $duplicate_entry;
            }
            throw new Exception(
            'Range and equality cannot be set for ' . $error_1 .
             ' at the same time');
        }
    }
}
