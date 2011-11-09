<?php
class Acad_Model_Exam_Aisse extends Acad_Model_Generic
{
    protected $_member_id;
    protected $_marks_obtained;
    protected $_total_marks;
    protected $_percentage;
    protected $_board_roll_no;
    protected $_board;
    protected $_passing_year;
    protected $_school_rank;
    protected $_remarks;
    protected $_institution;
    protected $_city_name;
    protected $_state_name;
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
     * @return the $_marks_obtained
     */
    public function getMarks_obtained ()
    {
        return $this->_marks_obtained;
    }
    /**
     * @param field_type $_marks_obtained
     */
    public function setMarks_obtained ($_marks_obtained)
    {
        $this->_marks_obtained = $_marks_obtained;
    }
    /**
     * @return the $_total_marks
     */
    public function getTotal_marks ()
    {
        return $this->_total_marks;
    }
    /**
     * @param field_type $_total_marks
     */
    public function setTotal_marks ($_total_marks)
    {
        $this->_total_marks = $_total_marks;
    }
    /**
     * @return the $_percentage
     */
    public function getPercentage ()
    {
        return $this->_percentage;
    }
    /**
     * @param field_type $_percentage
     */
    public function setPercentage ($_percentage)
    {
        $this->_percentage = $_percentage;
    }
    /**
     * @return the $_board_roll_no
     */
    public function getBoard_roll_no ()
    {
        return $this->_board_roll_no;
    }
    /**
     * @param field_type $_board_roll_no
     */
    public function setBoard_roll_no ($_board_roll_no)
    {
        $this->_board_roll_no = $_board_roll_no;
    }
    /**
     * @return the $_board
     */
    public function getBoard ()
    {
        return $this->_board;
    }
    /**
     * @param field_type $_board
     */
    public function setBoard ($_board)
    {
        $this->_board = $_board;
    }
    /**
     * @return the $_passing_year
     */
    public function getPassing_year ()
    {
        return $this->_passing_year;
    }
    /**
     * @param field_type $_passing_year
     */
    public function setPassing_year ($_passing_year)
    {
        $this->_passing_year = $_passing_year;
    }
    /**
     * @return the $_school_rank
     */
    public function getSchool_rank ()
    {
        return $this->_school_rank;
    }
    /**
     * @param field_type $_school_rank
     */
    public function setSchool_rank ($_school_rank)
    {
        $this->_school_rank = $_school_rank;
    }
    /**
     * @return the $_remarks
     */
    public function getRemarks ()
    {
        return $this->_remarks;
    }
    /**
     * @param field_type $_remarks
     */
    public function setRemarks ($_remarks)
    {
        $this->_remarks = $_remarks;
    }
    /**
     * @return the $_institution
     */
    public function getInstitution ()
    {
        return $this->_institution;
    }
    /**
     * @param field_type $_institution
     */
    public function setInstitution ($_institution)
    {
        $this->_institution = $_institution;
    }
    /**
     * @return the $_city_name
     */
    public function getCity_name ()
    {
        return $this->_city_name;
    }
    /**
     * @param field_type $_city_name
     */
    public function setCity_name ($_city_name)
    {
        $this->_city_name = $_city_name;
    }
    /**
     * @return the $_state_name
     */
    public function getState_name ()
    {
        return $this->_state_name;
    }
    /**
     * @param field_type $_state_name
     */
    public function setState_name ($_state_name)
    {
        $this->_state_name = $_state_name;
    }
    /**
     * Set Aisse Mapper
     * @param Acad_Model_Mapper_Exam_Aisse $mapper - Aisse Mapper
     * @return Acad_Model_Exam_Aisse
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Exam_Aisse
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Exam_Aisse());
        }
        return $this->_mapper;
    }
    /**
     * Gets AISSE information of a member
     */
    public function initMemberExamInfo ()
    {
        $options = $this->getMapper()->fetchMemberExamInfo($this);
        $this->setOptions($options);
    }
}