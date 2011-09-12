<?php
class Acad_Model_Course_SubjectDmc
{
    protected $_u_regn_no;
    protected $_subject_code;
    protected $_marks;
    protected $_appear_type;
    protected $_dmc_id;
    protected $_custody_date;
    protected $_is_granted;
    protected $_grant_date;
    protected $_recieving_date;
    protected $_is_copied;
    protected $_dispatch_date;
    protected $_total_marks;
    protected $_scaled_marks;
    protected $_mapper;
	public function getU_regn_no() {
		return $this->_u_regn_no;
	}

	public function setU_regn_no($_u_regn_no) {
		$this->_u_regn_no = $_u_regn_no;
	}

	public function getSubject_code() {
		return $this->_subject_code;
	}

	public function setSubject_code($_subject_code) {
		$this->_subject_code = $_subject_code;
	}

	public function getMarks() {
		return $this->_marks;
	}

	public function setMarks($_marks) {
		$this->_marks = $_marks;
	}

	public function getAppear_type() {
		return $this->_appear_type;
	}

	public function setAppear_type($_appear_type) {
		$this->_appear_type = $_appear_type;
	}

	public function getDmc_id() {
		return $this->_dmc_id;
	}

	public function setDmc_id($_dmc_id) {
		$this->_dmc_id = $_dmc_id;
	}

	public function getCustody_date() {
		return $this->_custody_date;
	}

	public function setCustody_date($_custody_date) {
		$this->_custody_date = $_custody_date;
	}

	public function getIs_granted() {
		return $this->_is_granted;
	}

	public function setIs_granted($_is_granted) {
		$this->_is_granted = $_is_granted;
	}

	public function getGrant_date() {
		return $this->_grant_date;
	}

	public function setGrant_date($_grant_date) {
		$this->_grant_date = $_grant_date;
	}

	public function getRecieving_date() {
		return $this->_recieving_date;
	}

	public function setRecieving_date($_recieving_date) {
		$this->_recieving_date = $_recieving_date;
	}

	public function getIs_copied() {
		return $this->_is_copied;
	}

	public function setIs_copied($_is_copied) {
		$this->_is_copied = $_is_copied;
	}

	public function getDispatch_date() {
		return $this->_dispatch_date;
	}

	public function setDispatch_date($_dispatch_date) {
		$this->_dispatch_date = $_dispatch_date;
	}

	public function getTotal_marks() {
		return $this->_total_marks;
	}

	public function setTotal_marks($_total_marks) {
		$this->_total_marks = $_total_marks;
	}

	public function getScaled_marks() {
		return $this->_scaled_marks;
	}

	public function setScaled_marks($_scaled_marks) {
		$this->_scaled_marks = $_scaled_marks;
	}
	/**
	 * 
	 * @param Acad_Model_Mapper_Course_SubjectDmc $mapper
	 * @return Acad_Model_Course_SubjectDmc
	 */
	public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Course_SubjectDmc
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(
            new Acad_Model_Mapper_Course_SubjectDmc());
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
    /**
     * 
     * @throws Zend_Exception
     */
    public function __get ($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw new Zend_Exception('Invalid property specified');
        } else {
            if (! isset($this->$name)) {
                $fetchMethodName = 'fetch' . $name;
                if (method_exists($this->getMapper(), $fetchMethodName)) {
                    $result = $this->getMapper()->$fetchMethodName;
                    $setMethodName = 'set' . $name;
                    $this->$setMethodName($result);
                    return $this->$method();
                } else {
                    throw new Zend_Exception(
                    'Value not set for'.$name);
                }
            } else {
                return $this->$method();
            }
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
     * must include a check that no undesirable properties are set before saving
     * ex : some properties are defined to just simplify search or are to be used as read only i-e
     * they must not be set by controller.. if set they must be detected here...
     * but this is not a problem bcoz save function will save only those properties 
     * for which it is designed to save
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
     * 
     * gets the marks of student in a subject..
     * by deafult includes all appear types
     */
    public function getMarksHistory(){
        return $this->getMapper()->fetchMarksHistory($this);
        
    }
    /**
     * gets the details of a SubjectDMC
     * PreRequistes - either (regNo, subCode AND marks must be set)
     * or (dmcId must be set)
     */
    protected function getDetails ()
    {
        $options = $this->getMapper()->fetchDetails($this);
        $this->setOptions($options);
    }

}