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
    public function fetchMemberCertificationDetails (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $member_id = $certification->getMember_id();
        $certificationId = $certification->getCertification_id();
        if (! isset($member_id) or ! isset($certificationId)) {
            throw new Exception(
            'Please provide member_id and certificationID both');
        } else {
            $sql = 'SELECT
            `student_certification`.`start_date`
            , `student_certification`.`complete_date`
            , `student_certification`.`member_id`
            , `certification`.`certification_name`
            , `technical_fields`.`technical_field_name`
            , `technical_fields`.`technical_sector`
            FROM
            `tnp`.`student_certification`
            INNER JOIN `tnp`.`certification`
            ON (`student_certification`.`certification_id` = `certification`.`certification_id`)
            INNER JOIN `tnp`.`technical_fields`
            ON (`certification`.`technical_field_id` = `technical_fields`.`technical_field_id`)
            WHERE (`student_certification`.`member_id` = ?
            AND `student_certification`.`certification_id` = ?)';
            $bind[] = $member_id;
            $bind[] = $certificationId;
            $fetchall = Zend_Db_Table::getDefaultAdapter()->query($sql, $bind)->fetchAll();
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
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchMemberId (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from(
        ($this->getDbTable()
            ->info('NAME')), 'member_id');
        $searchPreReq = self::searchPreRequisite($certification);
        if ($searchPreReq == true) {
            self::fetchTechFieldId($certification);
            self::fetchCertificationId($certification);
            $select->where('certification_id = ?', 
            $certification->getCertification_id());
        }
        if (isset($certification->getStart_date())) {
            $select->where('start_date = ?', $certification->getStart_date());
        }
        if (isset($certification->getComplete_date())) {
            $select->where('complete_date = ?', 
            $certification->getComplete_date());
        }
        return $select->query()->fetchColumn();
    }
    protected function searchPreRequisite ($certification)
    {
        //search cant be made by using only one of techSec or TechFieldName.. both have to be specified
        //reason :we are looking for members with certification course ex: ccna(certName) in networking(field name) of CSE(techField)
        // this function cannot be used to search students with certification in hardware field of CSE and ECE sector together
        $techFieldName = $certification->getTechnical_field_name();
        $techSector = $certification->getTechnical_sector();
        $certiName = $certification->getCertification_name();
        if (! isset($techFieldName) or ! isset($techSector) or
         ! isset($certiName)) {
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
    public function fetchMemberCertificationIds (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $member_id = $certification->getMember_id();
        if (! isset($member_id)) {
            throw new Exception('Please set memberId first');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('student_certification', 'certification_id')
                ->where('member_id = ?', $member_id);
            $fetchall = $select->query()->fetchAll();
            $certificationIds = array();
            foreach ($fetchall as $row) {
                foreach ($row as $columnName => $columnValue) {
                    if ($columnName == 'certification_id') {
                        $certificationIds[] = $columnValue;
                    }
                }
            }
            return $certificationIds;
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
        if (! isset($technicalFieldName) or ! isset($technicalSector)) {
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
        $certificationName = $certification->getCertification_name();
        $technicalFieldId = $certification->getTechnical_field_id();
        if (! isset($certificationName) or ! isset($technicalFieldId)) {
            throw new Exception(
            'Insufficient Params.. certificationName, TechFieldId both are required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('certification', 'certification_id')
                ->where('certification_name = ?', $certificationName)
                ->where('technical_field_id = ?', $technicalFieldId);
            $certId = $select->query()->fetchColumn();
            $certification->setCertification_id($certId);
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchCertificationDetails (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $certificationId = $certification->getCertification_id();
        if (! isset($certificationId)) {
            throw new Exception('Insufficient Params.. certificationId not set');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $requiredFields = array('certification_name', 'technical_field_id');
            $select = $adapter->select()
                ->from('certification', $requiredFields)
                ->where('certification_id = ?', $certificationId);
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
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchTechnicalFieldDetails (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $technical_field_id = $certification->getTechnical_field_id();
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
}