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
    public function setDbTable (Zend_Db_Table_Abstract $dbTable)
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
    public function fetchTrainingDetails (
    Tnp_Model_Profile_Components_Training $training)
    {
        $sql = 'SELECT
    `training`.`training_id`
    , `training`.`training_technology`
    , `technical_fields`.`technical_field_name`
    , `technical_fields`.`technical_sector`
    , `student_training`.`training_institute`
    , `student_training`.`start_date`
    , `student_training`.`completion_date`
    , `student_training`.`training_semester`
FROM
    `tnp`.`student_training`
    INNER JOIN `tnp`.`training` 
        ON (`student_training`.`training_id` = `training`.`training_id`)
    INNER JOIN `tnp`.`technical_fields` 
        ON (`training`.`technical_field_id` = `technical_fields`.`technical_field_id`)
WHERE (`student_training`.`u_regn_no` = ?)';
        $bind[] = $training->getU_regn_no();
        $fetchall = Zend_Db_Table::getDefaultAdapter()->query($sql, $bind)->fetchAll();
        $result = array();
        foreach ($fetchall as $row) {
            foreach ($row as $columnName => $columnValue) {
                $result[$columnName] = $columnValue;
            }
        }
        return $result;
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Training $searchParams
     */
    public function fetchMemberId (
    Tnp_Model_Profile_Components_Training $searchParams)
    {
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from(
        ($this->getDbTable()
            ->info('NAME')), 'u_regn_no');
        $techFieldName = isset($searchParams->getTechnical_field_name());
        $techSector = isset($searchParams->getTechnical_sector());
        $trainingTech = isset($searchParams->getTraining_technology());
        $searchPreReq = self::searchPreRequisite($techFieldName, $techSector, 
        $trainingTech);
        if ($searchPreReq == true) {
            self::fetchTechFieldId($searchParams);
            self::fetchTrainingId($searchParams);
            $select->where('training_id = ?', $searchParams->getTraining_id());
        }
        if (isset($searchParams->getStart_date())) {
            $select->where('start_date = ?', $searchParams->getStart_date());
        }
        if (isset($searchParams->getComplete_date())) {
            $select->where('complete_date = ?', 
            $searchParams->getComplete_date());
        }
        return $select->query()->fetchColumn();
    }
    protected function searchPreRequisite ($techFieldName, $techSector, 
    $trainingTech)
    {
        //search cant be made by using only one of techSec or TechFieldName.. both have to be specified
        //reason :we are looking for members with certification course ex: ccna(certName) in networking(field name) of CSE(techField)
        // this function cannot be used to search students with certification in hardware field of CSE and ECE sector together
        if (! ($techFieldName) or ! ($techSector) or
         ! ($trainingTech)) {
            $logger = Zend_Registry::get('logger');
            $logger->debug(
            'Insufficient Params.. Techsector, TechFieldName, TrainingTech name are all required');
            return false;
        } else {
            return true;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Training $training
     */
    public function fetchTechFieldId (
    Tnp_Model_Profile_Components_Training $training)
    {
        $sql = 'SELECT
    `technical_field_id`
FROM
    `tnp`.`technical_fields`
WHERE (`technical_field_name` = ?
    AND `technical_sector` = ?)';
        $bind[] = $training->getTechnical_field_name();
        $bind[] = $training->getTechnical_sector();
        $techFieldId = Zend_Db_Table::getDefaultAdapter()->query($sql, $bind)->fetchColumn();
        $training->setTechnical_field_id($techFieldId);
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Training $training
     */
    public function fetchTrainingId (
    Tnp_Model_Profile_Components_Training $training)
    {
        $sql = 'SELECT
    `training_id`
FROM
    `tnp`.`training`
WHERE (`training_technology` = ?
    AND `technical_field_id` = ?)';
        $bind[] = $training->getTraining_technology();
        $bind[] = $training->getTechnical_field_id();
        $trainingId = Zend_Db_Table::getDefaultAdapter()->query($sql, $bind)->fetchColumn();
        $training->setTraining_id($trainingId);
    }
}