<?php
class Acad_Model_Location
{
    protected $_country_id;
    protected $_country_name;
    protected $_state_id;
    protected $_state_name;
    protected $_city_id;
    protected $_city_name;
    protected $_mapper;
    public function getCountry_id ()
    {
        return $this->_country_id;
    }
    public function setCountry_id ($_country_id)
    {
        $this->_country_id = $_country_id;
    }
    public function getCountry_name ()
    {
        return $this->_country_name;
    }
    public function setCountry_name ($_country_name)
    {
        $this->_country_name = $_country_name;
    }
    public function getState_id ()
    {
        return $this->_state_id;
    }
    public function setState_id ($_state_id)
    {
        $this->_state_id = $_state_id;
    }
    public function getState_name ()
    {
        return $this->_state_name;
    }
    public function setState_name ($_state_name)
    {
        $this->_state_name = $_state_name;
    }
    public function getCity_id ()
    {
        return $this->_city_id;
    }
    public function setCity_id ($_city_id)
    {
        $this->_city_id = $_city_id;
    }
    public function getCity_name ()
    {
        return $this->_city_name;
    }
    public function setCity_name ($_city_name)
    {
        $this->_city_name = $_city_name;
    }
    /**
     * 
     * @param Acad_Model_Mapper_Location $mapper
     * @return Acad_Model_Location
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Location
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Location());
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
    /**
     * 
     * @throws Exception
     */
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
    public function initCountryInfo ()
    {
        $options = $this->getMapper()->fetchCountryInfo($this);
        $this->setOptions($options);
    }
    public function initStateInfo ()
    {
        $options = $this->getMapper()->fetchStateInfo($this);
        $this->setOptions($options);
    }
    public function initCityInfo ()
    {
        $options = $this->getMapper()->fetchCityInfo($this);
        $this->setOptions($options);
    }
    public function findCountryId ()
    {
        $this->getMapper()->fetchCountryId($this);
    }
    public function findStateId ()
    {
        $this->getMapper()->fetchStateId($this);
    }
    public function findCityId ()
    {
        $this->getMapper()->fetchCityId($this);
    }
}