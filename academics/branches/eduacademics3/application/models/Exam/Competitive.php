<?php
class Acad_Model_Exam_Competitive extends Acad_Model_Generic
{
    protected $_member_id;
    protected $_exam_name;
    protected $_exam_abbr;
    protected $_exam_id;
    protected $_exam_roll_no;
    protected $_exam_date;
    protected $_total_score;
    protected $_all_india_rank;
    protected $_mapper;
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
     * @return the $_exam_name
     */
    public function getExam_name ()
    {
        return $this->_exam_name;
    }
    /**
     * @param field_type $_exam_name
     */
    public function setExam_name ($_exam_name)
    {
        $this->_exam_name = $_exam_name;
    }
    /**
     * @return the $_exam_abbr
     */
    public function getExam_abbr ()
    {
        return $this->_exam_abbr;
    }
    /**
     * @param field_type $_exam_abbr
     */
    public function setExam_abbr ($_exam_abbr)
    {
        $this->_exam_abbr = $_exam_abbr;
    }
    /**
     * @return the $_exam_id
     */
    public function getExam_id ()
    {
        return $this->_exam_id;
    }
    /**
     * @param field_type $_exam_id
     */
    public function setExam_id ($_exam_id)
    {
        $this->_exam_id = $_exam_id;
    }
    /**
     * @return the $_exam_roll_no
     */
    public function getExam_roll_no ()
    {
        return $this->_exam_roll_no;
    }
    /**
     * @param field_type $_exam_roll_no
     */
    public function setExam_roll_no ($_exam_roll_no)
    {
        $this->_exam_roll_no = $_exam_roll_no;
    }
    /**
     * @return the $_exam_date
     */
    public function getExam_date ()
    {
        return $this->_exam_date;
    }
    /**
     * @param field_type $_exam_date
     */
    public function setExam_date ($_exam_date)
    {
        $this->_exam_date = $_exam_date;
    }
    /**
     * @return the $_total_score
     */
    public function getTotal_score ()
    {
        return $this->_total_score;
    }
    /**
     * @param field_type $_total_score
     */
    public function setTotal_score ($_total_score)
    {
        $this->_total_score = $_total_score;
    }
    /**
     * @return the $_all_india_rank
     */
    public function getAll_india_rank ()
    {
        return $this->_all_india_rank;
    }
    /**
     * @param field_type $_all_india_rank
     */
    public function setAll_india_rank ($_all_india_rank)
    {
        $this->_all_india_rank = $_all_india_rank;
    }
    /**
     * Set Subject Mapper
     * @param Acad_Model_Mapper_Exam_Competitive $mapper
     * @return Acad_Model_Exam_Competitive
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Exam_CompetitiveMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Exam_Competitive());
        }
        return $this->_mapper;
    }
    /**
     * Gets Competitive exam information of a member
     * 
     */
    public function initMemberExamInfo ()
    {
        $options = $this->getMapper()->fetchMemberExamInfo($this);
        $this->setOptions($options);
    }
    /**
     * Gets Competitive exam information of a member
     * 
     */
    public function initExamInfo ()
    {
        $options = $this->getMapper()->fetchExamInfo($this);
        $this->setOptions($options);
    }
    /**
     * Initialises the save process
     * by unsetting all object properties
     */
    public function initSave ()
    {
        $this->unsetAll();
        $this->setInit_save(true);
    }
}
?>