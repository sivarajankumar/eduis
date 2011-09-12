<?php
class Acad_Model_Exam_Aisse
{
    protected $_u_regn_no;
    protected $_matric_marks_obtained;
    protected $_matric_total_marks;
    protected $_matric_percentage;
    protected $_matric_roll_no;
    protected $_matric_board;
    protected $_matric_passing_year;
    protected $_matric_school_rank;
    protected $_matric_remarks;
    protected $_matric_institution;
    protected $_matric_city;
    protected $_matric_state;
    protected $_mapper;
    public function getU_regn_no ()
    {
        return $this->_u_regn_no;
    }
    public function setU_regn_no ($_u_regn_no)
    {
        $this->_u_regn_no = $_u_regn_no;
    }
    public function getMatric_marks_obtained ()
    {
        return $this->_matric_marks_obtained;
    }
    public function setMatric_marks_obtained ($_matric_marks_obtained)
    {
        $this->_matric_marks_obtained = $_matric_marks_obtained;
    }
    public function getMatric_total_marks ()
    {
        return $this->_matric_total_marks;
    }
    public function setMatric_total_marks ($_matric_total_marks)
    {
        $this->_matric_total_marks = $_matric_total_marks;
    }
    public function getMatric_percentage ()
    {
        return $this->_matric_percentage;
    }
    public function setMatric_percentage ($_matric_percentage)
    {
        $this->_matric_percentage = $_matric_percentage;
    }
    public function getMatric_roll_no ()
    {
        return $this->_matric_roll_no;
    }
    public function setMatric_roll_no ($_matric_roll_no)
    {
        $this->_matric_roll_no = $_matric_roll_no;
    }
    public function getMatric_board ()
    {
        return $this->_matric_board;
    }
    public function setMatric_board ($_matric_board)
    {
        $this->_matric_board = $_matric_board;
    }
    public function getMatric_passing_year ()
    {
        return $this->_matric_passing_year;
    }
    public function setMatric_passing_year ($_matric_passing_year)
    {
        $this->_matric_passing_year = $_matric_passing_year;
    }
    public function getMatric_school_rank ()
    {
        return $this->_matric_school_rank;
    }
    public function setMatric_school_rank ($_matric_school_rank)
    {
        $this->_matric_school_rank = $_matric_school_rank;
    }
    public function getMatric_remarks ()
    {
        return $this->_matric_remarks;
    }
    public function setMatric_remarks ($_matric_remarks)
    {
        $this->_matric_remarks = $_matric_remarks;
    }
    public function getMatric_institution ()
    {
        return $this->_matric_institution;
    }
    public function setMatric_institution ($_matric_institution)
    {
        $this->_matric_institution = $_matric_institution;
    }
    public function getMatric_city ()
    {
        return $this->_matric_city;
    }
    public function setMatric_city ($_matric_city)
    {
        $this->_matric_city = $_matric_city;
    }
    public function getMatric_state ()
    {
        return $this->_matric_state;
    }
    public function setMatric_state ($_matric_state)
    {
        $this->_matric_state = $_matric_state;
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
     * @return Acad_Model_Exam_AisseMapper
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
            throw new Zend_Exception('Invalid property specified');
        }
        $this->$method($value);
    }
    public function __get ($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw new Zend_Exception('Invalid property specified');
        }
        return $this->$method();
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
    public function getMemberExamDetails ()
    {
    	$options = $this->getMapper()->fetchMemberExamDetails($this);
        $this->setOptions($options);
    }
}