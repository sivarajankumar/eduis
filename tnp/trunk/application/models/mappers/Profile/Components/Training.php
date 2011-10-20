<?php
class Tnp_Model_Mapper_Profile_Components_Training
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Profile_Components_Training
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
            $this->setDbTable('Tnp_Model_DbTable_StudentTraining');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @todo
     */
    public function save ()
    {}
    /**
     * 
     * @param Tnp_Model_Profile_Components_Training $training
     */
    public function fetchMemberTrainingsInfo (
    Tnp_Model_Profile_Components_Training $training)
    {
        $member_id = $training->getMember_id();
        if (! isset($member_id)) {
            $error = 'Please provide some member id to work on.';
            throw new Exception($error);
        } else {
            $required_fields = array('training_id', 'training_institute', 
            'start_date', 'completion_date', 'training_semester');
            $adapter = $this->getDbTable()->getAdapter();
            $select = $adapter->select()
                ->from($this->getDbTable()
                ->info('name'), $required_fields)
                ->where('member_id', $member_id);
            $trainings_info = array();
            $trainings_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $trainings_info;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Training $training
     */
    public function fetchTechnical_field_id (
    Tnp_Model_Profile_Components_Training $training)
    {
        $technical_field_name = $training->getTechnical_field_name();
        $technical_sector = $training->getTechnical_sector();
        if (! isset($technical_field_name) or ! isset($technical_sector)) {
            throw new Exception(
            'Insufficient Params.. Techsector, TechFieldName both are required to get tech field id');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('technical_fields', 'technical_field_id')
                ->where('technical_field_name = ?', $technical_field_name)
                ->where('technical_sector = ?', $technical_sector);
            $technical_field_id = $select->query()->fetchColumn();
            $training->setTechnical_field_id($technical_field_id);
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Training $training
     */
    public function fetchTechnicalFieldInfo (
    Tnp_Model_Profile_Components_Training $training)
    {
        $technical_field_id = $training->getTechnical_field_id();
        if (! isset($technical_field_id)) {
            throw new Exception(
            'Insufficient Params.. technical_field_id not set');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $requiredFields = array('technical_field_id', 
            'technical_field_name', 'technical_sector');
            $select = $adapter->select()
                ->from('technical_fields', $requiredFields)
                ->where('technical_field_id = ?', $technical_field_id);
            $technical_field_info = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $technical_field_info[$technical_field_id];
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Training $training
     */
    public function fetchTraining_id (
    Tnp_Model_Profile_Components_Training $training)
    {
        $trainingTechnology = $training->getTraining_technology();
        $technicalFieldId = $training->getTechnical_field_id();
        if (! isset($trainingTechnology) and ! isset($technicalFieldId)) {
            throw new Exception(
            'Insufficient Params.. trainingTechnology, technicalFieldId both are required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('training', 'training_id')
                ->where('training_technology = ?', $trainingTechnology)
                ->where('technical_field_id = ?', $technicalFieldId);
            $trainingId = $select->query()->fetchColumn();
            $training->setTraining_id($trainingId);
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Training $training
     */
    public function fetchTrainingInfo (
    Tnp_Model_Profile_Components_Training $training)
    {
        $trainingId = $training->getTraining_id();
        if (! isset($trainingId)) {
            throw new Exception('Insufficient Params.. trainingId not set');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $requiredFields = array('training_id', 'training_technology', 
            'technical_field_id');
            $select = $adapter->select()
                ->from('training', $requiredFields)
                ->where('training_id = ?', $trainingId);
            $training_info = array();
            $training_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $training_info[$trainingId];
        }
    }
    /*
    public function fetchMemberId (
    Tnp_Model_Profile_Components_Training $searchParams)
    {
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from(
        ($this->getDbTable()
            ->info('name')), 'member_id');
        //
        $searchPreReq = self::searchPreRequisite($searchParams);
        //
        $training_id = $searchParams->getTraining_id();
        $start_date = $searchParams->getStart_date();
        $complete_date = $searchParams->getComplete_date();
        if ($searchPreReq == true) {
            self::fetchTechnical_field_id($searchParams);
            self::fetchTraining_id($searchParams);
            $select->where('training_id = ?', $training_id);
        }
        if (isset($start_date)) {
            $select->where('start_date = ?', $start_date);
        }
        if (isset($complete_date)) {
            $select->where('complete_date = ?', $complete_date);
        }
        return $select->query()->fetchColumn();
    }
    
    protected function searchPreRequisite ($training)
    {
        //search cant be made by using only one of techSec or TechFieldName.. both have to be specified
        //reason :we are looking for members with certification course ex: ccna(certName) in networking(field name) of CSE(techField)
        // this function cannot be used to search students with certification in hardware field of CSE and ECE sector together
        $techFieldName = $training->getTechnical_field_name();
        $techSector = $training->getTechnical_sector();
        $trainingTech = $training->getTraining_technology();
        if (! isset($techFieldName) or ! isset($techSector) or
         ! isset($trainingTech)) {
            throw new Exception(
            'Insufficient Params.. Techsector, TechFieldName, TrainingTech name are all required');
            return false;
        } else {
            return true;
        }
    }*/
    /**
     * Enter description here ...
     * @param Tnp_Model_Profile_Components_Training $training
     * @param array $property_range Example :array('name'=>array('from'=>n ,'to'=>m));
     * here 'from' stands for >= AND 'to' stands for <=
     * 
     */
    public function fetchStudents (
    Tnp_Model_Profile_Components_Training $training, 
    array $setter_options = null, array $property_range = null)
    {
        $setter_options_keys = array_keys($setter_options);
        $property_range_keys = array_keys($property_range);
        $merge = array_merge($setter_options_keys, $property_range_keys);
        //declare table name and table columns for join statement
        $table = (array('st' => $this->getDbTable()->info('name')));
        $name1 = array('tr' => 'training');
        $cond1 = 'st.training_id = tr.training_id';
        $name2 = array('tf' => 'technical_fields');
        $cond2 = 'tr.technical_field_id = t.technical_field_id';
        //get column names of training present in arguments received
        $training_col = array('certification_name', 
        'technical_field_id');
        $training_intrsctn = array();
        $training_intrsctn = array_intersect($training_col, $merge);
        //get column names of technical_fields present in arguments received
        $technical_fields_col = array('technical_field_name', 
        'technical_sector');
        $technical_fields_intrsctn = array();
        $technical_fields_intrsctn = array_intersect($technical_fields_col, 
        $merge);
        //
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()->from($table, 'member_id');
        if (! empty($training_intrsctn)) {
            $select->join($name1, $cond1);
        }
        if (! empty($technical_fields_intrsctn)) {
            $select->join($name2, $cond2);
        }
        foreach ($property_range as $key => $range) {
            if (! empty($range['from'])) {
                $select->where("$key >= ?", $range['from']);
            }
            if (! empty($range['to'])) {
                $select->where("$key <= ?", $range['to']);
            }
        }
        foreach ($setter_options as $property_name => $value) {
            $getter_string = 'get' . ucfirst($property_name);
            $training->$getter_string();
            $condition = $property_name . ' = ?';
            $select->where($condition, $value);
        }
        return $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
    }
}