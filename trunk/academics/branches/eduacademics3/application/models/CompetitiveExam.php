<?php
class Acad_Model_CompetitiveExam extends Acad_Model_Generic
{
    protected $_exam_id;
    protected $_name;
    protected $_abbreviation;
    protected $_mapper;
    /**
     * @return the $_exam_id
     */
    public function getExam_id ($throw_exception = null)
    {
        $exam_id = $this->_exam_id;
        if (empty($exam_id) and $throw_exception == true) {
            $message = 'exam_id is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $exam_id;
        }
    }
    /**
     * @return the $_name
     */
    public function getName ()
    {
        return $this->_name;
    }
    /**
     * @return the $_abbreviation
     */
    public function getAbbreviation ()
    {
        return $this->_abbreviation;
    }
    /**
     * @param field_type $_exam_id
     */
    public function setExam_id ($_exam_id)
    {
        $this->_exam_id = $_exam_id;
    }
    /**
     * @param field_type $_name
     */
    public function setName ($_name)
    {
        $this->_name = $_name;
    }
    /**
     * @param field_type $_abbreviation
     */
    public function setAbbreviation ($_abbreviation)
    {
        $this->_abbreviation = $_abbreviation;
    }
    /**
     * Sets Mapper
     * @param Acad_Model_Mapper_CompetitiveExam $mapper
     * @return Acad_Model_CompetitiveExam
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_CompetitiveExam
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_CompetitiveExam());
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
     * Fetches Exam Details
     *
     */
    public function fetchInfo ()
    {
        $exam_id = $this->getExam_id(true);
        $info = $this->getMapper()->fetchInfo($exam_id);
        if (empty($info)) {
            return false;
        } else {
            $this->setOptions($info);
            return true;
        }
    }
    public function fetchExams ()
    {
        $comp_exams = $this->getMapper()->fetchExams();
        if (empty($comp_exams)) {
            return false;
        } else {
            return $comp_exams;
        }
    }
}