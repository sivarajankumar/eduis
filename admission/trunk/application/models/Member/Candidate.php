<?php
class Admsn_Model_Member_Candidate {
  protected $_mapper;
  
	/**
     * Set data mapper
     * 
     * @param  mixed $mapper 
     * @return Admsn_Model_Member_Candidate
     */
    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    /**
     * Roll number
     * @var string|integer
     */
    protected $_roll_no;
    
    /**
     * Get data mapper
     *
     * Lazy loads Admsn_Model_Mapper_Member_Candidate instance if no mapper registered.
     * 
     * @return Admsn_Model_Mapper_Member_Candidate
     */
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Admsn_Model_Mapper_Member_Candidate());
        }
        return $this->_mapper;
    }

    /**
     * Find an entry
     *
     * Resets entry state if matching id found.
     * 
     * @param  int $id 
     * @return Admsn_Model_Member_Candidate
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
    
    /**
     * Get if roll no of candidate exists
     * @return bool $applied - if roll no of candidate exists
     */
    public function exists(){
        return $this->getMapper()->exists($this);
    }
     
    /**
     * Set roll number
     * @param string|number $roll_no - roll number
     * @return Admsn_Model_Member_Candidate
     */
    public function setRoll_no($roll_no){
        $this->_roll_no = $roll_no;
        return $this;
    }
    
    /**
     * Get roll number
     * @return string|number $roll_no - roll number
     */
    public function getRoll_no(){
        if (isset($this->_roll_no)) {
            return $this->_roll_no;
        }
        throw new Zend_Exception('Roll number is not set!!', Zend_Log::ERR);
    }
    

    /**
     * Set image number
     * @param string|number $image_no - Image number
     * @return mixed
     */
    public function setImage_no($image_no){
          return $this->getMapper()
                ->getDbTable()
                ->getAdapter()
                ->query('UPDATE `applicants` SET `image_no`=? WHERE `roll_no`=?;',
                                array($image_no,self::getRoll_no()));
    }
}
    