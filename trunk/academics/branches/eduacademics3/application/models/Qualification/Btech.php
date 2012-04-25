<?php
class Acad_Model_Qualification_Btech extends Acad_Model_Generic
{
    protected $_member_id;
    protected $_qualification_id;
    protected $_discipline_id;
    protected $_marks_obtained;
    protected $_total_marks;
    protected $_percentage;
    protected $_passing_year;
    protected $_istitution;
    protected $_university;
    protected $_city_name;
    protected $_state_name;
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
     * @return the $_discipline_id
     */
    public function getDiscipline_id ()
    {
        return $this->_discipline_id;
    }
    /**
     * @param field_type $_discipline_id
     */
    public function setDiscipline_id ($_discipline_id)
    {
        $this->_discipline_id = $_discipline_id;
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
     * @return the $_istitution
     */
    public function getIstitution ()
    {
        return $this->_istitution;
    }
    /**
     * @param field_type $_istitution
     */
    public function setIstitution ($_istitution)
    {
        $this->_istitution = $_istitution;
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
     * @param Acad_Model_Mapper_Qualification_Btech $mapper
     * @return Acad_Model_Qualification_Btech
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Qualification_Btech
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Qualification_Btech());
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
     * Fetches BTech information of a Member
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