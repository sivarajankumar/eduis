<?php
class Acad_Model_Subject extends Acad_Model_Generic
{
    protected $_subject_id;
    protected $_subject_code;
    protected $_abbr;
    protected $_subject_name;
    protected $_subject_type_id;
    protected $_is_optional;
    protected $_lecture_per_week;
    protected $_tutorial_per_week;
    protected $_practical_per_week;
    protected $_suggested_duration;
    protected $_mapper;
    /**
     * @return the $_subject_id
     */
    public function getSubject_id ()
    {
        return $this->_subject_id;
    }
    /**
     * @return the $_subject_code
     */
    public function getSubject_code ()
    {
        return $this->_subject_code;
    }
    /**
     * @return the $_abbr
     */
    public function getAbbr ()
    {
        return $this->_abbr;
    }
    /**
     * @return the $_subject_name
     */
    public function getSubject_name ()
    {
        return $this->_subject_name;
    }
    /**
     * @return the $_subject_type_id
     */
    public function getSubject_type_id ()
    {
        return $this->_subject_type_id;
    }
    /**
     * @return the $_is_optional
     */
    public function getIs_optional ()
    {
        return $this->_is_optional;
    }
    /**
     * @return the $_lecture_per_week
     */
    public function getLecture_per_week ()
    {
        return $this->_lecture_per_week;
    }
    /**
     * @return the $_tutorial_per_week
     */
    public function getTutorial_per_week ()
    {
        return $this->_tutorial_per_week;
    }
    /**
     * @return the $_practical_per_week
     */
    public function getPractical_per_week ()
    {
        return $this->_practical_per_week;
    }
    /**
     * @return the $_suggested_duration
     */
    public function getSuggested_duration ()
    {
        return $this->_suggested_duration;
    }
    /**
     * @param field_type $_subject_id
     */
    public function setSubject_id ($_subject_id)
    {
        $this->_subject_id = $_subject_id;
    }
    /**
     * @param field_type $_subject_code
     */
    public function setSubject_code ($_subject_code)
    {
        $this->_subject_code = $_subject_code;
    }
    /**
     * @param field_type $_abbr
     */
    public function setAbbr ($_abbr)
    {
        $this->_abbr = $_abbr;
    }
    /**
     * @param field_type $_subject_name
     */
    public function setSubject_name ($_subject_name)
    {
        $this->_subject_name = $_subject_name;
    }
    /**
     * @param field_type $_subject_type_id
     */
    public function setSubject_type_id ($_subject_type_id)
    {
        $this->_subject_type_id = $_subject_type_id;
    }
    /**
     * @param field_type $_is_optional
     */
    public function setIs_optional ($_is_optional)
    {
        $this->_is_optional = $_is_optional;
    }
    /**
     * @param field_type $_lecture_per_week
     */
    public function setLecture_per_week ($_lecture_per_week)
    {
        $this->_lecture_per_week = $_lecture_per_week;
    }
    /**
     * @param field_type $_tutorial_per_week
     */
    public function setTutorial_per_week ($_tutorial_per_week)
    {
        $this->_tutorial_per_week = $_tutorial_per_week;
    }
    /**
     * @param field_type $_practical_per_week
     */
    public function setPractical_per_week ($_practical_per_week)
    {
        $this->_practical_per_week = $_practical_per_week;
    }
    /**
     * @param field_type $_suggested_duration
     */
    public function setSuggested_duration ($_suggested_duration)
    {
        $this->_suggested_duration = $_suggested_duration;
    }
    /**
     * Sets Mapper
     * @param Acad_Model_Mapper_Subject $mapper
     * @return Acad_Model_Subject
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Subject
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Subject());
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
     */
    public function initInfo ()
    {}
    /**
     * Fetches information regarding Subject
     *
     */
    public function fetchInfo ()
    {
        $subject_id = $this->getSubject_id(true);
        $info = $this->getMapper()->fetchInfo($subject_id);
        if (empty($info)) {
            return false;
        } else {
            $this->setOptions($info);
            return $this;
        }
    }
}