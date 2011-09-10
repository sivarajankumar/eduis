<?php
class Tnp_Model_Profile_Components_Training
{
    protected $_training_id;
    protected $_training_technology;
    protected $_technical_field_id;
    protected $_technical_field_name;
    protected $_technical_sector;
    protected $_training_institute;
    protected $_start_date;
    protected $_completion_date;
    protected $_training_semester;
    protected $_u_regn_no;
    protected $_mapper;
    public function getTraining_id ()
    {
        return $this->_training_id;
    }
    public function getTraining_technology ()
    {
        return $this->_training_technology;
    }
    public function getTechnical_field_id ()
    {
        return $this->_technical_field_id;
    }
    public function getTechnical_field_name ()
    {
        return $this->_technical_field_name;
    }
    public function getTechnical_sector ()
    {
        return $this->_technical_sector;
    }
    public function getTraining_institute ()
    {
        return $this->_training_institute;
    }
    public function getStart_date ()
    {
        return $this->_start_date;
    }
    public function getCompletion_date ()
    {
        return $this->_completion_date;
    }
    public function getTraining_semester ()
    {
        return $this->_training_semester;
    }
    public function getU_regn_no ()
    {
        return $this->_u_regn_no;
    }
    public function setTraining_id ($_training_id)
    {
        $this->_training_id = $_training_id;
    }
    public function setTraining_technology ($_training_technology)
    {
        $this->_training_technology = $_training_technology;
    }
    public function setTechnical_field_id ($_technical_field_id)
    {
        $this->_technical_field_id = $_technical_field_id;
    }
    public function setTechnical_field_name ($_technical_field_name)
    {
        $this->_technical_field_name = $_technical_field_name;
    }
    public function setTechnical_sector ($_technical_sector)
    {
        $this->_technical_sector = $_technical_sector;
    }
    public function setTraining_institute ($_training_institute)
    {
        $this->_training_institute = $_training_institute;
    }
    public function setStart_date ($_start_date)
    {
        $this->_start_date = $_start_date;
    }
    public function setCompletion_date ($_completion_date)
    {
        $this->_completion_date = $_completion_date;
    }
    public function setTraining_semester ($_training_semester)
    {
        $this->_training_semester = $_training_semester;
    }
    public function setU_regn_no ($_u_regn_no)
    {
        $this->_u_regn_no = $_u_regn_no;
    }
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Profile_Components_TrainingMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Profile_Components_TrainingMapper());
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
     * Gets Subject information
     * You cant use it directly in 
     * controller,
     * first setSubjectCode and then call getter functions to retrieve properties.
     */
    public function getTrainingDetails ()
    {
        $options = $this->getMapper()->fetchTrainingDetails($this);
        $this->setOptions($options);
    }
}