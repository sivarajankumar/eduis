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
    public function fetchMemberTrainingDetails (
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
WHERE (`student_training`.`member_id` = ?)';
        $bind[] = $training->getMember_id();
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
     * @param Tnp_Model_Profile_Components_Training $training
     */
    public function fetchMemberTrainingIds (
    Tnp_Model_Profile_Components_Training $training)
    {
        $member_id = $training->getMember_id();
        if (! isset($member_id)) {
            throw new Exception('Insufficient Params.. $member_id is not set');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('student_training', 'training_id')
                ->where('member_id = ?', $member_id);
            $fetchall = $select->query()->fetchAll();
            $training_ids = array();
            foreach ($fetchall as $row) {
                foreach ($row as $columnName => $columnValue) {
                    if ($columnName == 'training_id') {
                        $training_ids[] = $columnValue;
                    }
                }
            }
            return $training_ids;
        }
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
            ->info('NAME')), 'member_id');
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
    /**
     * 
     * Enter description here ...
     * @param Tnp_Model_Profile_Components_Training $searchParams
     */
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
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Training $training
     */
    public function fetchTechnical_field_id (
    Tnp_Model_Profile_Components_Training $training)
    {
        $technicalFieldName = $training->getTechnical_field_name();
        $technicalSector = $training->getTechnical_sector();
        if (! isset($technicalFieldName) and ! isset($technicalSector)) {
            throw new Exception(
            'Insufficient Params.. Techsector, TechFieldName both are required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('technical_fields', 'technical_field_id')
                ->where('technical_field_name = ?', $technicalFieldName)
                ->where('technical_sector = ?', $technicalSector);
            $techFieldId = $select->query()->fetchColumn();
            $training->setTechnical_field_id($techFieldId);
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Training $training
     */
    public function fetchTechnicalFieldDetails (
    Tnp_Model_Profile_Components_Training $training)
    {
        $technical_field_id = $training->getTechnical_field_id();
        if (! isset($technical_field_id)) {
            throw new Exception(
            'Insufficient Params.. technical_field_id not set');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $requiredFields = array('technical_field_name', 'technical_sector');
            $select = $adapter->select()
                ->from('technical_fields', $requiredFields)
                ->where('technical_field_id = ?', $technical_field_id);
            $fetchall = $select->query()->fetchAll();
            $result = array();
            foreach ($fetchall as $row) {
                foreach ($row as $columnName => $columnValue) {
                    $result[$columnName] = $columnValue;
                }
            }
            return $result;
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
    public function fetchTrainingDetails (
    Tnp_Model_Profile_Components_Training $training)
    {
        $trainingId = $training->getTraining_id();
        if (! isset($trainingId)) {
            throw new Exception('Insufficient Params.. trainingId not set');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $requiredFields = array('training_technology', 'technical_field_id');
            $select = $adapter->select()
                ->from('training', $requiredFields)
                ->where('training_id = ?', $trainingId);
            $fetchall = $select->query()->fetchAll();
            $result = array();
            foreach ($fetchall as $row) {
                foreach ($row as $columnName => $columnValue) {
                    $result[$columnName] = $columnValue;
                }
            }
            return $result;
        }
    }
}