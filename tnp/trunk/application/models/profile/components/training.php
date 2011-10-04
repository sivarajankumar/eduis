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
    protected $_member_id;
    protected $_mapper;
    /**
     * Set Mapper
     * @param Tnp_Model_Mapper_Profile_Components_Training $mapper
     * @return Tnp_Model_Profile_Components_Training
     */
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
            $this->setMapper(new Tnp_Model_Mapper_Profile_Components_Training());
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
     * @return the $_training_id
     */
    public function getTraining_id ()
    {
        return $this->_training_id;
    }
    /**
     * @param field_type $_training_id
     */
    public function setTraining_id ($_training_id)
    {
        $this->_training_id = $_training_id;
    }
    /**
     * @return the $_training_technology
     */
    public function getTraining_technology ()
    {
        return $this->_training_technology;
    }
    /**
     * @param field_type $_training_technology
     */
    public function setTraining_technology ($_training_technology)
    {
        $this->_training_technology = $_training_technology;
    }
    /**
     * @return the $_technical_field_id
     */
    public function getTechnical_field_id ()
    {
        return $this->_technical_field_id;
    }
    /**
     * @param field_type $_technical_field_id
     */
    public function setTechnical_field_id ($_technical_field_id)
    {
        $this->_technical_field_id = $_technical_field_id;
    }
    /**
     * @return the $_technical_field_name
     */
    public function getTechnical_field_name ()
    {
        return $this->_technical_field_name;
    }
    /**
     * @param field_type $_technical_field_name
     */
    public function setTechnical_field_name ($_technical_field_name)
    {
        $this->_technical_field_name = $_technical_field_name;
    }
    /**
     * @return the $_technical_sector
     */
    public function getTechnical_sector ()
    {
        return $this->_technical_sector;
    }
    /**
     * @param field_type $_technical_sector
     */
    public function setTechnical_sector ($_technical_sector)
    {
        $this->_technical_sector = $_technical_sector;
    }
    /**
     * @return the $_training_institute
     */
    public function getTraining_institute ()
    {
        return $this->_training_institute;
    }
    /**
     * @param field_type $_training_institute
     */
    public function setTraining_institute ($_training_institute)
    {
        $this->_training_institute = $_training_institute;
    }
    /**
     * @return the $_start_date
     */
    public function getStart_date ()
    {
        return $this->_start_date;
    }
    /**
     * @param field_type $_start_date
     */
    public function setStart_date ($_start_date)
    {
        $this->_start_date = $_start_date;
    }
    /**
     * @return the $_completion_date
     */
    public function getCompletion_date ()
    {
        return $this->_completion_date;
    }
    /**
     * @param field_type $_completion_date
     */
    public function setCompletion_date ($_completion_date)
    {
        $this->_completion_date = $_completion_date;
    }
    /**
     * @return the $_training_semester
     */
    public function getTraining_semester ()
    {
        return $this->_training_semester;
    }
    /**
     * @param field_type $_training_semester
     */
    public function setTraining_semester ($_training_semester)
    {
        $this->_training_semester = $_training_semester;
    }
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
    public function getMemberTrainingDetails ()
    {
        $options = $this->getMapper()->fetchTrainingDetails($this);
        $this->setOptions($options);
    }
    public function getMemberTrainingIds ()
    {
        $options = $this->getMapper()->fetchMemberTrainingIds($this);
        $this->setOptions($options);
    }
}