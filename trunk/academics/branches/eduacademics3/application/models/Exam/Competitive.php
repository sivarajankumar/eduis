<?php
class Acad_Model_Exam_Competitive extends Acad_Model_Generic
{
    protected $_member_id;
    protected $_name;
    protected $_abbr;
    protected $_exam_id;
    protected $_roll_no;
    protected $_date;
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
     * @return the $_name
     */
    public function getName ()
    {
        return $this->_name;
    }
    /**
     * @param field_type $_name
     */
    public function setName ($_name)
    {
        $this->_name = $_name;
    }
    /**
     * @return the $_abbr
     */
    public function getAbbr ()
    {
        return $this->_abbr;
    }
    /**
     * @param field_type $_abbr
     */
    public function setAbbr ($_abbr)
    {
        $this->_abbr = $_abbr;
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
     * @return the $_roll_no
     */
    public function getRoll_no ()
    {
        return $this->_roll_no;
    }
    /**
     * @param field_type $_roll_no
     */
    public function setRoll_no ($_roll_no)
    {
        $this->_roll_no = $_roll_no;
    }
    /**
     * @return the $_date
     */
    public function getDate ()
    {
        return $this->_date;
    }
    /**
     * @param field_type $_date
     */
    public function setDate ($_date)
    {
        $this->_date = $_date;
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
     * @return Acad_Model_Exam_Competitive
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Exam_Competitive());
        }
        return $this->_mapper;
    }
    /**
     * 
     * Enter description here ...
     */
    public function fetchExamIds ()
    {
        $member_id = $this->getMember_id(true);
        $exam_ids = array();
        $exam_ids = $this->getMapper()->fetchExamIds($member_id);
        if (empty($exam_ids)) {
            return false;
        } else {
            return $exam_ids;
        }
    }
    public function fetchStudentExamInfo ()
    {
        $member_id = $this->getMember_id(true);
        $exam_id = $this->getExam_id(true);
        $student_exam_info = array();
        $student_exam_info = $this->getMapper()->fetchStudentExamInfo($member_id,$exam_id);
        if (empty($student_exam_info)) {
            return false;
        } else {
            $this->setOptions($student_exam_info);
        }
    }
}
?>