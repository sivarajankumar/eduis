<?php
class Tnp_Model_Skill extends Tnp_Model_Generic
{
    protected $_skill_id;
    protected $_skill_name;
    protected $_skill_field;
    protected $_mapper;
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
     * @return the $_skill_name
     */
    public function getSkill_name ($throw_exception = null)
    {
        $skill_name = $this->_skill_name;
        if (empty($skill_name) and $throw_exception == true) {
            $message = '_skill_name is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $skill_name;
        }
    }
    /**
     * @return the $_skill_field
     */
    public function getSkill_field ($throw_exception = null)
    {
        $skill_field = $this->_skill_field;
        if (empty($skill_field) and $throw_exception == true) {
            $message = '_skill_field is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $skill_field;
        }
    }
    /**
     * @param field_type $_skill_id
     */
    public function setSkill_id ($_skill_id)
    {
        $this->_skill_id = $_skill_id;
    }
    /**
     * @param field_type $_skill_name
     */
    public function setSkill_name ($_skill_name)
    {
        $this->_skill_name = $_skill_name;
    }
    /**
     * @param field_type $_skill_field
     */
    public function setSkill_field ($_skill_field)
    {
        $this->_skill_field = $_skill_field;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_Skill $mapper
     * @return Tnp_Model_Skill
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Skill
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_Skill());
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
     *@return array ,Format =array($language_id=>$language_name)
     */
    public function fetchSkills ()
    {
        $skills = array();
        $skills = $this->getMapper()->fetchSkills();
        if (empty($skills)) {
            return false;
        } else {
            return $skills;
        }
    }
    public function fetchInfo ()
    {
        $skill_id = $this->getSkill_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($skill_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
    public function fetchSkillIds ()
    {
        $skill_ids = array();
        $skill_ids = $this->getMapper()->fetchSkillids();
        if (empty($skill_ids)) {
            return false;
        } else {
            return $skill_ids;
        }
    }
    public function saveInfo ($data_array)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($data_array);
        return $this->getMapper()->save($prepared_data);
    }
    public function updateInfo ($data_array)
    {
        $skill_id = $this->getSkill_id(true);
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($data_array);
        return $this->getMapper()->update($prepared_data, $skill_id);
    }
    public function deleteSkills ()
    {
        $skill_id = $this->getSkill_id(true);
        return $this->getMapper()->delete($skill_id);
    }
}