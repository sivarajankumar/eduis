<?php
class Acad_Model_Qualification_Matric extends Acad_Model_Generic
{
    protected $_member_id;
    protected $_qualification_id;
    protected $_board;
    protected $_board_roll_no;
    protected $_marks_obtained;
    protected $_total_marks;
    protected $_percentage;
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
     * @return the $_qualification_id
     */
    public function getQualification_id ()
    {
        return $this->_qualification_id;
    }
    /**
     * @param field_type $_qualification_id
     */
    public function setQualification_id ($_qualification_id)
    {
        $this->_qualification_id = $_qualification_id;
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
     * Sets Mapper
     * @param Acad_Model_Mapper_Qualification_Matric $mapper
     * @return Acad_Model_Qualification_Matric
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Qualification_Matric
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Qualification_Matric());
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
     * Fetches Matric information of a Member
     *
     */
    public function fetchInfo ()
    {
        $member_id = $this->getMember_id();
        if (empty($member_id)) {
            $careless_error = 'Please provide a Member Id';
            throw new Exception($careless_error);
        } else {
            $info = $this->getMapper()->fetchInfo($member_id);
            if (sizeof($info) == 0) {
                return false;
            } else {
                $this->setOptions($info);
                return true;
            }
        }
    }
}