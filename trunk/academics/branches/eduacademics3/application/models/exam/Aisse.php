<?php
class Acad_Model_Exam_Aisse
{
    protected $_member_id;
    protected $_marks_obtained;
    protected $_total_marks;
    protected $_percentage;
    protected $_roll_no;
    protected $_board;
    protected $_passing_year;
    protected $_school_rank;
    protected $_remarks;
    protected $_institution;
    protected $_city;
    protected $_state;
    protected $_mapper;
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    public function getMarks_obtained ()
    {
        return $this->_marks_obtained;
    }
    public function getTotal_marks ()
    {
        return $this->_total_marks;
    }
    public function getPercentage ()
    {
        return $this->_percentage;
    }
    public function getRoll_no ()
    {
        return $this->_roll_no;
    }
    public function getBoard ()
    {
        return $this->_board;
    }
    public function getPassing_year ()
    {
        return $this->_passing_year;
    }
    public function getSchool_rank ()
    {
        return $this->_school_rank;
    }
    public function getRemarks ()
    {
        return $this->_remarks;
    }
    public function getInstitution ()
    {
        return $this->_institution;
    }
    public function getCity ()
    {
        return $this->_city;
    }
    public function getState ()
    {
        return $this->_state;
    }
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    public function setMarks_obtained ($_marks_obtained)
    {
        $this->_marks_obtained = $_marks_obtained;
    }
    public function setTotal_marks ($_total_marks)
    {
        $this->_total_marks = $_total_marks;
    }
    public function setPercentage ($_percentage)
    {
        $this->_percentage = $_percentage;
    }
    public function setRoll_no ($_roll_no)
    {
        $this->_roll_no = $_roll_no;
    }
    public function setBoard ($_board)
    {
        $this->_board = $_board;
    }
    public function setPassing_year ($_passing_year)
    {
        $this->_passing_year = $_passing_year;
    }
    public function setSchool_rank ($_school_rank)
    {
        $this->_school_rank = $_school_rank;
    }
    public function setRemarks ($_remarks)
    {
        $this->_remarks = $_remarks;
    }
    public function setInstitution ($_institution)
    {
        $this->_institution = $_institution;
    }
    public function setCity ($_city)
    {
        $this->_city = $_city;
    }
    public function setState ($_state)
    {
        $this->_state = $_state;
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
    /**
     * @todo
     * Enter description here ...
     */
    public function save ()
    {
        $this->getMapper()->save($this);
    }
    /**
     * first set properties of object, according to which you want
     * to search,using constructor, then call the search function
     * 
     */
    public function search ()
    {
        return $this->getMapper()->fetchMemberId($this);
    }
    /**
     * Gets AISSE information of a member
     * You cant use it directly in 
     * controller,
     * first setMember_id and then call getter functions to retrieve properties.
     */
    public function initMemberExamInfo ()
    {
        $options = $this->getMapper()->fetchMemberExamInfo($this);
        $this->setOptions($options);
    }
}