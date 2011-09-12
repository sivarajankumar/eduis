<?php
class Acad_Model_Exam_Diploma
{
    protected $_u_regn_no;
    protected $_marks_obtained;
    protected $_total_marks;
    protected $_percentage;
    protected $_remarks;
    protected $_passing_year;
    protected $_branch;
    protected $_board;
    protected $_institution;
    protected $_institution_city;
    protected $_institution_state;
    protected $_board_roll;
    protected $_migration_date;
    protected $_mapper;
    public function getU_regn_no ()
    {
        return $this->_u_regn_no;
    }
    public function setU_regn_no ($_u_regn_no)
    {
        $this->_u_regn_no = $_u_regn_no;
    }
    public function getMarks_obtained ()
    {
        return $this->_marks_obtained;
    }
    public function setMarks_obtained ($_marks_obtained)
    {
        $this->_marks_obtained = $_marks_obtained;
    }
    public function getTotal_marks ()
    {
        return $this->_total_marks;
    }
    public function setTotal_marks ($_total_marks)
    {
        $this->_total_marks = $_total_marks;
    }
    public function getPercentage ()
    {
        return $this->_percentage;
    }
    public function setPercentage ($_percentage)
    {
        $this->_percentage = $_percentage;
    }
    public function getRemarks ()
    {
        return $this->_remarks;
    }
    public function setRemarks ($_remarks)
    {
        $this->_remarks = $_remarks;
    }
    public function getPassing_year ()
    {
        return $this->_passing_year;
    }
    public function setPassing_year ($_passing_year)
    {
        $this->_passing_year = $_passing_year;
    }
    public function getBranch ()
    {
        return $this->_branch;
    }
    public function setBranch ($_branch)
    {
        $this->_branch = $_branch;
    }
    public function getBoard ()
    {
        return $this->_board;
    }
    public function setBoard ($_board)
    {
        $this->_board = $_board;
    }
    public function getInstitution ()
    {
        return $this->_institution;
    }
    public function setInstitution ($_institution)
    {
        $this->_institution = $_institution;
    }
    public function getInstitution_city ()
    {
        return $this->_institution_city;
    }
    public function setInstitution_city ($_institution_city)
    {
        $this->_institution_city = $_institution_city;
    }
    public function getInstitution_state ()
    {
        return $this->_institution_state;
    }
    public function setInstitution_state ($_institution_state)
    {
        $this->_institution_state = $_institution_state;
    }
    public function getBoard_roll ()
    {
        return $this->_board_roll;
    }
    public function setBoard_roll ($_board_roll)
    {
        $this->_board_roll = $_board_roll;
    }
    public function getMigration_date ()
    {
        return $this->_migration_date;
    }
    public function setMigration_date ($_migration_date)
    {
        $this->_migration_date = $_migration_date;
    }
    /**
     * Set Subject Mapper
     * @param Acad_Model_Mapper_Exam_Diploma $mapper
     * @return Acad_Model_Exam_Diploma
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Programme_DiplomaMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Exam_Diploma());
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
     * Gets Diploma information of a member
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