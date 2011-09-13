<?php
class Tnp_Model_Mapper_Profile_Components_Certification
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Profile_Components_Certification
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
            $this->setDbTable('Tnp_Model_DbTable_StudentCertification');
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
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchCertificationDetails (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $sql = 'SELECT
    `student_certification`.`certification_id`
    , `student_certification`.`start_date`
    , `student_certification`.`complete_date`
    , `student_certification`.`u_regn_no`
    , `certification`.`certification_name`
    , `technical_fields`.`technical_field_name`
    , `technical_fields`.`technical_sector`
FROM
    `tnp`.`student_certification`
    INNER JOIN `tnp`.`certification` 
        ON (`student_certification`.`certification_id` = `certification`.`certification_id`)
    INNER JOIN `tnp`.`technical_fields` 
        ON (`certification`.`technical_field_id` = `technical_fields`.`technical_field_id`)
WHERE (`student_certification`.`u_regn_no` = ?)';
        $bind[] = $certification->getU_regn_no();
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
     * @param Tnp_Model_Profile_Components_Certification $searchParams
     */
    public function fetchMemberId (
    Tnp_Model_Profile_Components_Certification $searchParams)
    {
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from(
        ($this->getDbTable()
            ->info('NAME')), 'u_regn_no');
        $techFieldName = isset($searchParams->getTechnical_field_name());
        $techSector = isset($searchParams->getTechnical_sector());
        $certiName = isset($searchParams->getCertification_name());
        $searchPreReq = self::searchPreRequisite($techFieldName, $techSector, 
        $certiName);
        if ($searchPreReq == true) {
            self::fetchTechFieldId($searchParams);
            self::fetchCertificationId($searchParams);
            $select->where('certification_id = ?', 
            $searchParams->getCertification_id());
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
    $certiName)
    {
        //search cant be made by using only one of techSec or TechFieldName.. both have to be specified
        //reason :we are looking for members with certification course ex: ccna(certName) in networking(field name) of CSE(techField)
        // this function cannot be used to search students with certification in hardware field of CSE and ECE sector together
        if (! ($techFieldName) or ! ($techSector) or
         ! ($certiName)) {
            $logger = Zend_Registry::get('logger');
            $logger->debug(
            'Insufficient Params.. Techsector, TechFieldName, CetificationName are all required');
            return false;
        } else {
            return true;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchTechnical_field_id (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $technicalFieldName = $certification->getTechnical_field_name();
        $technicalSector = $certification->getTechnical_sector();
        if (! isset($technicalFieldName) and ! isset($technicalSector)) {
            $logger = Zend_Registry::get('logger');
            $logger->debug(
            'Insufficient Params.. Techsector, TechFieldName both are required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('technical_fields', 'technical_field_id')
                ->where('technical_field_name = ?', $technicalFieldName)
                ->where('technical_sector = ?', $technicalSector);
            $techFieldId = $select->query()->fetchColumn();
            $certification->setTechnical_field_id($techFieldId);
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchCertification_id (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $certName = $certification->getCertification_name();
        $technicalFieldId = $certification->getTechnical_field_id();
        if (! isset($certName) and ! isset($technicalFieldId)) {
            $logger = Zend_Registry::get('logger');
            $logger->debug(
            'Insufficient Params.. certificationName, TechFieldId both are required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('certification', 'certification_id')
                ->where('certification_name = ?', $certName)
                ->where('technical_field_id = ?', $technicalFieldId);
            $certId = $select->query()->fetchColumn();
            $certification->setCertification_id($certId);
        }
    }
}