<?php
class Acad_Model_Exam_Competitive
{
    protected $_competitive_exam_name;
    protected $_competitive_exam_abbr;
    protected $_competitive_exam_id;
    protected $_u_regn_no;
    protected $_exam_roll_no;
    protected $_exam_date;
    protected $_total_score;
    protected $_all_india_rank;
    protected $_mapper;
    public function getCompetitive_exam_name ()
    {
        return $this->_competitive_exam_name;
    }
    public function setCompetitive_exam_name ($_competitive_exam_name)
    {
        $this->_competitive_exam_name = $_competitive_exam_name;
    }
    public function getCompetitive_exam_abbr ()
    {
        return $this->_competitive_exam_abbr;
    }
    public function setCompetitive_exam_abbr ($_competitive_exam_abbr)
    {
        $this->_competitive_exam_abbr = $_competitive_exam_abbr;
    }
    public function getCompetitive_exam_id ()
    {
        return $this->_competitive_exam_id;
    }
    public function setCompetitive_exam_id ($_competitive_exam_id)
    {
        $this->_competitive_exam_id = $_competitive_exam_id;
    }
    public function getU_regn_no ()
    {
        return $this->_u_regn_no;
    }
    public function setU_regn_no ($_u_regn_no)
    {
        $this->_u_regn_no = $_u_regn_no;
    }
    public function getExam_roll_no ()
    {
        return $this->_exam_roll_no;
    }
    public function setExam_roll_no ($_exam_roll_no)
    {
        $this->_exam_roll_no = $_exam_roll_no;
    }
    public function getExam_date ()
    {
        return $this->_exam_date;
    }
    public function setExam_date ($_exam_date)
    {
        $this->_exam_date = $_exam_date;
    }
    public function getTotal_score ()
    {
        return $this->_total_score;
    }
    public function setTotal_score ($_total_score)
    {
        $this->_total_score = $_total_score;
    }
    public function getAll_india_rank ()
    {
        return $this->_all_india_rank;
    }
    public function setAll_india_rank ($_all_india_rank)
    {
        $this->_all_india_rank = $_all_india_rank;
    }
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
            $this->setMapper(new Acad_Model_Exam_CompetitiveMapper());
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
     * Gets AISSCE information of a member
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
?>