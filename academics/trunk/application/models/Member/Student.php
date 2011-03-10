<?php
class Acad_Model_Member_Student extends Acad_Model_Member_Generic {
  protected $_mapper;
    
    /**
     * Set roll number of student
     * 
     * Since roll number and member Id are same.
     * 
     * @param string|int $rollNumber Roll number
     * @return Acad_Model_Member_Student
     */
    public function setRollNumber($rollNumber)
    {
        return self::setMemberId($rollNumber);
    }
    
    /**
     * Get roll number of student
     * 
     * Since roll number and member Id are same.
     * 
     * @return string|int $rollNumber Roll number
     */
    public function getRollNumber()
    {
        return self::getMemberId();
    }
    
    public function getAttendence($dateFrom=null,$dateUpto=null)
    {
        
    }
	
/**
     * Set data mapper
     * 
     * @param  mixed $mapper 
     * @return Acad_Model_Student
     */
    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    /**
     * Get data mapper
     *
     * Lazy loads Acad_Model_StudentMapper instance if no mapper registered.
     * 
     * @return Acad_Model_StudentMapper
     */
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_StudentMapper());
        }
        return $this->_mapper;
    }
	  /**
     * Save the current entry
     * 
     * @return void
     */
    public function save()
    {
        $this->getMapper()->save($this);
    }

    /**
     * Find an entry
     *
     * Resets entry state if matching id found.
     * 
     * @param  int $id 
     * @return Acad_Model_Student
     */
    public function find($id)
    {
        $this->getMapper()->find($id, $this);
        return $this;
    }

    /**
     * Fetch all entries
     * 
     * @return array
     */
    public function fetchAll()
    {
        return $this->getMapper()->fetchAll();
    }
}
    