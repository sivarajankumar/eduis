<?php
class Core_Model_Address
{
    protected $_member_id;
    protected $_adress_type;
    protected $_postal_code;
    protected $_city;
    protected $_district;
    protected $_state;
    protected $_area;
    protected $_address;
    protected $_mapper;
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    public function getAdress_type ()
    {
        return $this->_adress_type;
    }
    public function setAdress_type ($_adress_type)
    {
        $this->_adress_type = $_adress_type;
    }
    public function getPostal_code ()
    {
        return $this->_postal_code;
    }
    public function setPostal_code ($_postal_code)
    {
        $this->_postal_code = $_postal_code;
    }
    public function getCity ()
    {
        return $this->_city;
    }
    public function setCity ($_city)
    {
        $this->_city = $_city;
    }
    public function getDistrict ()
    {
        return $this->_district;
    }
    public function setDistrict ($_district)
    {
        $this->_district = $_district;
    }
    public function getState ()
    {
        return $this->_state;
    }
    public function setState ($_state)
    {
        $this->_state = $_state;
    }
    public function getArea ()
    {
        return $this->_area;
    }
    public function setArea ($_area)
    {
        $this->_area = $_area;
    }
    public function getAddress ()
    {
        return $this->_address;
    }
    public function setAddress ($_address)
    {
        $this->_address = $_address;
    }
    /**
     * Set Mapper
     * @param Core_Model_Mapper_Address $mapper
     * @return Core_Model_Address
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Core_Model_Mapper_Address
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_Address());
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
    public function __get ($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
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
     * Gets address details of a member
     * You cant use it directly in 
     * controller,
     * first setMember_id and then call getter functions to retrieve properties.
     */
    public function getAddressDetails ()
    {
    	$options = $this->getMapper()->fetchAddressDetails($this);
        $this->setOptions($options);
    }
}
