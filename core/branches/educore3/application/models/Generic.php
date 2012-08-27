<?php
abstract class Core_Model_Generic
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
        $class_name = get_class($this);
        $method = 'set' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw new Exception(
            'Invalid property : ' . $name . ' ,specified in class :' .
             $class_name);
        }
        $this->$method($value);
    }
    public function __get ($name)
    {
        $class_name = get_class($this);
        $method = 'get' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw new Exception(
            'Invalid property : ' . $name . ' ,specified in class :' .
             $class_name);
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
        $not_allowed = array('mapper', 'init_save');
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
        if (empty($validated_options)) {
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
        $validation_failed = array();
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
    protected function validateData ($data_to_validate)
    {
        $this->setOptions($data_to_validate);
        //now, preparing validated database operations
        $preparedDataForSaveProcess = array();
        foreach ($data_to_validate as $valid_key => $value_to_validate) {
            $getter_string = 'get' . ucfirst($valid_key);
            $validated_value = $this->$getter_string();
            $validatedData[$valid_key] = $value_to_validate;
        }
        return $validatedData;
    }
    /**
     * 
     * Filters genuine data for saving process
     * @param array $data
     * @throws Exception
     * @return array
     */
    public function prepareDataForSaveProcess ($data)
    {
        $init_save_status = $this->getInit_save();
        if ($init_save_status) {
            $all_allowed_props = $this->getAllowedProperties();
            $recieved_props = array_keys($data);
            $valid_props = array_intersect($recieved_props, $all_allowed_props);
            foreach ($valid_props as $value) {
                $data_to_validate[$value] = $data[$value];
            }
            if (! empty($data_to_validate)) {
                //now, preparing validated database operations
                $validated_data = $this->validateData(
                $data_to_validate);
                $preparedDataForSaveProcess = array();
                foreach ($validated_data as $valid_key => $valid_value) {
                    $db_column_name = $this->correctDbKeys($valid_key);
                    $preparedDataForSaveProcess[$db_column_name] = $valid_value;
                }
                return $preparedDataForSaveProcess;
            } else {
                throw new Exception(
                'No Valid Data was supplied for save process');
            }
        } else {
            throw new Exception(
            'Please initialise the save process prior to saving data');
        }
    }
    /**
     * Enter description here ...
     * @param array $options containing properties mapped to values
     * @param array $range_op containing properties mapped to array containing upper and lower range
     * @throws Exception when invalid properties are specified 
     * @return array containing Member Ids
     */
    public function search (array $exact_params = null, array $range_params = null)
    {
        $valid_options = array();
        $invalid_options = array();
        $valid_range_keys = array();
        $invalid_range_params = array();
        if (! empty($exact_params)) {
            $valid_options = $this->validOptions($exact_params);
            $invalid_options = array_keys($this->invalidOptions($exact_params));
        }
        if (! empty($range_params)) {
            $valid_range_keys = $this->validOptions($range_params);
            $invalid_range_params = array_keys(
            $this->invalidOptions($range_params));
        }
        $error_append = ' is(are) invalid parameter(s), and were therefore not included in search.';
        $suggestion = 'Please try again with correct parameters to get more accurate results';
        $message = "$error_append " . ' ' . "$suggestion";
        $deciding_intersection = array_intersect($valid_options, 
        $valid_range_keys);
        if (! empty($invalid_options) or ! empty($invalid_range_params)) {
            $garbage = array_merge($invalid_range_params, $invalid_options);
            Zend_Registry::get('logger')->debug(
            '[ ' . implode($garbage, ', ') . ']' . $message);
        }
        if (empty($deciding_intersection)) {
            return $this->getMapper()->fetchStudents($valid_options, 
            $valid_range_keys);
        } else {
            return null;
        }
    }
}
