<?php
class Core_Model_Relative
{
    protected $_member_id;
    protected $_relation_id;
    protected $_relation_name;
    protected $_name;
    protected $_occupation;
    protected $_designation;
    protected $_office_add;
    protected $_contact;
    protected $_annual_income;
    protected $_landline_no;
    protected $_mapper;
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    public function getRelation_id ()
    {
        return $this->_relation_id;
    }
    public function setRelation_id ($_relation_id)
    {
        $this->_relation_id = $_relation_id;
    }
    public function getRelation_name ()
    {
        return $this->_relation_name;
    }
    public function setRelation_name ($_relation_name)
    {
        $this->_relation_name = $_relation_name;
    }
    public function getName ()
    {
        return $this->_name;
    }
    public function setName ($_name)
    {
        $this->_name = $_name;
    }
    public function getOccupation ()
    {
        return $this->_occupation;
    }
    public function setOccupation ($_occupation)
    {
        $this->_occupation = $_occupation;
    }
    public function getDesignation ()
    {
        return $this->_designation;
    }
    public function setDesignation ($_designation)
    {
        $this->_designation = $_designation;
    }
    public function getOffice_add ()
    {
        return $this->_office_add;
    }
    public function setOffice_add ($_office_add)
    {
        $this->_office_add = $_office_add;
    }
    public function getContact ()
    {
        return $this->_contact;
    }
    public function setContact ($_contact)
    {
        $this->_contact = $_contact;
    }
    public function getAnnual_income ()
    {
        return $this->_annual_income;
    }
    public function setAnnual_income ($_annual_income)
    {
        $this->_annual_income = $_annual_income;
    }
    public function getLandline_no ()
    {
        return $this->_landline_no;
    }
    public function setLandline_no ($_landline_no)
    {
        $this->_landline_no = $_landline_no;
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
     * 
     * @return Core_Model_RelativeMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_RelativeMapper());
        }
        return $this->_mapper;
    }
    public function setMapper ($_mapper)
    {
        $this->_mapper = $_mapper;
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
    public function getInfo ()
    {
    	$info = $this->getMapper()->fetchRelativeInfo($this);
        $this->setOptions($info);
    }
    /**
     * first set properties of object, according to which you want
     * to search,using constructor, then call the search function
     * 
     */
    public function search ()
    {
        return $this->getMapper()->fetchMember($this);
    }
}