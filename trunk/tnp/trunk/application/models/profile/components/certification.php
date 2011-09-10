<?php
class Tnp_Model_Profile_Components_Certification
{
    protected $_certification_id;
    protected $_certification_name;
    protected $_technical_field_id;
    protected $_technical_field_name;
    protected $_technical_sector;
    protected $_u_regn_no;
    protected $_start_date;
    protected $_complete_date;
    protected $_mapper;
    public function getCertification_id ()
    {
        return $this->_certification_id;
    }
    public function setCertification_id ($_certification_id)
    {
        $this->_certification_id = $_certification_id;
    }
    public function getCertification_name ()
    {
        return $this->_certification_name;
    }
    public function setCertification_name ($_certification_name)
    {
        $this->_certification_name = $_certification_name;
    }
    public function getTechnical_field_id ()
    {
        return $this->_technical_field_id;
    }
    public function setTechnical_field_id ($_technical_field_id)
    {
        $this->_technical_field_id = $_technical_field_id;
    }
    public function getTechnical_field_name ()
    {
        return $this->_technical_field_name;
    }
    public function setTechnical_field_name ($_technical_field_name)
    {
        $this->_technical_field_name = $_technical_field_name;
    }
    public function getTechnical_sector ()
    {
        return $this->_technical_sector;
    }
    public function setTechnical_sector ($_technical_sector)
    {
        $this->_technical_sector = $_technical_sector;
    }
    public function getU_regn_no ()
    {
        return $this->_u_regn_no;
    }
    public function setU_regn_no ($_u_regn_no)
    {
        $this->_u_regn_no = $_u_regn_no;
    }
    public function getStart_date ()
    {
        return $this->_start_date;
    }
    public function setStart_date ($_start_date)
    {
        $this->_start_date = $_start_date;
    }
    public function getComplete_date ()
    {
        return $this->_complete_date;
    }
    public function setComplete_date ($_complete_date)
    {
        $this->_complete_date = $_complete_date;
    }
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Profile_Components_CertificationMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(
            new Tnp_Model_Profile_Components_CertificationMapper());
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
     * Gets certification information
     * You cant use it directly in 
     * controller,
     * first set univ reg no first and then call getter functions to retrieve properties.
     */
    public function getDetails ()
    {
        $options = $this->getMapper()->fetchCertificationDetails($this);
        $this->setOptions($options);
    }
}