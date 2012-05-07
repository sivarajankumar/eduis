<?php
class Acad_Model_ClassInfo_Subject extends Acad_Model_Generic
{
    protected $_class_id;
    protected $_subject_id;
    protected $_mapper;
    protected $internal_max_marks;
    protected $internal_pass_marks;
    protected $external_max_marks;
    protected $external_pass_marks;
    /**
     * @return the $_class_id
     */
    public function getClass_id ($throw_exception = null)
    {
        $class_id = $this->_class_id;
        if (empty($class_id) and $throw_exception == true) {
            $message = '_class_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $class_id;
        }
    }
    /**
     * @return the $_subject_id
     */
    public function getSubject_id ($throw_exception = null)
    {
        $subject_id = $this->_subject_id;
        if (empty($subject_id) and $throw_exception == true) {
            $message = '_subject_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $subject_id;
        }
    }
    /**
     * @return the $internal_max_marks
     */
    public function getInternal_max_marks ()
    {
        return $this->internal_max_marks;
    }
    /**
     * @return the $internal_pass_marks
     */
    public function getInternal_pass_marks ()
    {
        return $this->internal_pass_marks;
    }
    /**
     * @return the $external_max_marks
     */
    public function getExternal_max_marks ()
    {
        return $this->external_max_marks;
    }
    /**
     * @return the $external_pass_marks
     */
    public function getExternal_pass_marks ()
    {
        return $this->external_pass_marks;
    }
    /**
     * @param field_type $_class_id
     */
    public function setClass_id ($_class_id)
    {
        $this->_class_id = $_class_id;
    }
    /**
     * @param field_type $_subject_id
     */
    public function setSubject_id ($_subject_id)
    {
        $this->_subject_id = $_subject_id;
    }
    /**
     * @param field_type $internal_max_marks
     */
    public function setInternal_max_marks ($internal_max_marks)
    {
        $this->internal_max_marks = $internal_max_marks;
    }
    /**
     * @param field_type $internal_pass_marks
     */
    public function setInternal_pass_marks ($internal_pass_marks)
    {
        $this->internal_pass_marks = $internal_pass_marks;
    }
    /**
     * @param field_type $external_max_marks
     */
    public function setExternal_max_marks ($external_max_marks)
    {
        $this->external_max_marks = $external_max_marks;
    }
    /**
     * @param field_type $external_pass_marks
     */
    public function setExternal_pass_marks ($external_pass_marks)
    {
        $this->external_pass_marks = $external_pass_marks;
    }
    /**
     * Sets Mapper
     * @param Acad_Model_Mapper_ClassInfo_Subject $mapper
     * @return Acad_Model_ClassInfo_Subject
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_ClassInfo_Subject
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_ClassInfo_Subject());
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
     * Fetches information regarding class
     *
     */
    public function fetchInfo ()
    {
        $class_id = $this->getClass_id(true);
        $subject_id = $this->getSubject_id(true);
        $info = $this->getMapper()->fetchInfo($class_id);
        if (empty($info)) {
            return false;
        } else {
            $this->setOptions($info);
            return $this;
        }
    }
    /**
     * Fetches Subjects of a class
     *
     */
    public function fetchClassSubjects ()
    {
        $class_id = $this->getClass_id(true);
        $info = $this->getMapper()->fetchClassSubjects($class_id);
        if (empty($info)) {
            return false;
        } else {
            return $info;
        }
    }
    /**
     * Fetches Subjects of a class
     *
     */
    public function fetchSubjectClasses ()
    {
        $subject_id = $this->getSubject_id(true);
        $info = $this->getMapper()->fetchSubjectClass($subject_id);
        if (empty($info)) {
            return false;
        } else {
            return $info;
        }
    }
}