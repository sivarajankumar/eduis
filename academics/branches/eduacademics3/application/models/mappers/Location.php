<?php
class Acad_Model_Mapper_Location
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Location
     */
    public function setDbTable ($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (! $dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    /**
     * Get registered Zend_Db_Table instance
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Acad_Model_DbTable_City');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * Enter description here ...
     * @param Acad_Model_Location $location
     */
    public function fetchCountryInfo (Acad_Model_Location $location)
    {
        $country_id = $location->getCountry_id();
        if (! isset($country_id)) {
            $error = 'No country id provided';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('country_id', 'country_name' => 'name');
            $select = $adapter->select()
                ->from('country', $required_fields)
                ->where('country_id = ?', $country_id);
            $country_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            if (sizeof($country_info) == 0) {
                throw new Exception(
                'NO DATA EXISTS FOR country' . $country_id . '!!');
            } else {
                return $country_info[$country_id];
            }
        }
    }
    /**
     * 
     * Enter description here ...
     * @param Acad_Model_Location $location
     */
    public function fetchCountryId (Acad_Model_Location $location)
    {
        $country_name = $location->getCountry_name();
        if (! isset($country_name)) {
            $error = 'Please provide the Country Name';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('country_id');
            $select = $adapter->select()
                ->from('country', $required_fields)
                ->where('name = ?', $country_name);
            $country_id = $select->query()->fetchColumn();
            $location->setCountry_id($country_id);
        }
    }
    /**
     * 
     * Enter description here ...
     * @param Acad_Model_Location $location
     */
    public function fetchStateInfo (Acad_Model_Location $location)
    {
        $state_id = $location->getState_id();
        $country_id = $location->getCountry_id();
        if (! isset($country_id) or isset($state_id)) {
            $error = 'Please provide both the Country Id and State Id';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('state_id', 'state_name' => 'name');
            $select = $adapter->select()
                ->from('state', $required_fields)
                ->where('state_id = ?', $state_id)
                ->where('country_id = ?', $country_id);
            $state_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $state_info[$state_id];
        }
    }
    /**
     * 
     * Enter description here ...
     * @param Acad_Model_Location $location
     */
    public function fetchStateId (Acad_Model_Location $location)
    {
        $country_id = $location->getCountry_id();
        $state_name = $location->getState_name();
        if (! isset($country_id) or ! isset($state_name)) {
            $error = 'Please provide the Country Id and State Name';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('state_id');
            $select = $adapter->select()
                ->from('state', $required_fields)
                ->where('country_id = ?', $country_id)
                ->where('name = ?', $state_name);
            $country_id = $select->query()->fetchColumn();
            $location->setCountry_id($country_id);
        }
    }
    /**
     * 
     * Enter description here ...
     * @param Acad_Model_Location $location
     */
    public function fetchCityInfo (Acad_Model_Location $location)
    {
        $city_id = $location->getCity_id();
        $state_id = $location->getState_id();
        if (! isset($state_id) or ! isset($city_id)) {
            $error = 'Please provide both the State Id and City Id';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('city_id', 'city_name' => 'name');
            $select = $adapter->select()
                ->from('city', $required_fields)
                ->where('city_id = ?', $city_id);
            $city_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $city_info[$city_id];
        }
    }
    /**
     * 
     * Enter description here ...
     * @param Acad_Model_Location $location
     */
    public function fetchCityId (Acad_Model_Location $location)
    {
        $state_id = $location->getState_id();
        $city_name = $location->getCity_name();
        if (! isset($state_id) or ! isset($city_name)) {
            $error = 'Please provide the State Id and City Name';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('city_id');
            $select = $adapter->select()
                ->from('state', $required_fields)
                ->where('state_id = ?', $state_id)
                ->where('name = ?', $city_name);
            $country_id = $select->query()->fetchColumn();
            $location->setCountry_id($country_id);
        }
    }
}