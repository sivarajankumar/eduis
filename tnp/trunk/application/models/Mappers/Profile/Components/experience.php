<?php
/**
 * @todo incomplete and non sense model :-P
 * Enter description here ...
 * 
 */
class Tnp_Model_Mapper_Profile_Components_Experience
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Profile_Components_Experience
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
            $this->setDbTable('Tnp_Model_DbTable_StudentExperience');
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
     * @param Tnp_Model_Profile_Components_Experience $experience
     */
    public function fetchExperienceDetails (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $u_regn_no = $experience->getU_regn_no();
        $cols = array(student_experience_id, u_regn_no, industry_id, 
        functional_area_id, role_id, experience_months, experience_year, 
        organisation, start_date, end_date, is_parttime, description);
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()
            ->from($this->getDbTable()
            ->info('NAME'), $cols)
            ->where('u_regn_no = ?', $u_regn_no);
        $fetchall = $adapter->fetchAll($select);
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
     * @param Tnp_Model_Profile_Components_Experience $experience
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
     *@todo 
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchTechFieldId (
    Tnp_Model_Profile_Components_Certification $experience)
    {}
    /**
     * 
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchCertificationId (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $sql = 'SELECT
    `certification_id`
FROM
    `tnp`.`certification`
WHERE (`certification_name` = ?
    AND `technical_field_id` = ?)';
        $bind[] = $certification->getCertification_name();
        $bind[] = $certification->getTechnical_field_id();
        $certId = Zend_Db_Table::getDefaultAdapter()->query($sql, $bind)->fetchColumn();
        $certification->setCertification_id($certId);
    }
}