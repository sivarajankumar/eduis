<?php
abstract class Acad_Model_Generic
{
    protected $_init_save = false;
    /**
     * @return the $_init_save
     */
    protected function getInit_save ()
    {
        return $this->_init_save;
    }
    /**
     * @param field_type $_init_save
     */
    protected function setInit_save ($_init_save)
    {
        $this->_init_save = $_init_save;
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
     * Returns an array of acessible properties of class
     * Enter description here ...
     */
    public function getAllowedProperties ()
    {
        $properties = get_class_vars(get_class($this));
        $names = array_keys($properties);
        $options = array();
        foreach ($names as $name => $value) {
            $options[] = substr($value, 1);
        }
        //put names of all properties you want to deny acess to
        $not_allowed = array('mapper');
        //return only acessible properties
        return array_diff($options, $not_allowed);
    }
    /**
     * Filters out valid options
     * maintaining key value relationship
     * @param array $options An associative array of objectProperty mapped to its value.
     * 
     */
    protected function validOptions ($options)
    {
        $validated_options = array();
        $class_properties = $this->getAllowedProperties();
        $options_keys = array_keys($options);
        $valid_options = array_intersect($options_keys, $class_properties);
        foreach ($valid_options as $valid_option) {
            $validated_options[$valid_option] = $options[$valid_option];
        }
        if (sizeof($validated_options) == 0) {
            $error = 'No valid option was provided';
            throw new Exception($error);
        } else {
            return $validated_options;
        }
    }
    /**
     * Filters out invalid options
     * @param array $options An associative array of objectProperty mapped to its value.
     * 
     */
    protected function invalidOptions ($options)
    {
        $class_properties = $this->getAllowedProperties();
        $options_keys = array_keys($options);
        $invalidOptions = array_diff($options_keys, $class_properties);
        foreach ($invalidOptions as $invalidOption) {
            $validation_failed[$invalidOption] = $options[$invalidOption];
        }
        return $validation_failed;
    }
    /**
     * Sets all object properties to null
     * Enter description here ...
     */
    protected function unsetAll ()
    {
        $properties = $this->getAllowedProperties();
        foreach ($properties as $name) {
            $str = "set" . ucfirst($name);
            $this->$str(null);
        }
    }
    /**
     * Initialises the save process
     * by calling unsetAll
     */
    public function initSave ()
    {
        $this->unsetAll();
        $this->setInit_save(true);
    }
    /**
     * Saves Object to database
     * 
     * @param array $options
     */
    public function save ($options)
    {
        if ($this->getInit_save() == true) {
            $properties = $this->getAllowedProperties();
            $recieved = array_keys($options);
            $valid_props = array_intersect($recieved, $properties);
            foreach ($valid_props as $value) {
                $setter_options[$value] = $options[$value];
            }
            if (! empty($setter_options)) {
                $this->setOptions($setter_options);
                $this->getMapper()->save($setter_options, $this);
            } else {
                throw new Exception(
                'No valid option was supplied for save process');
            }
        } else {
            throw new Exception('Save not initialised');
        }
    }
    /**
     * Enter description here ...
     * @param array $options containing properties mapped to values
     * @param array $property_range containing properties mapped to array containing upper and lower range
     * @throws Exception when trying to set equality and range both ,for property, at the same time
     * @throws Exception when invalid properties are specified 
     * @return array containing Member Ids
     */
    public function search (array $options = null, array $property_range = null)
    {
        //declaration necessary because their scope is required to be throughout the function
        $setter_options = array();
        $valid_options = array();
        $invalid_names = array();
        $property_range_keys = array();
        $valid_range_keys = array();
        $invalid_names_1 = array();
        $range = array();
        $error1 = '';
        $error2 = '';
        if (! empty($options)) {
            //$setter_options array is now ready for search
            //but will it participate,is not confirmed
            $setter_options = $this->validOptions(
            $options);
            $invalid_names = array_keys($this->invalidOptions($options));
            if (! empty($invalid_names)) {
                $error1 = "<b>" . implode(', ', $invalid_names) . "</b>";
            }
        }
        if (! empty($property_range)) {
            $range = $this->validOptions($property_range);
            $invalid_names_1 = array_keys(
            $this->invalidOptions($property_range));
            if (! empty($invalid_names_1)) {
                $error2 = "<b>" . implode(', ', $invalid_names_1) . "</b>";
            }
        }
        $error_append = ' are invalid parameters and therefore, they were not included in search.';
        $suggestion = 'Please try again with correct parameters to get more accurate results';
        $message = "$error_append " . "</br>" . "$suggestion";
        $deciding_intersection = array_intersect($valid_options, 
        $valid_range_keys);
        $size= sizeof($invalid_names);
        $size1= sizeof($invalid_names_1);
        if ($size == 0 or $size1 == 0) {
            Zend_Registry::get('logger')->debug(
            var_export($error1 . ' ' . $error2 . $message));
            echo "</br>";
        }
        if (empty($deciding_intersection)) {
            //now we can set off for search operation
            $this->setOptions($setter_options);
            return $this->getMapper()->fetchStudents($this, $setter_options, 
            $range);
        } else {
            $error = implode(', ', $deciding_intersection);
            throw new Exception(
            'Range and equality cannot be set for ' . $error .
             ' at the same time');
        }
    }
}
