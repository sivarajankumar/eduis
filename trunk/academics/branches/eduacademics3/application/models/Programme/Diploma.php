<?php
class Acad_Model_Programme_Diploma extends Acad_Model_Generic
{
    protected $_member_id;
    //protected $_discipline_id;
    protected $_discipline_name;
    protected $_university;
    protected $_marks_obtained;
    protected $_total_marks;
    protected $_percentage;
    protected $_remarks;
    protected $_passing_year;
    protected $_board;
    protected $_institution;
    protected $_city_name;
    protected $_state_name;
    protected $_board_roll_no;
    protected $_migration_date;
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
     * @return the $_discipline_name
     */
    public function getDiscipline_name ()
    {
        return $this->_discipline_name;
    }
    /**
     * @return the $_university
     */
    public function getUniversity ()
    {
        return $this->_university;
    }
    /**
     * @param field_type $_university
     */
    public function setUniversity ($_university)
    {
        $this->_university = $_university;
    }
    /**
     * @param field_type $_discipline_name
     */
    public function setDiscipline_name ($_discipline_name)
    {
        $this->_discipline_name = $_discipline_name;
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
     * @return the $_board
     */
    public function getBoard ()
    {
        return $this->_board;
    }
    /**
     * @return the $_board_roll_no
     */
    public function getBoard_roll_no ()
    {
        return $this->_board_roll_no;
    }
    /**
     * @param field_type $_board
     */
    public function setBoard ($_board)
    {
        $this->_board = $_board;
    }
    /**
     * @param field_type $_board_roll_no
     */
    public function setBoard_roll_no ($_board_roll_no)
    {
        $this->_board_roll_no = $_board_roll_no;
    }
    /**
     * @return the $_board_roll
     */
    public function getBoard_roll ()
    {
        return $this->_board_roll;
    }
    /**
     * @param field_type $_board_roll
     */
    public function setBoard_roll ($_board_roll)
    {
        $this->_board_roll = $_board_roll;
    }
    /**
     * @return the $_migration_date
     */
    public function getMigration_date ()
    {
        return $this->_migration_date;
    }
    /**
     * @param field_type $_migration_date
     */
    public function setMigration_date ($_migration_date)
    {
        $this->_migration_date = $_migration_date;
    }
    /**
     * Set Subject Mapper
     * @param Acad_Model_Mapper_Programme_Diploma $mapper
     * @return Acad_Model_Programme_Diploma
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Programme_Diploma
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Programme_Diploma());
        }
        return $this->_mapper;
    }
    public function initMemberExamInfo ()
    {
        $options = $this->getMapper()->fetchMemberExamInfo($this);
        $this->setOptions($options);
    }
    /*public function initDisciplineInfo ()
    {
        $options = $this->getMapper()->fetchDisciplineInfo($this);
        $this->setOptions($options);
    }*/
}